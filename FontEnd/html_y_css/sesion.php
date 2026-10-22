<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Sesion</title>
        <link rel="stylesheet" href="css.css" />
    </head>
    <body>
        <form action="../../backend/login.php" method="POST" class="formulario_login">
            <h2>Formulario Inicio Sesión</h2>
            <label class="label1">Email <br /></label>
            <input
                id="email_login"
                name="email"
                class="input1"
                type="email"
                required
                placeholder="PedroRamirez@gmail.com"
            />

            <label class="label2">Contraseña </label>
            <input
                id="contraseña_login"
                class="input1"
                name="contraseña"
                type="password"
                required
                minlength="6"
                placeholder="Pepito2605"
            />
            <button id="boton_enviar_login" class="botones1" type="submit">
                Enviar
            </button>
            <button class="botones1" type="button">
                <a class="registrarse_link" href="registrarse.php"
                    >Registrarse</a
                >
            </button>
            <button class="botones1" type="button">
                <a class="inicio-link" href="pagina1.php">Volver Inicio</a>
            </button>
        </form>
        <script src="../javascript/login_register.js"></script>
    </body>
</html>
