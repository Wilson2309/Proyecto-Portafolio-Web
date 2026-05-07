<?php
/**
 * contacto.php
 * Procesa el envío del formulario de contacto para Wilson Pinela.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitización de entradas
    $nombre = strip_tags(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensaje = strip_tags(trim($_POST["mensaje"]));

    // Validación básica
    if (empty($nombre) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Por favor, completa el formulario correctamente.";
        exit;
    }

    // Configuración del correo
    $destinatario = "pinela5202@gmail.com";
    $asunto = "Nuevo mensaje de contacto de: $nombre";
    
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Email: $email\n\n";
    $contenido .= "Mensaje:\n$mensaje\n";

    $cabeceras = "From: $nombre <$email>";

    // Envío del correo
    if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
        http_response_code(200);
        echo "¡Gracias! Tu mensaje ha sido enviado.";
        // Opcional: Redireccionar de vuelta
        // header("Location: index.html?status=success");
    } else {
        http_response_code(500);
        echo "Oops! Algo salió mal y no pudimos enviar tu mensaje.";
    }

} else {
    http_response_code(403);
    echo "Hubo un problema con tu envío, por favor intenta de nuevo.";
}
?>
