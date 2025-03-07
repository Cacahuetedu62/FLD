<?php
require_once '../admin/includes/auth.php';
require_once '../lib/pdo.php';


// Vérifier l'authentification de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Rediriger si non authentifié
    exit;
}

// Vérification de l'ID dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: projets.php?error=invalid");
    exit;
}

$id = (int)$_GET['id'];

// Récupérer les données du projet
$stmt = $pdo->prepare("SELECT * FROM projets WHERE id = ?");
$stmt->execute([$id]);
$projet = $stmt->fetch();

if (!$projet) {
    header("Location: projets.php?error=notfound");
    exit;
}

// Si le formulaire est soumis, traiter les données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Token CSRF invalide.");
    }

    // Récupérer les données envoyées par le formulaire
    $titre = $_POST['titre'] ?? '';
    $sous_titre = $_POST['sous_titre'] ?? '';
    $date = $_POST['date'] ?? '';
    $lieu = $_POST['lieu'] ?? '';
    $type_travaux = $_POST['type_travaux'] ?? '';
    $description = $_POST['description'] ?? '';

    // Mettre à jour le projet dans la base de données
    $stmt = $pdo->prepare("UPDATE projets SET titre = ?, sous_titre = ?, date = ?, lieu = ?, type_travaux = ?, description = ? WHERE id = ?");
    
    if ($stmt->execute([$titre, $sous_titre, $date, $lieu, $type_travaux, $description, $id])) {
        // Régénérer le token après utilisation
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        header("Location: projets.php?success=updated");
        exit;
    }
}

// Générer un token CSRF pour protéger le formulaire
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
                <div class="container mt-5">
                    <h1>Modifier le projet</h1>
                    <div class="d-flex justify-content-between mb-3">
                        <a href="dashboard.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Tableau de bord
                        </a>
                    </div>

                    <!-- Formulaire de modification du projet -->
                    <form method="POST">
                        <!-- Token CSRF -->
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <input type="text" name="titre" id="titre" class="form-control" value="<?= htmlspecialchars($projet['titre']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="sous_titre" class="form-label">Sous-titre</label>
                            <input type="text" name="sous_titre" id="sous_titre" class="form-control" value="<?= htmlspecialchars($projet['sous_titre']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control" value="<?= htmlspecialchars($projet['date']) ?>" max="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lieu" class="form-label">Lieu</label>
                            <input type="text" name="lieu" id="lieu" class="form-control" value="<?= htmlspecialchars($projet['lieu']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="type_travaux" class="form-label">Type de travaux</label>
                            <input type="text" name="type_travaux" id="type_travaux" class="form-control" value="<?= htmlspecialchars($projet['type_travaux']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5" required><?= htmlspecialchars($projet['description']) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning">Mettre à jour</button>
                        <a href="projets.php" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>