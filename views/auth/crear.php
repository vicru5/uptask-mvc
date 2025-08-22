<div class="contenedor crear">
    <?php

use Model\Usuario;

 include_once __DIR__ . '/../templates/nombre-sitio.php';?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crear tu cuenta en Uptask</p>
        <?php include_once __DIR__ . '/../templates/alertas.php';?>
        <form class="formulario" method="POST">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value= <?= $usuario->nombre ;?>>
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu email" value= <?= $usuario->nombre ;?>>
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Tu password">
            </div>
            <div class="campo">
                <label for="password2">Repetir Password</label>
                <input type="password" name="password2" id="password2" placeholder="Repite tu password">
            </div>
            <input type="submit" class="boton" value="Crear cuenta">
        </form>
        <div class="acciones">
            <a href="/">Ya tienes cuenta? Iniciar Sesion</a>
            <a href="/olvide">Olvidaste tu password</a>
        </div>
    </div>
</div>