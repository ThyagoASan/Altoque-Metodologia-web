const botonesModificar = document.querySelectorAll(".tabla__boton_modificar");
botonesModificar.forEach((boton) => {
    boton.addEventListener("click", (e) => {
        const filaActual = e.target.closest(".fila_tabla");
        const columnas = filaActual.querySelectorAll("td");
        const nuevo_id = columnas[0].textContent;
        const nuevo_categoria = columnas[2].textContent;
        const nuevo_zona = columnas[3].textContent;
        const nuevo_descripcion = columnas[4].textContent;
        const valorDisponibilidad = columnas[5].querySelector("input");
        const result_disponible = valorDisponibilidad
            ? (valorDisponibilidad.checked ? 1 : 0)
            : Number(columnas[5].textContent.trim());
        enviar_datos_modificar_publicacion(
            nuevo_id,
            nuevo_categoria,
            nuevo_zona,
            nuevo_descripcion,
            result_disponible
        );
    });
});
const enviar_datos_modificar_publicacion = async (
    nuevo_id, nuevo_categoria, nuevo_zona, nuevo_descripcion, nuevo_disponible
) => {
    try {
        const respuesta = await fetch("../../backend/modificar_publicacion.php", {
            headers: { "Content-Type": "application/json" },
            method: "POST",
            body: JSON.stringify({
                id: nuevo_id,
                categoria: nuevo_categoria.trim(),
                zona: nuevo_zona.trim(),
                descripcion: nuevo_descripcion.trim(),
                disponible: nuevo_disponible,
            }),
        });
        const mensaje = await respuesta.text();
        alert(mensaje);
        if (!respuesta.ok) {
            if (mensaje.includes("volver activar")) {
                document.getElementById("section_mis_trabajos")?.scrollIntoView({ behavior: "smooth" });
            }
            return;
        }
        location.reload();
    } catch (error) {
        alert("No se pudo conectar con el servidor. Intentá nuevamente.");
    }
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
// Finaliza un trabajo solo si el servidor confirma el registro del reemplazo.
async function finalizar_trabajo(boton) {
    if (!confirm("¿Querés finalizar este trabajo y crear una nueva publicación disponible?")) return;
    const fila = boton.closest(".fila_tabla");
    if (!fila) { alert("No se encontró el trabajo."); return; }
    const columnas = fila.querySelectorAll("td");
    const datos = {
        id_publicacion: columnas[0]?.textContent.trim(),
        categoria: columnas[3]?.textContent.trim(),
        zona: columnas[4]?.textContent.trim(),
        descripcion: columnas[5]?.textContent.trim(),
    };
    boton.disabled = true;
    try {
        const respuesta = await fetch("../../backend/registrar_publicacion.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(datos),
        });
        const mensaje = await respuesta.text();
        if (!respuesta.ok) throw new Error(mensaje || "No se pudo finalizar el trabajo.");
        // La operación de registro ya actualizó el historial y creó la nueva publicación.
        // No se borra la original aquí para preservar su trazabilidad.
        alert(mensaje);
        location.reload();
    } catch (error) {
        alert(error.message || "Ocurrió un error al finalizar el trabajo.");
    } finally {
        boton.disabled = false;
    }
}

// Cambiar contraseña sin exponer el hash en la interfaz.
document.querySelectorAll(".boton_modificar_usuario").forEach(boton=>{
  boton.addEventListener("click",async()=>{
    const fila=boton.closest("tr");
    const actual=fila.querySelector(".password_actual")?.value||"";
    const nueva=fila.querySelector(".password_nueva")?.value||"";
    if(!actual||nueva.length<8){alert("Ingresá la contraseña actual y una nueva de al menos 8 caracteres.");return;}
    const res=await fetch("../../backend/modificar_usuario.php",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({actual,nueva})});
    const datos=await res.json();
    alert(datos.mensaje||datos.error||"Error al procesar el cambio.");
    if(res.ok){fila.querySelector(".password_actual").value="";fila.querySelector(".password_nueva").value="";}
  });
});
