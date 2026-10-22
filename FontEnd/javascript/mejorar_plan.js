document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formulario-pago");
    const txtTarjeta = document.getElementById("tarjeta");
    const txtVencimiento = document.getElementById("vencimiento");
    const txtCvv = document.getElementById("cvv");
    txtTarjeta.addEventListener("input", (e) => {
        let valor = e.target.value.replace(/\D/g, "");
        let formateado = valor.match(/.{1,4}/g);
        e.target.value = formateado ? formateado.join(" ") : "";
    });

    txtVencimiento.addEventListener("input", (e) => {
        let valor = e.target.value.replace(/\D/g, "");
        if (valor.length > 2) {
            e.target.value =
                valor.substring(0, 2) + "/" + valor.substring(2, 4);
        } else {
            e.target.value = valor;
        }
    });

    txtCvv.addEventListener("input", (e) => {
        e.target.value = e.target.value.replace(/\D/g, "");
    });
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        let errores = 0;
        boton_submit = document.querySelector(".plan__boton");
        document
            .querySelectorAll(".plan__error")
            .forEach((el) => (el.innerText = ""));

        const nombre = document.getElementById("nombre").value.trim();
        if (nombre.length < 3) {
            document.getElementById("error-nombre").innerText =
                "Ingrese un nombre válido.";
            errores++;
        }
        const tarjetaSinEspacios = txtTarjeta.value.replace(/\s/g, "");
        if (tarjetaSinEspacios.length < 16) {
            document.getElementById("error-tarjeta").innerText =
                "La tarjeta debe tener 16 dígitos.";
            errores++;
        }
        const vtoReg = /^(0[1-12]|1[0-2])\/?([0-9]{2})$/;
        if (!vtoReg.test(txtVencimiento.value)) {
            document.getElementById("error-vencimiento").innerText =
                "Formato MM/AA inválido.";
            errores++;
        }
        if (txtCvv.value.length < 3) {
            document.getElementById("error-cvv").innerText = "Clave inválida.";
            errores++;
        }

        if (errores === 0) {
            fetch("../../backend/mejorar_plan_usuario.php", {
                headers: { "Content-Type": "text_plain" },
                method: "POST",
                body: boton_submit.dataset.id_usuario,
            });
            form.style.display = "none";
            const panelExito = document.getElementById("mensaje-exito");
            panelExito.style.display = "block";
            const contenedor = document.querySelector(".plan__contenedor");
            contenedor.innerHTML += `      <button class="botones1 boton_volver_mejorar_plan">
      <a class="inicio-link" href="pagina1.php">Volver Inicio</a>  
      </button>`;
        }
    });
});
