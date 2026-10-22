<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mejorar Plan - Simulación</title>
  <link rel="stylesheet" href="css.css">
</head>

<body id="body_plan_mejorar">
<?php if(session_status()==PHP_SESSION_NONE){
session_start();
}?>
  <div class="plan__contenedor">
    <!-- Tarjeta del Producto -->
    <div class="plan__tarjeta">
      <span class="plan__badge">OFERTA ÚNICA</span>
      <h2>Plan Premium de por Vida</h2>
      <p class="plan__descripcion">Acceso ilimitado para siempre. Olvidate de las suscripciones mensuales.</p>
      <div class="plan__precio">
        <span class="plan__monto">$99.99</span>
        <span class="plan__pago-unico">Pago único</span>
      </div>
    </div>

    <!-- Formulario de Simulación -->
    <form id="formulario-pago" class="plan__formulario" novalidate>
      <h3>Simulador de Pago Seguro</h3>
      <p class="plan__aviso">⚠️ Ingrese datos ficticios o imaginarios para la prueba.</p>

      <div class="plan__grupo">
        <label for="nombre">Nombre en la tarjeta imaginaria</label>
        <input type="text" id="nombre" placeholder="Ej. Juan Pérez" required>
        <span class="plan__error" id="error-nombre"></span>
      </div>

      <div class="plan__grupo">
        <label for="tarjeta">Número de tarjeta falsa</label>
        <input type="text" id="tarjeta" placeholder="1234 5678 1234 5678" maxlength="19" required>
        <span class="plan__error" id="error-tarjeta"></span>
      </div>

      <div class="plan__fila">
        <div class="plan__grupo">
          <label for="vencimiento">Vencimiento</label>
          <input type="text" id="vencimiento" placeholder="MM/AA" maxlength="5" required>
          <span class="plan__error" id="error-vencimiento"></span>
        </div>

        <div class="plan__grupo">
          <label for="cvv">Clave secreta (CVV)</label>
          <input type="password" id="cvv" placeholder="123" maxlength="4" required>
          <span class="plan__error" id="error-cvv"></span>
        </div>
      </div>

      <button type="submit" data-id_usuario="<?php echo($_SESSION["id_cliente"]);?>" class="plan__boton">Activar Plan de por Vida</button>
    </form>

    <!-- Mensaje de Éxito Oculto -->
    <div id="mensaje-exito" class="plan__exito" style="display: none;">
      🎉 ¡Plan Premium Activado Correctamente!<br>
      <small>Tu estado actual se guardó como: <strong>Activo</strong></small>
    </div>
  </div>

  <script src="../javascript/mejorar_plan.js"></script>
</body>
</html>
