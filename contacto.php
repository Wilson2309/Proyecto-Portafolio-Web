<?php
/**
 * contacto.php
 * Procesa el envío del formulario de contacto para WTech - Premium Portafolio.
 */

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitización de entradas
    $nombre = strip_tags(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensaje = strip_tags(trim($_POST["mensaje"]));

    // Validación básica
    if (empty($nombre) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
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

    // Cabeceras para mejorar la entregabilidad
    $cabeceras = "MIME-Version: 1.0" . "\r\n";
    $cabeceras .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
    $cabeceras .= "From: WTech Portfolio <no-reply@wtech.com>" . "\r\n";
    $cabeceras .= "Reply-To: $nombre <$email>" . "\r\n";

    // Envío del correo
    if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Mensaje enviado con éxito"]);
        exit;
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Error del servidor al enviar el correo"]);
        exit;
    }

} else {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acceso no permitido"]);
    exit;
}
?>
