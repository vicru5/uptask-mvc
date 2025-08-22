<?php 

namespace Controllers;

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
        $router->render('auth/confirmar',[
            'titulo' => 'Confirma tu cuenta Uptask'
        ]);
        
    }
}