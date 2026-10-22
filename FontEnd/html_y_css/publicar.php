<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Publicar Servicio</title>
        <link rel="stylesheet" href="css.css" />
    </head>
    <body>
        <form class="formulario1" action="../../backend/registrar_publicacion.php" method="POST">
            <h2>Publicar Servicio</h2>
            <label class="label1">Categoría</label>
            <select class="input1 combobox_publicar"  name="categoria">
                <option>Electricista</option>
                <option>Plomero</option>
                <option>Limpieza</option>
                <option>Jardinería</option>
            </select>
            <label class="label1 ">Zona</label>
            <input class="input1 input_zona" name="zona" type="text" list="zona" />
            <datalist id="zona">
                <?php 
                include("../../backend/conexion/conexion_dal.php");
                $respuesta=mysqli_query(get_conexion(),"select * from localidades");
                while($localidad=mysqli_fetch_array($respuesta))
                {
                ?><option value="<?php echo($localidad["localidad"]);?>"></option>
                    
            <?php }?>
            </datalist>
            <label class="label1">Descripción</label>
            <textarea  class="input1 text_area" name="descripcion"></textarea>
            <button class="botones1" type="submit">Publicar</button>
            <button class="botones1" type="button">
                <a class="inicio-link" href="pagina1.php"> Volver </a>
            </button>
        </form>
        <script type="module" src="../javascript/script.js"></script>
    </body>
</html>
