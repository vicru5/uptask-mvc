<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        $email = new PHPMailer();

        try {
            // Looking to send emails in production? Check out our Email API/SMTP product!
            $email = new PHPMailer();
            $email->isSMTP();
            $email->Host = 'sandbox.smtp.mailtrap.io';
            $email->SMTPAuth = true;
            $email->Port = 2525;
            $email->Username = '07192e3db9fbe9';
            $email->Password = '8a855e7fc3edc8';

            //Recipients
            $email->setFrom('cuentas@uptask.com', 'Cuentas uptask');
            $email->addAddress('cuentas@uptask.com', 'uptask.com');     //Add a recipient
            $email->Subject = "Validar cuenta uptask";
            $email->isHTML(true);
            $email->CharSet = "UTF-8";

            $contenido = "<html>";
            $contenido .= "<p><strong>Hola ".$this->nombre . "</strong> Has creado tu cuenta en Uptask, confirmala en el siguiente enlace</p>";
            $contenido .= "<p>Presiona Aqui: <a href='http://localhost/confirmar?token=". $this->token . "'>Confirmar Cuenta</a></p>";
            $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
            $contenido .= "</html>";

            $email->Body = $contenido;

            $email->send();


        } catch (\Throwable $e) {
            echo "El correo no se envio";
        }
    }
}