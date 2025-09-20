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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }

        $router->render('auth/olvide',[
            'titulo' => 'Olvide mi Password'
        ]);
    }

    public static function reestablecer(Router $router){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }

        $router->render('auth/reestablecer',[
            'titulo' => 'Reestablecer Password'
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