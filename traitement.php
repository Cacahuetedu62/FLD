<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification du jeton CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Erreur de jeton CSRF.");
    }

    // Récupération et nettoyage des données du formulaire
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validation des champs obligatoires
    if (empty($nom) || empty($email) || empty($message)) {
        die("Veuillez remplir tous les champs obligatoires.");
    }

    // Validation de l'adresse email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Adresse email invalide.");
    }

    // Contenu HTML de l'email
    $to = "rogez.aurore01@gmail.com";
    $subject = "Nouveau message de contact de $nom";
    $headers = "From: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "
    <html>
    <head>
        <title>Nouveau message de contact</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
            .header { background-color: #f8f9fa; padding: 10px; border-radius: 5px 5px 0 0; text-align: center; }
            .content { padding: 20px; }
            .footer { background-color: #f8f9fa; padding: 10px; border-radius: 0 0 5px 5px; text-align: center; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Nouveau message de contact</h2>
            </div>
            <div class='content'>
                <p><strong>Nom:</strong> $nom</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Téléphone:</strong> $tel</p>
                <p><strong>Message:</strong></p>
                <p>$message</p>
            </div>
            <div class='footer'>
                <p>Merci de nous avoir contacté !</p>
            </div>
        </div>
    </body>
    </html>
    ";

    if (mail($to, $subject, $body, $headers)) {
        echo "Votre message a été envoyé avec succès.";
    } else {
        echo "Une erreur s'est produite lors de l'envoi de l'email.";
    }
} else {
    // Redirection si la méthode n'est pas POST
    header("Location: contact.html");
    exit();
}
?>
