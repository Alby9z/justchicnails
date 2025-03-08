<?php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Inclure les fichiers nécessaires de PHPMailer
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/../../config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $service_type = isset($_POST['service_type']) ? htmlspecialchars($_POST['service_type'], ENT_QUOTES, 'UTF-8') : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['user_email'], ENT_QUOTES, 'UTF-8') : '';
    $message = isset($_POST['msg']) ? htmlspecialchars($_POST['msg'], ENT_QUOTES, 'UTF-8') : ''; // 'msg' correspond au nom du champ dans le formulaire

    // Vérifier si tous les champs sont remplis
    if (empty($service_type) || empty($email) || empty($message)) {
        echo 'Veuillez remplir tous les champs.';
        exit;
    }

    // Créer une instance de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Définir l'encodage UTF-8
        $mail->CharSet = 'UTF-8';

        // Paramètres du serveur
        $mail->isSMTP();                        // Utiliser SMTP pour l'envoi
        $mail->Host       = 'smtp.ionos.fr';    // Définir le serveur SMTP
        $mail->SMTPAuth   = true;               // Activer l'authentification SMTP
        $mail->Username   = SMTP_USERNAME;      // Nom d'utilisateur SMTP (défini dans config.php)
        $mail->Password   = SMTP_PASSWORD;      // Mot de passe SMTP (défini dans config.php)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Chiffrement TLS implicite
        $mail->Port       = 465;                // Port à utiliser pour la connexion SMTP                                   
        $mail->CharSet    = 'UTF-8'; // Pour gérer les accents

        // Paramètres de l'email
        $mail->setFrom('info_contact@digiprogtechseo.com', 'DigiprogtechSEO');
        $mail->addAddress('digiprogtech@gmail.com');  // Destinataire

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "Nouvelle demande de contact - Service: $service_type";

        // Contenu HTML
        $mail->Body    = "
            <h2>Nouvelle demande de contact</h2>
            <p><strong>Email : </strong> $email</p>
            <p><strong>Service choisi : </strong> $service_type</p>
            <p><strong>Message : </strong> $message</p>
        ";

        // Contenu texte alternatif pour les clients email qui ne supportent pas le HTML
        $mail->AltBody = "
            Nouvelle demande de contact\n
            Email : $email\n
            Service choisi : $service_type\n
            Message : $message
        ";

        // Envoyer l'email
        $mail->send();
        echo 'Votre demande a bien été envoyée.';
    } catch (Exception $e) {
        echo "L'envoi de l'email a échoué : {$mail->ErrorInfo}";
    }
} else {
    echo 'Méthode de requête non supportée.';
}
?>
