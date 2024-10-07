<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Formulardaten sicher abrufen und bereinigen
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    
    $message = trim($_POST["message"]);

    // 2. Validierung der Daten
    if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Ungültige Eingaben
        http_response_code(400);
        echo "Bitte füllen Sie alle Felder korrekt aus.";
        exit;
    }

    // 3. E-Mail-Empfänger und -Betreff
    $recipient = "info@munquo-performante.de"; // Ersetzen Sie diese E-Mail-Adresse durch Ihre eigene
    $subject = "Neue Kontaktanfrage von $name";

    // 4. E-Mail-Inhalt
    $email_content = "Name: $name\n";
    $email_content .= "E-Mail: $email\n\n";
    $email_content .= "Nachricht:\n$message\n";

    // 5. E-Mail-Header
    $email_headers = "From: $name <$email>";

    // 6. E-Mail senden
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Erfolgsmeldung
        http_response_code(200);
        echo "Vielen Dank! Ihre Nachricht wurde erfolgreich gesendet.";
    } else {
        // Fehlermeldung
        http_response_code(500);
        echo "Es gab ein Problem beim Versenden Ihrer Nachricht. Bitte versuchen Sie es später erneut.";
    }

} else {
    // Nicht erlaubte Anfrage
    http_response_code(403);
    echo "Es gab ein Problem mit Ihrer Anfrage. Bitte versuchen Sie es erneut.";
}
?>
