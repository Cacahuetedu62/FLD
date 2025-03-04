<?php
require_once '../admin/includes/auth.php';
require_once '../lib/pdo.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer tous les projets
try {
    $stmt = $pdo->query("SELECT * FROM projets ORDER BY date DESC");
    $projets = $stmt->fetchAll();
} catch (PDOException $e) {
    // Enregistrer l'erreur dans un fichier de log
    error_log("Erreur de récupération des projets: " . $e->getMessage());
    $error = "Une erreur est survenue lors de la récupération des projets.";
}

// Gérer la suppression d'un projet avec vérification CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && is_numeric($_POST['delete'])) {
    // Vérifier le token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        error_log("Token CSRF invalide.");
        die("Action non autorisée.");
    }

    $projetId = (int) $_POST['delete'];

    // Vérifiez que le projet existe avant de le supprimer
    $stmtCheck = $pdo->prepare("SELECT id FROM projets WHERE id = ?");
    $stmtCheck->execute([$projetId]);
    $projet = $stmtCheck->fetch();

    if (!$projet) {
        // Si le projet n'existe pas, interdire la suppression
        error_log("Tentative de suppression d'un projet inexistant.");
        $error = "Le projet n'existe pas.";
    } else {
        // Supprimer d'abord les images liées
        try {
            $stmtDeleteImages = $pdo->prepare("DELETE FROM images WHERE projet_id = ?");
            $stmtDeleteImages->execute([$projetId]);

            // Puis supprimer le projet
            $stmtDeleteProjet = $pdo->prepare("DELETE FROM projets WHERE id = ?");
            $stmtDeleteProjet->execute([$projetId]);

            $success = "Projet et ses images supprimés avec succès";
            header("Location: projets.php?success=deleted");
            exit;
        } catch (PDOException $e) {
            // Enregistrer l'erreur dans un fichier de log
            error_log("Erreur de suppression: " . $e->getMessage());
            $error = "Une erreur est survenue lors de la suppression du projet.";
        }
    }
}

// Message de succès si redirection après suppression
if (isset($_GET['success']) && $_GET['success'] === 'deleted') {
    $success = "Projet supprimé avec succès";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des projets - Administration FLD Agencement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>

<body class="admin-wrapper">
    <?php include 'includes/header.php'; ?>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <main class="container p-5">
                <h1 class="h2 mb-3">Gestion des projets</h1>
                <div class="d-flex justify-content-between mb-3">
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Tableau de bord
                    </a>
                    <a href="projet-create.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nouveau projet
                    </a>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"> <?= htmlspecialchars($error) ?> </div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"> <?= htmlspecialchars($success) ?> </div>
                <?php endif; ?>

                <div class="project-list">
                    <?php if (!empty($projets)): ?>
                        <?php foreach ($projets as $projet): ?>
                            <div class="project-card">
                                <h5><?= htmlspecialchars($projet['titre'], ENT_QUOTES, 'UTF-8', false) ?></h5>
                                <p><strong>Sous-titre :</strong> <?= htmlspecialchars($projet['sous_titre'], ENT_QUOTES, 'UTF-8', false) ?></p>
                                <p><strong>Date :</strong> <?= htmlspecialchars($projet['date'], ENT_QUOTES, 'UTF-8', false) ?></p>
                                <p><strong>Lieu :</strong> <?= htmlspecialchars($projet['lieu'], ENT_QUOTES, 'UTF-8', false) ?></p>
                                <p><strong>Type :</strong> <?= htmlspecialchars($projet['type_travaux'], ENT_QUOTES, 'UTF-8', false) ?></p>
                                <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($projet['description'], ENT_QUOTES, 'UTF-8', false)) ?></p>

                                <p><strong>Images :</strong>
                                    <?php
                                    $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM images WHERE projet_id = ?");
                                    $stmtCount->execute([$projet['id']]);
                                    echo $stmtCount->fetchColumn();
                                    ?>
                                </p>
                                <div class="project-actions">
                                    <a href="projet-edit.php?id=<?= $projet['id'] ?>" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <a href="images-projet.php?projet_id=<?= $projet['id'] ?>" class="btn btn-info">
                                        <i class="fas fa-images"></i> Images
                                    </a>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $projet['id'] ?>">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </div>
                            </div>

                            <!-- Modal de confirmation de suppression pour ce projet -->
                            <div class="modal fade" id="deleteModal<?= $projet['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $projet['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel<?= $projet['id'] ?>">Confirmation de suppression</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer ce projet : <strong><?= htmlspecialchars($projet['titre']) ?></strong> ?
                                            <p class="text-danger mt-2">
                                                <i class="fas fa-exclamation-triangle"></i> Attention : Cette action supprimera également toutes les images associées à ce projet et ne peut pas être annulée.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <form action="projets.php" method="POST" class="d-inline">
                                                <input type="hidden" name="delete" value="<?= $projet['id'] ?>">
                                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i> Confirmer la suppression
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted">Aucun projet trouvé.</p>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
