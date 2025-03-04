<?php
session_start();
require_once 'lib/pdo.php';

// Fonctions CSRF
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Générer un token CSRF
$csrf_token = generateCSRFToken();

// Rediriger si déjà connecté
if (isset($_SESSION['user_id'])) {
    header('Location: admin/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le token CSRF
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $error = "Erreur de sécurité. Veuillez réessayer.";
    } else {
        // Récupérer les données du formulaire
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $error = "Tous les champs sont obligatoires";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password'])) {
                    // Authentification réussie
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    
                    header('Location: admin/dashboard.php');
                    exit;
                } else {
                    $error = "Nom d'utilisateur ou mot de passe incorrect";
                }
            } catch (PDOException $e) {
                $error = "Erreur de connexion: " . $e->getMessage();
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
    <title>Connexion - Administration FLD Agencement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login-page-wrapper">
    <div class="login-form-container">
        <div class="login-logo-container">
            <img src="images/Fichier 1.svg" alt="FLD Agencement" class="login-logo">
        </div>
        
        <div class="card login-card">
            <div class="card-header login-card-header">
                <h4 class="text-white mb-0 login-heading">Espace Administration</h4>
            </div>
            <div class="card-body login-card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger login-error-alert mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="mb-4">
                        <label for="username" class="form-label login-form-label">Nom d'utilisateur</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control login-input" id="username" name="username" placeholder="Entrez votre nom d'utilisateur" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label login-form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control login-input" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-2 login-btn">
                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                    </button>
                </form>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="login-back-link">
                <i class="fas fa-arrow-left me-2"></i>Retour au site
            </a>
        </div>
    </div>
</body>
</html>