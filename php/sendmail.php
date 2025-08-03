<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Manualny include (jeśli nie używasz Composera)
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Konfiguracja SMTP do testów na XAMPP (np. Gmail) - potem podmieniasz na dane hostingu!
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';           // na produkcji np. mail.twojadomena.pl lub podany przez Hostinger/home.pl
    $mail->SMTPAuth = true;
    $mail->Username = 'twojmail@gmail.com';   // Twój E-MAIL testowy lub produkcyjny z hostingu!
    $mail->Password = 'haslotestowe';         // Hasło do testowej skrzynki (lub produkcyjnej)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // lub 'tls'
    $mail->Port = 465;                        // 465(SMTP SSL) albo 587 (TLS) - zależnie od poczty

    // Odbiorca i zawartość maila
    $mail->setFrom('twojmail@gmail.com', 'Formularz kontaktowy');
    $mail->addAddress('adresdociebie@twojadomena.pl'); // na produkcji: twój realny adres lub alias

    $mail->Subject = 'Formularz kontaktowy z twojej strony';
    $mail->Body = "Imię i nazwisko: " . $_POST['name'] . "\n"
                . "E-mail: " . $_POST['email'] . "\n"
                . "Wiadomość:\n" . $_POST['message'] . "\n";

    $mail->CharSet = 'UTF-8';

    $mail->send();
    header("Location: ./../final.html?sent=1");
    exit();
} catch (Exception $e) {
    // Zwrotka/log do debugowania
    error_log("Błąd maila: " . $mail->ErrorInfo);
    header("Location: ./../final.html?sent=mailfail");
    exit();
}
?>
