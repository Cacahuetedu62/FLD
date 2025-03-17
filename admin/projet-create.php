<?php
require_once __DIR__ . '/includes/security_headers.php';
require_once '../admin/includes/auth.php';
require_once '../lib/pdo.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  // Générer un token CSRF
}

$isEdit = false; // Assurez-vous de définir cette variable selon votre logique
$titre = $sous_titre = $date = $lieu = $type_travaux = $description = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification du token CSRF
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Token CSRF invalide.";
    } else {
        // Récupérer et valider les données
        $titre = trim($_POST['titre']);
        $sous_titre = trim($_POST['sous_titre']);
        $date = trim($_POST['date']);
        $lieu = trim($_POST['lieu']);
        $type_travaux = trim($_POST['type_travaux']);
        $description = trim($_POST['description']);

        // Validation des champs obligatoires
        if (empty($titre) || empty($date)) {
            $error = "Le titre et la date sont obligatoires.";
        }

        if (!$error) {
            try {
                // Requête SQL pour insérer les données
                global $pdo;
                $sql = "INSERT INTO projets (titre, sous_titre, date, lieu, type_travaux, description) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$titre, $sous_titre, $date, $lieu, $type_travaux, $description]);

                $success = "Projet créé avec succès.";
            } catch (PDOException $e) {
                $error = "Erreur lors de la création du projet : " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Modifier' : 'Ajouter' ?> un projet - Administration FLD Agencement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body class="admin-wrapper">
    <?php include 'includes/header.php'; ?>

    <div class="container-fluid p-0">
        <div class="row g-0 d-flex justify-content-center">
            <main class="col-12 col-md-9 d-flex justify-content-center">
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2"><?= $isEdit ? 'Modifier' : 'Ajouter' ?> un projet</h1>
                        <a href="projets.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-<?= $isEdit ? 'edit' : 'plus-circle' ?> me-2"></i>
                                <?= $isEdit ? 'Informations du projet' : 'Nouveau projet' ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="mb-3">
                                            <label for="titre" class="form-label">
                                                Titre<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($titre, ENT_QUOTES, 'UTF-8') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="sous_titre" class="form-label">Sous-titre</label>
                                            <input type="text" class="form-control" id="sous_titre" name="sous_titre" value="<?= htmlspecialchars($sous_titre, ENT_QUOTES, 'UTF-8') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?>" max="<?= date('Y-m-d') ?>" required>
                                            <small class="form-text text-muted">Sélectionnez une date (aujourd'hui ou dans le passé)</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <div class="mb-3">
                                            <label for="lieu" class="form-label">Lieu</label>
                                            <input type="text" class="form-control" id="lieu" name="lieu" value="<?= htmlspecialchars($lieu, ENT_QUOTES, 'UTF-8') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="type_travaux" class="form-label">Type de travaux</label>
                                            <input type="text" class="form-control" id="type_travaux" name="type_travaux" value="<?= htmlspecialchars($type_travaux, ENT_QUOTES, 'UTF-8') ?>">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="5"><?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> <?= $isEdit ? 'Mettre à jour' : 'Créer' ?> le projet
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
