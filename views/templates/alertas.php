<?php foreach ($alertas as $key => $alerta):
        foreach($alerta as $mensaje): ;?>

    <div class="alertas <?= $key;?>"><?=$mensaje;?></div>

<?php endforeach;
            endforeach; ?>