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
    $form_type = isset($_POST['form_type']) ? $_POST['form_type'] : '';
    // Récupérer et sécuriser les données POST
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : '';
    $subject = isset($_POST['subject']) ? htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8') : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') : '';

    if (empty($name) || empty($email) || empty($message)) {
        echo 'Veuillez remplir tous les champs.';
        exit;
    }
    // Créer une instance de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Définir l'encodage UTF-8
        $mail->CharSet = 'UTF-8';

        // Paramètres du serveur
        $mail->SMTPDebug = SMTP::DEBUG_OFF;  // Activer la sortie de débogage détaillée
        $mail->isSMTP();                        // Utiliser SMTP pour l'envoi
        $mail->Host       = 'smtp.ionos.fr';    // Définir le serveur SMTP
        $mail->SMTPAuth   = true;               // Activer l'authentification SMTP
        $mail->Username   = SMTP_USERNAME;      // Nom d'utilisateur SMTP
        $mail->Password   = SMTP_PASSWORD;      // Mot de passe SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Activer le chiffrement TLS implicite
        $mail->Port       = 465;                // Port à utiliser pour la connexion SMTP

        // Paramètres de l'email
        $mail->setFrom('info_contact@digiprogtechseo.com', 'DigiprogtechSEO');
        $mail->addAddress('digiprogtech@gmail.com');  // Ajouter un destinataire

        // Si le formulaire est un formulaire de contact
        if ($form_type === 'contact') {
            $subject = isset($_POST['sujet']) ? htmlspecialchars($_POST['sujet'], ENT_QUOTES, 'UTF-8') : 'Message de contact';
            $mail->Subject = $subject;
            $mail->Body    = "Nom: $name<br>Email: $email<br>Sujet: $subject<br>Message:<br>$message";
            $mail->AltBody = "Nom: $name\nEmail: $email\nSujet: $subject\nMessage:\n$message";
        }

        // Si le formulaire est un formulaire de devis
        elseif ($form_type === 'devis') {
            $service_type = isset($_POST['service_type']) ? htmlspecialchars($_POST['service_type'], ENT_QUOTES, 'UTF-8') : 'Type de service non précisé';
            $mail->Subject = "Demande de devis: $service_type";
            $mail->Body    = "Nom: $name<br>Email: $email<br>Type de service: $service_type<br>Message:<br>$message";
            $mail->AltBody = "Nom: $name\nEmail: $email\nType de service: $service_type\nMessage:\n$message";
        }

        // Envoyer l'email
        $mail->send();
        echo 'Email envoyé avec succès !';
    } catch (Exception $e) {
        echo "Échec de l'envoi de l'email : {$mail->ErrorInfo}";
    }
} else {
    echo 'Méthode de requête non supportée.';
}
?>
