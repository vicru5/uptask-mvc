<div class="contenedor reestablecer">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php';?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nuevo password</p>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Tu password">
            </div>
            <input type="submit" class="boton" value="Guardar Password">
        </form>
        <div class="acciones">
            <a href="/">Ya tienes una cuenta? Iniciar Sesion</a>
            <a href="/crear">Aun no tienes una Cuenta? Crear una</a>
        </div>
    </div>
</div>