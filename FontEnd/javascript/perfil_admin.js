const botonesModificar = document.querySelectorAll(".tabla__boton_modificar");
botonesModificar.forEach((boton) => {
    boton.addEventListener("click", (e) => {
        const filaActual = e.target.closest(".fila_tabla");
        const columnas = filaActual.querySelectorAll("td");
        const nuevo_id = columnas[0].textContent;
        const nuevo_categoria = columnas[2].textContent;
        const nuevo_zona = columnas[3].textContent;
        const nuevo_descripcion = columnas[4].textContent;
        const nuevo_disponible = columnas[5].querySelector("input");
        let result_disponible;
        if (nuevo_disponible.checked) {
            result_disponible = 1;
        } else {
            result_disponible = 0;
        }
        enviar_datos_modificar_publicacion(
            nuevo_id,
            nuevo_categoria,
            nuevo_zona,
            nuevo_descripcion,
            result_disponible
        );
    });
});
const enviar_datos_modificar_publicacion = (
    nuevo_id,
    nuevo_categoria,
    nuevo_zona,
    nuevo_descripcion,
    nuevo_disponible
) => {
    fetch("../../backend/modificar_publicacion.php", {
        headers: { "Content-Type": "application/json" },
        method: "POST",
        body: JSON.stringify({
            id: nuevo_id,
            categoria: nuevo_categoria,
            zona: nuevo_zona,
            descripcion: nuevo_descripcion,
            disponible: nuevo_disponible,
        }),
    })
        .then((res) => res.text())
        .then((res) => {
            alert(res);
            if (
                res ==
                "Error, usted no puede volver activar una publicación sin finalizarla primero."
            ) {
                document
                    .getElementById("section_mis_trabajos")
                    .scrollIntoView({ behavior: "smooth" });
            } else {
                location.reload();
            }
        });
};
//boton copiar en el portapapeles
document.addEventListener("DOMContentLoaded", () => {
    // 1. Seleccionamos TODOS los botones de copiar que existan en la página
    const botones = document.querySelectorAll(".tabla__boton_copiar");

    // 2. Le ponemos el evento click a cada botón de forma individual
    botones.forEach((boton) => {
        boton.addEventListener("click", (e) => {
            const filaActual = e.target.parentElement.parentElement;
            const celdaEmail = filaActual.querySelector(".email_dato");
            const emailACopiar = celdaEmail.textContent.trim();
            const inputInvisible = document.createElement("textarea");
            inputInvisible.value = emailACopiar;
            document.body.appendChild(inputInvisible);
            inputInvisible.select();
            try {
                document.execCommand("copy");
                const textoOriginal = e.target.textContent;
                e.target.textContent = "¡Copiado!";
                setTimeout(() => {
                    e.target.textContent = textoOriginal;
                }, 1200);
            } catch (err) {
                console.error("Error al copiar", err);
            }
            document.body.removeChild(inputInvisible);
        });
    });
});

//activar_publicacion
function activar_publicacion(e) {
    if (confirm("Desea volver a poner disponible su publicación")) {
        const filaActual = e.closest(".fila_tabla2");
        const columnas = filaActual.querySelectorAll("td");
        const nuevo_id = columnas[0].textContent;
        const nuevo_categoria = columnas[2].textContent;
        const nuevo_zona = columnas[3].textContent;
        const nuevo_descripcion = columnas[4].textContent;
        const nuevo_disponible = 1;
        console.log(
            nuevo_id,
            nuevo_categoria,
            nuevo_zona,
            nuevo_descripcion,
            nuevo_disponible
        );
        enviar_datos_modificar_publicacion(
            nuevo_id,
            nuevo_categoria,
            nuevo_zona,
            nuevo_descripcion,
            nuevo_disponible
        );
    }
}
//finalizar_trabajo
async function finalizar_trabajo(e) {
    const filaActual = e.closest(".fila_tabla");
    const columnas = filaActual.querySelectorAll("td");
    const nuevo_categoria = columnas[3].textContent;
    const nuevo_zona = columnas[4].textContent;
    const nuevo_descripcion = columnas[5].textContent;
    const id_publicacion1 = columnas[0].textContent;
    let array_datos = {
        id_publicacion: id_publicacion1,
        categoria: nuevo_categoria,
        descripcion: nuevo_descripcion,
        zona: nuevo_zona,
    };
    console.log(array_datos);
    await fetch("../../backend/registrar_publicacion.php", {
        headers: { "Content-type": "application/json" },
        body: JSON.stringify(array_datos),
        method: "POST",
    })
        .then((res) => res.text())
        .then((res) => console.log(res));
    await fetch("../../backend/borrar_publicacion.php", {
        headers: { "Content-type": "text/plain" },
        body: `${id_publicacion1}`,
        method: "POST",
    });
    location.reload();
}

//modificar_usuario

let boton_modificar_usuario = document.querySelector(
    ".boton_modificar_usuario"
);
if (boton_modificar_usuario) {
    boton_modificar_usuario.addEventListener("click", (e) => {
        if (confirm("Esta seguro de modificar la contraseña de su usuario?")) {
            let fila_tabla = e.target.closest(".fila_tabla");
            const elementos = fila_tabla.querySelectorAll("td");
            const id = elementos[0].textContent;
            const contraseña = elementos[3].textContent;
            if (contraseña.length >= 6) {
                array_datos_usuario = {
                    id: id,
                    contraseña: contraseña,
                };
                fetch("../../backend/modificar_usuario.php", {
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(array_datos_usuario),
                    method: "POST",
                })
                    .then((res) => res.text())
                    .then((res) => alert(res));
            } else {
                alert(
                    "La contraseña tiene que tener como minimo 6 letras, vuelva a intentar."
                );
                location.reload();
            }
        }
    });
}
