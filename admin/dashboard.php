<?php
require_once '../admin/includes/security_headers.php'; // Inclure les en-têtes de sécurité en premier
require_once '../admin/includes/auth.php';
require_once '../lib/pdo.php';

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Vérification du rôle de l'utilisateur
if ($_SESSION['role'] !== 'admin') {
    $unauthorized = true;
    // Arrêter l'exécution du reste du code
    exit();
}

// Vérifier le token CSRF 
if (!isset($_POST['csrf_token']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    die("Token CSRF manquant");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))) {
    die("Token CSRF invalide");
}

// Régénérer le token CSRF
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Récupérer des statistiques basiques avec des requêtes préparées
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM projets");
    $stmt->execute();
    $projetsCount = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM images");
    $stmt->execute();
    $imagesCount = $stmt->fetchColumn();
} catch (PDOException $e) {
    error_log($e->getMessage()); // Enregistrer l'erreur dans le log
    $error = "Une erreur est survenue, veuillez réessayer plus tard."; // Message générique pour l'utilisateur
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Administration FLD Agencement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <main class="dashboard-container px-4 text-center">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                    <h1 class="h2 mt-5">Tableau de bord</h1>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"> <?= $error ?> </div>
                <?php endif; ?>

                <!-- Vérification des permissions de l'utilisateur -->
                <?php if (isset($unauthorized) && $unauthorized): ?>
                    <div class="modal fade" id="unauthorizedModal" tabindex="-1" aria-labelledby="unauthorizedModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="unauthorizedModalLabel">Accès refusé</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Vous n'avez pas les permissions nécessaires pour accéder à ce tableau de bord.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var myModal = new bootstrap.Modal(document.getElementById('unauthorizedModal'));
                            myModal.show();
                        });
                    </script>
                <?php endif; ?>

                <div class="row">
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="admin-card admin-stats-card admin-stats-primary shadow">
                            <div>
                                <div>Projets</div>
                                <div class="fs-3"> <?= htmlspecialchars($projetsCount) ?> </div>
                            </div>
                            <i class="fas fa-folder fs-1"></i>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="admin-card admin-stats-card admin-stats-success shadow">
                            <div>
                                <div>Images</div>
                                <div class="fs-3"> <?= htmlspecialchars($imagesCount) ?> </div>
                            </div>
                            <i class="fas fa-images fs-1"></i>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="admin-card shadow mb-4">
                            <h6 class="mb-3">Actions rapides</h6>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <a href="projets.php" class="admin-button admin-button-primary w-100 text-center d-block">
                                        <i class="fas fa-folder-plus"></i> Gérer les projets
                                    </a>
                                </div>
                                <div class="col-12 mb-2">
                                    <a href="../index.php" target="_blank" class="admin-button admin-button-info w-100 text-center d-block">
                                        <i class="fas fa-eye"></i> Voir le site
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>