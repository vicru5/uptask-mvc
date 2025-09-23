<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router){
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        $router->render('auth/login',[
            'titulo' => 'Iniciar Sesion'
        ]);
    }

    public static function logout(){
        echo "Desde logout";
    }

    public static function crear(Router $router){
        $usuario = new Usuario;
        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                $existUsuario = Usuario::where('email',$usuario->email);
                if ($existUsuario) {
                    Usuario::setAlerta('error','El usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                }else{
                    //Hashear el password
                    $usuario->hashPassword();

                    // Eliminar password 2
                    unset($usuario->password2);

                    $usuario->crearToken();

                    $resultado = $usuario->guardar();

                    // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();



                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        
        
        $router->render('auth/crear',[
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    
    public static function olvide(Router $router){
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();
            
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $usuario->email);

                if ($usuario && $usuario->confirmado) {
                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    // Actualizar el usuario 
                    $usuario->guardar();

                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // imprimir la alerta
                    Usuario::setAlerta('exito',"Hemos enviado las instrucciones a tu email");
                }else{
                    Usuario::setAlerta('error','El usuario no exite o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/olvide',[
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router){

        $token = s($_GET['token']);
        $mostrar = true;

        if (!$token) header('Location: /');

        // Identificar el usuario
        $usuario = Usuario::where('token',$token);
        if (empty($usuario)) {
            Usuario::setAlerta('error', "Token no valido");
            $mostrar = false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Anadir el nuevo password
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarPassword();

            if (empty($alertas)) {
                unset($usuario->password2);
                // hashear el passowrd
                $usuario->hashPassword();
                // Eliminar el token
                $usuario->token = null;
                // Guardar en la base de datos
                $resultado = $usuario->guardar();
                // Redireccionar
                if ($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/reestablecer',[
            'titulo' => 'Reestablecer Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }
    
    public static function mensaje(Router $router){
        
        $router->render('auth/mensaje',[
            'titulo' => 'Cuenta creada exitosamente'
        ]);
    }
    
    public static function confirmar(Router $router){

        $token = s($_GET['token']);
        if (!$token) {
            header("Location:/");            
        }

        $usuario = Usuario::where('token',$token);

        if (empty($usuario)) {
            // No se encontro usuario
            Usuario::setAlerta('error','Token no valido');
        }else{
            // Confirmar la cuenta
            unset($usuario->password2);
            $usuario->confirmado = 1;
            $usuario->token = null;
            
            $usuario->guardar();

            Usuario::setAlerta('exito','Cuenta comprobada correctamente');
        }

        $alertas = Usuario::getAlertas();


        $router->render('auth/confirmar',[
            'titulo' => 'Confirma tu cuenta Uptask',
            'alertas' => $alertas
        ]);
        
    }
}