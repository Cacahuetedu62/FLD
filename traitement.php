<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuration du serveur SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.example.com'; // Remplacez par votre serveur SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'your_email@example.com'; // Votre email
    $mail->Password   = 'your_password'; // Votre mot de passe
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Expéditeur et destinataire
    $mail->setFrom('your_email@example.com', 'Votre Nom');
    $mail->addAddress('rogez.aurore01@gmail.com', 'Aurore Rogez'); // Adresse du destinataire

    // Contenu de l'e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Nouveau message de contact';
    
    // Créer le corps du message avec une belle mise en page
    $body = '
    <html>
    <head>
        <title>Nouveau message de contact</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
            .container { background-color: #ffffff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
            h1 { color: #333; }
            p { color: #555; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Nouveau message de contact</h1>
            <p>Vous avez reçu un nouveau message. Voici les détails :</p>
            <p><strong>Nom :</strong> ' . htmlspecialchars($_POST['name']) . '</p>
            <p><strong>Email :</strong> ' . htmlspecialchars($_POST['email']) . '</p>
            <p><strong>Message :</strong><br>' . nl2br(htmlspecialchars($_POST['message'])) . '</p>
        </div>
    </body>
    </html>
    ';

    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body); // Texte brut pour les clients de messagerie qui ne supportent pas HTML

    // Envoi de l'e-mail
    $mail->send();
    echo 'Votre message a été envoyé avec succès.';
} catch (Exception $e) {
    echo "Une erreur s'est produite lors de l'envoi de l'email. Erreur: {$mail->ErrorInfo}";
}
?>
