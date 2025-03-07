<?php
// Activation du debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Charger la configuration
try {
    $config = require_once __DIR__ . '/lib/config.php';
} catch (Exception $e) {
    die("Erreur: Configuration non trouvée.");
}

// Configuration des en-têtes de sécurité
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");

// Vérifier si la requête est en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Erreur: Méthode non autorisée.");
}

// Configuration des variables
$destinataire = "rogez.aurore01@gmail.com";  // Adresse email du client
$captchaSecretKey = $config['recaptcha']['secret_key'] ?? ''; 

// Récupération et validation des données
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
$captchaResponse = $_POST['g-recaptcha-response'] ?? '';

// Vérification des champs obligatoires
if (empty($nom) || empty($email) || empty($message)) {
    die("Erreur: Veuillez remplir tous les champs obligatoires.");
}

// Validation de l'email avec filter_var
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Erreur: Adresse email invalide.");
}

// Validation du téléphone (optionnel)
if (!empty($tel) && !preg_match('/^(\+[0-9]{1,3})?[0-9\s\-]{6,15}$/', $tel)) {
    die("Erreur: Numéro de téléphone invalide.");
}

// Limites de longueur
if (strlen($nom) > 100) {
    die("Erreur: Nom trop long (maximum 100 caractères).");
}

if (strlen($message) > 1000) {
    die("Erreur: Message trop long (maximum 1000 caractères).");
}

// Protection contre les injections
if (preg_match('/<script|<iframe|javascript:|onclick|onload/i', $nom . $email . $message)) {
    die("Erreur: Contenu non autorisé détecté.");
}

// Validation du CAPTCHA
try {
    $captchaValidation = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$captchaSecretKey&response=$captchaResponse");
    $captchaData = json_decode($captchaValidation);

    if (!$captchaData || !$captchaData->success) {
        die("Erreur: Validation CAPTCHA échouée. Veuillez réessayer.");
    }
} catch (Exception $e) {
    die("Erreur: Problème de validation CAPTCHA.");
}

// Protection contre le spam par inondation
session_start();
if (!isset($_SESSION['last_submission'])) {
    $_SESSION['last_submission'] = time();
} else {
    $timeSinceLast = time() - $_SESSION['last_submission'];
    if ($timeSinceLast < 30) {
        die("Erreur: Vous envoyez des messages trop rapidement. Veuillez patienter.");
    }
    $_SESSION['last_submission'] = time();
}

// Sujet et contenu du mail
$sujet = "🚨 Nouveau message client de votre site web !";
$corps = "
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f5f5f5; }
            .email-container { max-width: 500px; margin: 30px auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background-color: #ffffff; }
            .header { background-color: #4a6da7; color: white; padding: 10px; text-align: center; margin-bottom: 25px; }
            .header h2 { margin: 0; font-size: 22px; }
            .content { padding: 0 30px 20px 30px; }
            .field { margin-bottom: 20px; }
            .field-name { font-weight: bold; color: #4a6da7; display: block; margin-bottom: 5px; }
            .message-box { background-color: #f9f9f9; border: 1px solid #eee; border-radius: 5px; padding: 15px; margin-top: 5px; }
            .footer { font-size: 12px; text-align: center; margin-top: 30px; padding: 15px; color: #777; background-color: #f5f5f5; }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='header'>
                <h2>Nouveau message client</h2>
            </div>
            <div class='content'>
                <div class='field'>
                    <span class='field-name'>Nom:</span>
                    <span>$nom</span>
                </div>
                <div class='field'>
                    <span class='field-name'>Email:</span>
                    <span>$email</span>
                </div>
                <div class='field'>
                    <span class='field-name'>Téléphone:</span>
                    <span>" . ($tel ? $tel : "Non renseigné") . "</span>
                </div>
                <div class='field'>
                    <span class='field-name'>Message:</span>
                    <div class='message-box'>
                        " . nl2br($message) . "
                    </div>
                </div>
            </div>
            <div class='footer'>
                <p>Ce message a été envoyé depuis le formulaire de contact du site FLD Agencement.</p>
            </div>
        </div>
    </body>
    </html>
";

// Configuration de l'envoi d'email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
$headers .= "From: contact@" . $_SERVER['HTTP_HOST'] . "\r\n"; // Utiliser le domaine actuel
$headers .= "Reply-To: $email" . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// Pour Hostinger, définir l'expéditeur
ini_set("sendmail_from", "contact@" . $_SERVER['HTTP_HOST']);

// Envoi du mail
$mailSent = mail($destinataire, $sujet, $corps, $headers);

if ($mailSent) {
    echo "Votre message a été envoyé avec succès! Nous vous répondrons dans les plus brefs délais.";
    error_log("Message envoyé avec succès depuis $email à $destinataire");
} else {
    $error = error_get_last();
    error_log("Erreur lors de l'envoi de l'email depuis $email: " . ($error ? $error['message'] : 'Erreur inconnue'));
    die("Erreur: L'envoi du message a échoué. Veuillez réessayer ultérieurement ou nous contacter par téléphone.");
}
?>