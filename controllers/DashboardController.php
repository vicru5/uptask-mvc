<?php

namespace Controllers;

use MVC\Router;
use Model\Proyecto;

class DashboardController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();

        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioid', $id);

        $router->render('dashboard/index',[
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router)
    {
        session_start();
        isAuth();

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $proyecto = new Proyecto($_POST);

            // VALIDACION
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)){
                // Generar una url unico
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                // Almacenar el creador del proyecto
                $proyecto->propietarioid = $_SESSION['id'];
                
                // Guardar proyecto
                $proyecto->guardar();

                // Redireccionar
                header('Location:/proyecto?url='. $proyecto->url);
            }
        }

        $alertas = Proyecto::getAlertas();

        $router->render('dashboard/crear-proyecto',[
            'alertas' => $alertas,
            'titulo' => 'Crear-Proyecto'
        ]);
    }

    public static function perfil(Router $router)
    {
        session_start();
        isAuth();
        $router->render('dashboard/perfil',[
            'titulo' => 'Perfil'
        ]);
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();
        $url = $_GET['url'];
        if(!$url) header('Location: /dashboard');
        // Revisar que sea el propietario del proyecto
        $proyecto = Proyecto::where('url',$url);
        
        if($proyecto->propietarioid !== $_SESSION['id']){
            header('Location: /dashboard');
        }


        $router->render('dashboard/proyecto',[
            'titulo' => $proyecto->proyecto
        ]);
    }
}