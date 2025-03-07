<?php
session_start();
require_once 'lib/pdo.php'; // Assurez-vous que ce fichier définit bien $pdo

// Sécurisation des sessions
session_set_cookie_params([
    'httponly' => true,
    'secure' => isset($_SERVER['HTTPS']),
    'samesite' => 'Strict'
]);

// Génération et vérification du token CSRF
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Fonction pour gérer les tentatives de connexion (stockage en base de données par IP)
function logFailedLogin($pdo, $username, $ip) {
    $stmt = $pdo->prepare("INSERT INTO failed_logins (username, ip_address, attempt_time) VALUES (?, ?, NOW())");
    $stmt->execute([$username, $ip]);
}

function getFailedAttempts($pdo, $ip) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM failed_logins WHERE ip_address = ? AND attempt_time > (NOW() - INTERVAL 15 MINUTE)");
    $stmt->execute([$ip]);
    return $stmt->fetchColumn();
}

$csrf_token = generateCSRFToken();
$error = '';
$ip = $_SERVER['REMOTE_ADDR'];

if (isset($_SESSION['user_id'])) {
    header('Location: admin/dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $error = "Erreur de sécurité. Veuillez réessayer.";
    } else {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $error = "Tous les champs sont obligatoires.";
        } elseif (getFailedAttempts($pdo, $ip) >= 5) {
            $error = "Trop de tentatives. Réessayez plus tard.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    
                    header('Location: admin/dashboard.php');
                    exit;
                } else {
                    logFailedLogin($pdo, $username, $ip);
                    sleep(1); // Ralentit les attaques bruteforce
                    $error = "Identifiants incorrects.";
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
    <title>FLD Agencement - Connexion à l'espace ADMIN</title>
    <meta name="description" content="Informations légales sur FLD Agencement, y compris nos coordonnées, conditions générales et politique de confidentialité.">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="login-page-wrapper">
    <div class="login-form-container">
        <div class="login-card">
            <div class="login-card-header">
                <h2 class="login-heading text-white">Connexion</h2>
            </div>
            <div class="login-card-body">
                <?php if ($error): ?>
                    <div class="alert login-error-alert"> <?= htmlspecialchars($error) ?> </div>
                <?php endif; ?>
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <div class="mb-3">
                        <label class="login-form-label">Nom d'utilisateur :</label>
                        <input type="text" name="username" class="form-control login-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="login-form-label">Mot de passe :</label>
                        <input type="password" name="password" class="form-control login-input" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 login-btn">Se connecter</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="index.php" class="login-back-link">
                        <i class="fas fa-arrow-left me-2"></i> Retour au site
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>