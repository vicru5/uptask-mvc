<?php 

namespace Controllers;
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }

        $router->render('auth/crear',[
            'titulo' => 'Crear Cuenta'
        ]);
    }
    
    public static function olvide(){
        echo "Desde olvide";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
    }

    public static function reestablecer(){
        echo "Desde reestablecer";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
    }
    
    public static function mensaje(){
        echo "Desde mensaje";
    }

    public static function confirmar(){
        echo "Desde confirmar";

    }
}