<!DOCTYPE html>
<?php
if(session_status()==PHP_SESSION_NONE){
    session_start();
}
include ("../../backend/conexion/conexion_dal.php"); 
$id_publicacion=$_GET["id"];
$respuesta=mysqli_query(get_conexion(),"select * from publicaciones where id=$id_publicacion");
$nombre="";
$categoria="";
$zona="";
$descripcion="";
while($publicacion=mysqli_fetch_array($respuesta)){
$nombre=$publicacion["nombre_completo"];
$categoria=$publicacion["categoria"];
$zona=$publicacion["zona"];
$descripcion=$publicacion["descripcion"];
}
?>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Perfil del Prestador</title>
        <link rel="stylesheet" href="css.css" />
        <link
            href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet"
        />
    </head>
    <body  data-id_publicacion="<?php echo $id_publicacion; ?>" class="a">
        <section class="perfil">
            <div class="perfil-card">
                <div class="informacion_card">
                    <div class="perfil-foto">
                        <img src="imagenes/usuario.avif" alt="" />
                        <span class="text_disponible">
                            <span class="material-icons"> circle </span>
                            Disponible</span
                        >
                    </div>
                    <div class="informacion_basica-perfil">
                        <h2 id="perfil-nombre"><?php echo($nombre);?></h2>
                        <div>
                            <span class="text_info">
                                <span class="material-icons icono_perfil">
                                    home_repair_service
                                </span>
                                Oficio:</span>
                            <span id="perfil-oficio"><?php echo($categoria);?></span>
                        </div>
                        <div>
                            <span class="text_info">
                                <span class="material-icons icono_perfil">
                                    location_on</span
                                >
                                Zona:</span
                            >
                            <span id="perfil-zona"><?php echo($zona);?></span>
                        </div>
                        <div>
                            <span class="text_info">
                                <span class="material-icons icono_perfil"
                                    >star</span
                                >
                                Calificación:</span
                            >
                            <div id="estrellas_numero">
                            <span>
                                <span class="star_promedio" data-value="1">&#9733</span>
                                <span class="star_promedio" data-value="2">&#9733</span>
                                <span class="star_promedio" data-value="3">&#9733</span>
                                <span class="star_promedio" data-value="4">&#9733</span>
                                <span class="star_promedio" data-value="5">&#9733</span>
                            </span>
                            <p id="cantidad_estrellas"></p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="descripcion_div">
                    <strong> Descripción:</strong>
                    <p class="perfil-descripcion" id="perfil-descripcion">
                    <?php echo($descripcion);?>
                    </p>
                </div>
                <div class="div_botones">
                    <button class="botones-perfil btm_volver" type="button">
                        <span class="material-icons icono_perfil"
                            >chevron_left
                        </span>
                        <a class="inicio-link" href="pagina1.php">Volver</a>
                    </button>
                    <form class="form_boton_contratar">
                        <button
                            class="botones-perfil"
                            id="btn-contratar"
                            type="button"
                            onclick="contratar_profecional()"
                            data-id_publicacion="<?php echo($id_publicacion)?>">
                           
                            <span
                                class="material-icons icono_perfil icono_contratar"
                                >handshake</span>
                            Contratar
                        </button>
                    </form>    
                </div>
            </div>
        </section>
        <?php 
        if(!empty($_SESSION["cliente"])){
        $respuesta_estrellas=mysqli_query(get_conexion(),"select * from estrellas where id_usuario=".$_SESSION["id_cliente"]." and id_publicacion=$id_publicacion");
        if(mysqli_num_rows($respuesta_estrellas)<1){ ?>
        <div class="section_estrellas">
            <p>Reseñas</p>
            <span id="stars">
                <span class="star" data-value="1">&#9733</span>
                <span class="star" data-value="2">&#9733</span>
                <span class="star" data-value="3">&#9733</span>
                <span class="star" data-value="4">&#9733</span>
                <span class="star" data-value="5">&#9733</span>
            </span>     
            <button onclick="guardar_estrellas(this)" data-id_publicacion="<?php echo($id_publicacion)?>" data-id_usuario="<?php echo($_SESSION["id_cliente"])?>"><span class="material-icons">send</span>Enviar Reseña</button>
        </div>
        <?php } }?>
        <div class="comentarios-seccion">
                 <?php if(!empty($_SESSION["cliente"])){?>
                <div class="comentarios-nuevo">
                    <h3>Dejar un comentario</h3>
                    <form action="../../backend/guardar_comentario.php?id_publicacion=<?php echo($id_publicacion);?>&nombre=<?php echo($_SESSION["cliente"]);?>" method="POST">
                        <div class="comentarios-input-group">
                            <textarea name="comentario" placeholder="Escribe tu experiencia con este prestador..." required></textarea>
                        </div>
                        <button type="submit" class="btn-enviar-comentario">
                            <span class="material-icons">send</span> Enviar Comentario
                        </button>
                    </form>
                </div>
                <?php } ?>
                <div class="comentarios-lista">
                    <h3>Comentarios de clientes</h3>

                     <?php 
                    $respuesta=mysqli_query(get_conexion(),"select * from comentarios where id_publicacion=$id_publicacion order by id desc");
                    while($comentario = mysqli_fetch_array($respuesta)){
                        ?>
                        <div class="comentario-item">
                        <div class="comentario-cabecera">
                            <div class="comentario-autor">
                                <span class="material-icons">account_circle</span>
                                <strong><?php echo($comentario["nombre_usuario"]);?></strong>
                            </div>
                            <span class="comentario-fecha"><?php echo($comentario["fecha"]);?></span>
                        </div>
                        <p class="comentario-texto">
                        <?php echo($comentario["comentario"]);?>
                        </p>
                    </div>
                    <?php }
                    ?>
                    <div class="comentario-item">
                        <div class="comentario-cabecera">
                            <div class="comentario-autor">
                                <span class="material-icons">account_circle</span>
                                <strong>María Luján</strong>
                            </div>
                            <span class="comentario-fecha">02/07/2026</span>
                        </div>
                        <p class="comentario-texto">
                            Muy prolijo en su trabajo, el precio fue el acordado desde el principio.
                        </p>
                    </div>

                </div>
            </div>
        <script src="../javascript/script.js"></script>
    </body>
</html>
