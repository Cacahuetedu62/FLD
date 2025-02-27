<?php
// Configuration des variables
$destinataire = "rogez.aurore01@gmail.com"; // Adresse email du client

// Récupération et validation des données
$nom = htmlspecialchars(trim($_POST['nom'] ?? ''), ENT_QUOTES);
$email = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES);
$tel = htmlspecialchars(trim($_POST['tel'] ?? ''), ENT_QUOTES);
$message = htmlspecialchars(trim($_POST['message'] ?? ''), ENT_QUOTES);

// Vérification des champs obligatoires
if (empty($nom) || empty($email) || empty($message)) {
    die("Erreur: Veuillez remplir tous les champs obligatoires.");
}

// Validation de l'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Erreur: Adresse email invalide.");
}

// Validation du téléphone (optionnel)
if (!empty($tel) && !preg_match('/^\+?[0-9\s\-]+$/', $tel)) {
    die("Erreur: Numéro de téléphone invalide.");
}

// Protection contre le spam par inondation (limitation des requêtes)
session_start();
if (!isset($_SESSION['last_submission'])) {
    $_SESSION['last_submission'] = time();
} else {
    $timeSinceLast = time() - $_SESSION['last_submission'];
    if ($timeSinceLast < 30) { // 30 secondes entre deux soumissions
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
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                margin: 0;
                padding: 0;
                background-color: #f5f5f5;
            }
            .email-container {
                max-width: 500px;
                margin: 30px auto;
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
                background-color: #ffffff;
            }
            .header {
                background-color: #4a6da7;
                color: white;
                padding: 10px;
                text-align: center;
                margin-bottom: 25px;
            }
            .header h2 {
                margin: 0;
                font-size: 22px;
            }
            .content {
                padding: 0 30px 20px 30px;
            }
            .field {
                margin-bottom: 20px;
            }
            .field-name {
                font-weight: bold;
                color: #4a6da7;
                display: block;
                margin-bottom: 5px;
            }
            .message-box {
                background-color: #f9f9f9;
                border: 1px solid #eee;
                border-radius: 5px;
                padding: 15px;
                margin-top: 5px;
            }
            .footer {
                font-size: 12px;
                text-align: center;
                margin-top: 30px;
                padding: 15px;
                color: #777;
                background-color: #f5f5f5;
            }
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

// En-têtes pour e-mail HTML
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
$headers .= "From: rogez.aurore01@gmail.com" . "\r\n";
$headers .= "Reply-To: $email" . "\r\n"; 
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// Envoi du mail
if (mail($destinataire, $sujet, $corps, $headers)) {
    echo "Merci ! Votre message a bien été envoyé. Nous vous contacterons très prochainement.";
} else {
    echo "Une erreur est survenue. Veuillez réessayer.";
}
?>
