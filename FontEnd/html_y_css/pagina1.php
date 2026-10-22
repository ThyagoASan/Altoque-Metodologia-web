<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(session_status()==PHP_SESSION_NONE){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css.css"/>
        <title>Principal</title>
        <link
            href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet"
        />
    </head>
    <body>
        <?php include(__DIR__ . "/../../backend/funcion_header.php");
 ?>
        <div class="div__mapa">
            <h1>->AlToque<-</h1>
            <h2> Contratas y te llega la persona correcta a tu puerta</h2>
        </div>

        <div class="div">
            <div class="div_busqueda">
                <span>Filtros:  </span>
                <select class="details" name="" id="combo_filtro">
                    <option class="details__lista-item" value="Localidad">Localidad</option>
                    <option class="details__lista-item" value="Profeción">Profeción</option>
                </select>
            </div>

            <div class="div_busqueda__div_buscador">
                <label for="input_buscador_localidad" class="label-icono">
                    <span class="material-icons">search</span>
                </label>
                <input
                    class="input_buscador_localidad"
                    id="input_buscador_localidad"
                    type="text"
                    placeholder="Escribir la localidad"
                    list="lista_input"
                />
                <datalist id="lista_input">

                </datalist>
            </div>
        </div>
        <section class="servicios">
    <h2>Servicios disponibles</h2>
    <div class="tarjetas" id="contenedorServicios" aria-live="polite" aria-relevant="additions text">
    <?php 
    $conexion = mysqli_connect("localhost", "root", "", "base_del_proyecto");
    if(!empty($_SESSION["id_cliente"])){
        $id_cliente=$_SESSION["id_cliente"];
    }else{
        $id_cliente=0;
    }
    $respuesta = mysqli_query($conexion, "SELECT *, publicaciones.id AS id_real_publicacion FROM publicaciones INNER JOIN usuarios ON usuarios.id = id_usuario WHERE disponible = true ");
    $publicaciones = mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
    shuffle($publicaciones);
    usort($publicaciones, function($a, $b) {
        if ($a["rol"] === $b["rol"]) return 0;
        $dado = rand(1, 100);
        if ($a["rol"] === "usuario_premium") {
            return ($dado <= 60) ? -1 : 1;
        }
        
        if ($b["rol"] === "usuario_premium") {
            return ($dado <= 60) ? 1 : -1;
        }
        return 0;
    });
    foreach($publicaciones as $publicacion) {
        $clase = ($publicacion["rol"] == "usuario_premium") ? "tarjeta-servicio tarjeta_premium" : "tarjeta-servicio";
        ?>
        <article class="<?php echo $clase; ?>">
            <?php if($publicacion["rol"] == "usuario_premium") echo '<span class="span_premium">Premium</span>'; ?>
            <h3><?php echo htmlspecialchars($publicacion["nombre_completo"], ENT_QUOTES, "UTF-8"); ?></h3>
            <p><strong>Oficio: </strong><?php echo $publicacion["categoria"]; ?></p>
            <p><strong>Zona: </strong><?php echo $publicacion["zona"]; ?></p>
            <p><strong>Descripción: </strong><?php echo htmlspecialchars($publicacion["descripcion"], ENT_QUOTES, "UTF-8"); ?></p>
            <p class="estrellas">estrellas pendiente.</p>
            <?php if($publicacion["id_usuario"]!=$id_cliente){
            ?><button><a id="link_publicacion" href="perfil.php?id=<?php echo $publicacion["id_real_publicacion"]; ?>">Ver perfil</a></button>
       <?php }else {
        ?><p style="text-align: center;user-select: none;"><strong>Tu Publicación</strong></p><?php
       }?>
            </article>
    <?php } ?>
    </div>
</section>
        <script src="../javascript/script.js"></script>
    </body>
</html>
