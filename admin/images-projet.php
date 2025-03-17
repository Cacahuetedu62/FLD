<?php
require_once '../admin/includes/security_headers.php'; // Inclure les en-têtes de sécurité en premier
require_once '../admin/includes/auth.php';
require_once '../lib/pdo.php';

// Vérifier qu'un projet_id est spécifié
if (!isset($_GET['projet_id']) || !is_numeric($_GET['projet_id'])) {
    header('Location: projets.php');
    exit;
}

// Vérifier le token CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))) {
    die("Token CSRF invalide");
}

// Régénérer le token pour les prochaines requêtes
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$projet_id = (int) $_GET['projet_id'];

// Récupérer les informations du projet
try {
    $stmt = $pdo->prepare("SELECT * FROM projets WHERE id = ?");
    $stmt->execute([$projet_id]);
    $projet = $stmt->fetch();
    
    if (!$projet) {
        $error = "Projet non trouvé";
    }
} catch (PDOException $e) {
    $error = "Erreur: " . $e->getMessage();
}

// Récupérer les images du projet
try {
    $stmt = $pdo->prepare("SELECT * FROM images WHERE projet_id = ?");
    $stmt->execute([$projet_id]);
    $images = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Erreur de récupération des images: " . $e->getMessage();
}

// Gérer la suppression d'une image
if (isset($_GET['delete_image']) && is_numeric($_GET['delete_image'])) {
    try {
        $image_id = (int) $_GET['delete_image'];
        
        // Récupérer le chemin de l'image pour pouvoir la supprimer du serveur
        $stmt = $pdo->prepare("SELECT chemin FROM images WHERE id = ?");
        $stmt->execute([$image_id]);
        $image = $stmt->fetch();
        
        if ($image) {
            // Supprimer le fichier physique (si le chemin est relatif au serveur)
            $filePath = '../' . $image['chemin'];
            if (is_file($filePath)) {
                unlink($filePath);
            }
            
            // Supprimer l'entrée de la base de données
            $stmt = $pdo->prepare("DELETE FROM images WHERE id = ?");
            $stmt->execute([$image_id]);
            
            $success = "Image supprimée avec succès";
            
            // Rediriger pour éviter les re-soumissions
            header("Location: images-projet.php?projet_id=" . $projet_id . "&success=deleted");
            exit;
        }
    } catch (PDOException $e) {
        $error = "Erreur de suppression: " . $e->getMessage();
    }
}

// Message de succès si redirection après suppression
if (isset($_GET['success']) && $_GET['success'] === 'deleted') {
    $success = "Image supprimée avec succès";
}

// Traitement de l'upload d'images
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {
    $uploadDir = '../images/projets/';
    
    // Créer le répertoire s'il n'existe pas
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $uploadedFiles = [];
    $errors = [];
    
    // Gérer les uploads multiples
    $fileCount = count($_FILES['images']['name']);
    
    for ($i = 0; $i < $fileCount; $i++) {
        if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['images']['tmp_name'][$i];
            $originalName = $_FILES['images']['name'][$i];
            $fileInfo = pathinfo($originalName);
            $extension = strtolower($fileInfo['extension']);
            
            // Vérifier l'extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($extension, $allowedExtensions)) {
                $errors[] = "L'extension " . $extension . " n'est pas autorisée pour le fichier " . $originalName;
                continue;
            }
            
            // Vérifier le type MIME du fichier
            $mimeType = mime_content_type($tmpName);
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($mimeType, $allowedMimeTypes)) {
                $errors[] = "Le type MIME du fichier " . $originalName . " n'est pas autorisé.";
                continue;
            }
            
            // Vérifier la taille du fichier (max 5 Mo)
            if ($_FILES['images']['size'][$i] > 5 * 1024 * 1024) {
                $errors[] = "Le fichier " . $originalName . " est trop volumineux. La taille maximale est de 5 Mo.";
                continue;
            }
            
            // Vérifier les dimensions de l'image (par exemple, limite de 3000px de largeur et hauteur)
            list($width, $height) = getimagesize($tmpName);
            if ($width > 3000 || $height > 3000) {
                $errors[] = "L'image " . $originalName . " est trop grande. La largeur et la hauteur doivent être inférieures à 3000px.";
                continue;
            }
            
            // Générer un nom de fichier unique
            $newFileName = 'projet_' . $projet_id . '_' . uniqid() . '.' . $extension;
            $destination = $uploadDir . $newFileName;
            
            // Déplacer le fichier
            if (move_uploaded_file($tmpName, $destination)) {
                // Chemin relatif pour stocker dans la base de données
                $relativePath = 'images/projets/' . $newFileName;
                
                // Enregistrer dans la base de données
                $stmt = $pdo->prepare("INSERT INTO images (projet_id, chemin) VALUES (?, ?)");
                $stmt->execute([$projet_id, $relativePath]);
                
                $uploadedFiles[] = $relativePath;
            } else {
                $errors[] = "Erreur lors de l'upload de " . $originalName;
            }
        } else {
            if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_NO_FILE) {
                $errors[] = "Erreur code " . $_FILES['images']['error'][$i] . " pour le fichier " . $originalName;
            }
        }
    }
    
    if (!empty($uploadedFiles)) {
        $success = count($uploadedFiles) . " image(s) uploadée(s) avec succès";
        // Recharger les images
        $stmt = $pdo->prepare("SELECT * FROM images WHERE projet_id = ?");
        $stmt->execute([$projet_id]);
        $images = $stmt->fetchAll();
    }
    
    if (!empty($errors)) {
        $error = implode("<br>", $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des images - Administration FLD Agencement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
    <style>
        .image-preview {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-fluid">
        <div class="row justify-content-center p-5">
            <main class="col-lg-10 px-md-4 mx-auto">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Images du projet: <?= htmlspecialchars($projet['titre']) ?></h1>
                    <a href="projets.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour aux projets
                    </a>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"> <?= $error ?> </div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"> <?= $success ?> </div>
                <?php endif; ?>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Ajouter des images</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <div class="mb-3">
                                <label for="images" class="form-label">Sélectionner des images</label>
                                <input class="form-control" type="file" id="images" name="images[]" multiple accept="image/*">
                                <small class="text-muted">Formats acceptés: JPG, JPEG, PNG, GIF.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Uploader les images
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Images existantes</h6>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($images)): ?>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                                <?php foreach ($images as $image): ?>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img loading="lazy" src="../<?= htmlspecialchars($image['chemin']) ?>" class="image-preview" alt="Image du projet">
                                            <div class="card-body text-center">
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteImageModal<?= $image['id'] ?>">
                                                    <i class="fas fa-trash me-1"></i>Supprimer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal de confirmation de suppression pour cette image -->
                                    <div class="modal fade" id="deleteImageModal<?= $image['id'] ?>" tabindex="-1" aria-labelledby="deleteImageModalLabel<?= $image['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteImageModalLabel<?= $image['id'] ?>">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Êtes-vous sûr de vouloir supprimer cette image ?</p>
                                                    <div class="text-center mb-3">
                                                        <img loading="lazy" src="../<?= htmlspecialchars($image['chemin']) ?>" class="img-fluid" style="max-height: 200px;" alt="Image à supprimer">
                                                    </div>
                                                    <p class="text-danger">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>Attention : Cette action ne peut pas être annulée.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <a href="images-projet.php?projet_id=<?= $projet_id ?>&delete_image=<?= $image['id'] ?>" class="btn btn-danger">
                                                        <i class="fas fa-trash me-1"></i>Confirmer la suppression
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>Aucune image n'a encore été ajoutée.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>