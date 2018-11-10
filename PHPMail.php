<? php
/ **
 * Este ejemplo muestra la configuración para usar cuando se envía a través de los servidores de Gmail de Google.
 * Esto utiliza la autenticación tradicional de ID y contraseña - mire gmail_xoauth.phps
 * Ejemplo para ver cómo usar XOAUTH2.
 * La sección IMAP muestra cómo guardar este mensaje en la carpeta 'Correo enviado' con los comandos IMAP.
 * /
// Importar clases PHPMailer en el espacio de nombres global
use  PHPMailer \ PHPMailer \ PHPMailer ;
requiere  ' ../vendor/autoload.php ' ;
// Crear una nueva instancia de PHPMailer
$ mail  =  nuevo  PHPMailer ;
// Dile a PHPMailer que use SMTP
$ mail -> isSMTP ();
// Habilitar depuración SMTP
// 0 = apagado (para uso de producción)
// 1 = mensajes del cliente
// 2 = mensajes de cliente y servidor
$ mail -> SMTPDebug  =  2 ;
// Establecer el nombre de host del servidor de correo
$ mail -> Host  =  ' smtp.gmail.com ' ;
// usar
// $ mail-> Host = gethostbyname ('smtp.gmail.com');
// si su red no es compatible con SMTP sobre IPv6
// Establezca el número de puerto SMTP: 587 para TLS autenticado, también conocido como envío SMTP RFC4409
$ mail -> Puerto  =  587 ;
// Configurar el sistema de encriptación para usar - ssl (en desuso) o tls
$ mail -> SMTPSecure  =  ' tls ' ;
// Si usa la autenticación SMTP
$ mail -> SMTPAuth  =  true ;
// Nombre de usuario que se usa para la autenticación SMTP: use la dirección de correo electrónico completa para gmail
$ mail -> Nombre de usuario  =  " username@gmail.com " ;
// Contraseña para usar para la autenticación SMTP
$ mail -> Contraseña  =  "tu contraseña " ;
// Establecer de quién será enviado el mensaje
$ mail -> setFrom ( ' from@example.com ' , ' First Last ' );
// Establecer una dirección de respuesta alternativa
$ mail -> addReplyTo ( ' replyto@example.com ' , ' First Last ' );
// Establecer a quién se enviará el mensaje
$ mail -> addAddress ( ' whoto@example.com ' , ' John Doe ' );
// Establecer la línea de asunto
$ mail -> Subject  =  ' PHPMailer GMail SMTP test ' ;
// Lea el cuerpo de un mensaje HTML desde un archivo externo, convierta las imágenes de referencia a incrustadas,
// convertir HTML en un cuerpo alternativo básico de texto plano
$ mail -> msgHTML ( file_get_contents ( ' contents.html ' ), __DIR__ );
// Reemplazar el cuerpo de texto plano por uno creado manualmente
$ mail -> AltBody  =  ' Este es un cuerpo de mensaje de texto sin formato ' ;
// Adjuntar un archivo de imagen
$ mail -> addAttachment ( ' images / phpmailer_mini.png ' );
// enviar el mensaje, comprobar si hay errores
si ( ! $ mail -> enviar ()) {
    echo  " Mailer Error: "  .  $ mail -> ErrorInfo ;
} else {
    echo  "¡ Mensaje enviado! " ;
    // Sección 2: IMAP
    // Descomente esto para guardar su mensaje en la carpeta 'Correo enviado'.
    # if (save_mail ($ mail)) {
    #      echo "Mensaje guardado!";
    # }
}
// Sección 2: IMAP
// Los comandos IMAP requieren la extensión PHP IMAP, que se encuentra en: https://php.net/manual/en/imap.setup.php
// Función para llamar que usa las funciones PHP imap _ * () para guardar mensajes: https://php.net/manual/en/book.imap.php
// Puede usar imap_getmailboxes ($ imapStream, '/ imap / ssl') para obtener una lista de carpetas o etiquetas disponibles, esto puede
// es útil si está intentando que esto funcione en un servidor IMAP que no sea de Gmail.
función  save_mail ( $ mail )
{
    // Puede cambiar 'Correo enviado' a cualquier otra carpeta o etiqueta
    $ path  =  " {imap.gmail.com:993/imap/ssl}◆Gmail◆/Sent Mail " ;
    // Indique a su servidor que abra una conexión IMAP con el mismo nombre de usuario y contraseña que usó para SMTP
    $ imapStream  =  imap_open ( $ ruta , $ correo -> Nombre de usuario , $ correo -> Contraseña );
    $ result  =  imap_append ( $ imapStream , $ path , $ mail -> getSentMIMEMessage ());
    imap_close ( $ imapStream );
    devuelve  $ resultado ;
}
