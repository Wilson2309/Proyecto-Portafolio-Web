<?php
/**
 * contacto.php
 * Procesa el envío del formulario de contacto para WTech - Premium Portafolio.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitización de entradas
    $nombre = strip_tags(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensaje = strip_tags(trim($_POST["mensaje"]));

    // Validación básica
    if (empty($nombre) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        // Redirección con error
        header("Location: index.html?status=error&msg=invalid_data#contacto");
        exit;
    }

    // Configuración del correo
    $destinatario = "pinela5202@gmail.com";
    $asunto = "WTech Contact: Nuevo lead de $nombre";
    
    $contenido = "Detalles del prospecto:\n";
    $contenido .= "------------------------\n";
    $contenido .= "Nombre: $nombre\n";
    $contenido .= "Email corporativo/contacto: $email\n\n";
    $contenido .= "Propuesta / Mensaje:\n";
    $contenido .= "------------------------\n";
    $contenido .= "$mensaje\n";

    $cabeceras = "From: $nombre <$email>";

    // Envío del correo
    if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
        http_response_code(200);
        // Redireccionar de vuelta a la landing page para mantener la inmersión UX
        header("Location: index.html?status=success#contacto");
        exit;
    } else {
        http_response_code(500);
        header("Location: index.html?status=error&msg=server_error#contacto");
        exit;
    }

} else {
    http_response_code(403);
    header("Location: index.html");
    exit;
}
?>
