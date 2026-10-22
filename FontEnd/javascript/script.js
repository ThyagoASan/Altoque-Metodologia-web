//pagina1 funcion de cambiar filtro.
let input_buscador = document.getElementById("input_buscador_localidad");
let combobox_filtro = document.getElementById("combo_filtro");
if (combobox_filtro) {
    combobox_filtro.addEventListener("change", async (e) => {
        input_buscador.value = "";
        const valor = e.target.value;
        if (valor == "Profeción") {
            let docu_fragment = document.createDocumentFragment();
            let array_profeciones = [
                "Electricista",
                "Plomero",
                "Limpieza",
                "Jardinería",
            ];
            for (i = 0; i < 4; i++) {
                let opcion = document.createElement("option");
                opcion.value = array_profeciones[i];
                docu_fragment.appendChild(opcion);
            }
            let lista_input = document.getElementById("lista_input");
            lista_input.innerHTML = "";
            lista_input.appendChild(docu_fragment);
            input_buscador.placeholder = "Escribir la profeción";
        } else if (valor == "Localidad") {
            let respuesta = await fetch("../../backend/leer_localidades.php", {
                method: "POST",
                body: "",
                headers: { "Content-Type": "text.plain" },
            })
                .then((res) => res.json())
                .then((res) => res);
            let docu_fragment = document.createDocumentFragment();
            for (const localidad of respuesta) {
                let opcion = document.createElement("option");
                opcion.value = localidad["localidad"];
                docu_fragment.appendChild(opcion);
            }
            let lista_input = document.getElementById("lista_input");
            lista_input.innerHTML = "";
            lista_input.appendChild(docu_fragment);
            input_buscador.placeholder = "Escribir la localidad";
        }
    });
}
let evento_inicial = new Event("change");
if (combobox_filtro) {
    combobox_filtro.dispatchEvent(evento_inicial);
    //pagina1 funcion buscar publicaciones con el input
    let controladorBusqueda = null;
    input_buscador.addEventListener("input", async (e) => {
        const valorInput = e.target.value.trim();
        const filtro = document.getElementById("combo_filtro");
        const campo = filtro.value === "Localidad" ? "zona" : "categoria";
        const contenedor = document.getElementById("contenedorServicios");

        if (controladorBusqueda) controladorBusqueda.abort();
        controladorBusqueda = new AbortController();
        try {
            const respuesta = await fetch("../../backend/leer_publicaciones.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify([campo, valorInput]),
                signal: controladorBusqueda.signal,
            });
            if (!respuesta.ok) throw new Error("No fue posible consultar los servicios.");
            const publicaciones = await respuesta.json();
            const fragmento = document.createDocumentFragment();
            if (publicaciones.length === 0) {
                const mensaje = document.createElement("p");
                mensaje.textContent = "No se encontraron servicios para este filtro.";
                fragmento.appendChild(mensaje);
            }
            for (const publicacion of publicaciones) {
                const articulo = document.createElement("article");
                articulo.className = "tarjeta-servicio";
                if (publicacion.rol === "usuario_premium") {
                    articulo.classList.add("tarjeta_premium");
                    const destacado = document.createElement("span");
                    destacado.className = "span_premium";
                    destacado.textContent = "Premium";
                    articulo.appendChild(destacado);
                }
                const titulo = document.createElement("h3");
                titulo.textContent = publicacion.nombre;
                articulo.appendChild(titulo);
                for (const [etiqueta, valor] of [
                    ["Oficio", publicacion.categoria],
                    ["Zona", publicacion.zona],
                    ["Descripción", publicacion.descripcion],
                ]) {
                    const parrafo = document.createElement("p");
                    const negrita = document.createElement("strong");
                    negrita.textContent = etiqueta + ": ";
                    parrafo.append(negrita, document.createTextNode(valor));
                    articulo.appendChild(parrafo);
                }
                const enlace = document.createElement("a");
                enlace.className = "enlace-perfil";
                enlace.href = "perfil.php?id=" + encodeURIComponent(publicacion.id);
                enlace.textContent = "Ver perfil de " + publicacion.nombre;
                articulo.appendChild(enlace);
                fragmento.appendChild(articulo);
            }
            contenedor.replaceChildren(fragmento);
        } catch (error) {
            if (error.name === "AbortError") return;
            const aviso = document.createElement("p");
            aviso.setAttribute("role", "alert");
            aviso.textContent = "Error al cargar los resultados. Intentá nuevamente.";
            contenedor.replaceChildren(aviso);
        }
    });
}
//validacion de confirmacion mas contratacion
let boton_contratar = document.getElementById("btn-contratar");
async function contratar_profecional() {
    id_publicacion_a_contratar = boton_contratar.dataset.id_publicacion;
    if (confirm("Desea seguir adelante con su contratación.")) {
        await fetch("../../backend/publicacion_contratar.php", {
            headers: { "Content-Type": "text_plain" },
            method: "POST",
            body: id_publicacion_a_contratar,
        })
            .then((res) => res.text())
            .then((res) => {
                alert(res);
                if (res == "Usted tiene que inicio sesión para contratar.") {
                    location.href = "../html_y_css/sesion.php";
                } else {
                    location.href = "../html_y_css/pagina1.php";
                }
            });
    }
}
//control de estrellas.
let estrellas = document.querySelectorAll(".star");
if (estrellas) {
    estrellas.forEach((estrella) => {
        estrella.addEventListener("click", () => {
            valor = estrella.dataset.value;
            if (!estrella.classList.contains("rellenas")) {
                estrellas.forEach((estrella1) => {
                    valor_estrella = estrella1.dataset.value;
                    if (valor_estrella <= valor) {
                        estrella1.classList.add("rellenas");
                    } else {
                        estrella1.classList.remove("rellenas");
                    }
                });
            } else if (estrella.dataset.value == get_estrella_mayor_valor()) {
                estrellas.forEach((estrella1) => {
                    estrella1.classList.remove("rellenas");
                });
            } else {
                estrellas.forEach((estrella1) => {
                    valor_estrella = estrella1.dataset.value;
                    if (valor_estrella <= valor) {
                        estrella1.classList.add("rellenas");
                    } else {
                        estrella1.classList.remove("rellenas");
                    }
                });
            }
        });
    });
}
function get_estrella_mayor_valor() {
    estrellas = document.querySelectorAll(".star");
    valor_anterior = 0;
    valor_mas_alto = 0;
    estrellas.forEach((estrella) => {
        if (estrella.classList.contains("rellenas")) {
            if (valor_anterior < estrella.dataset.value) {
                valor_mas_alto = estrella.dataset.value;
            } else {
                valor_anterior = estrella.dataset.value;
            }
        }
    });
    return valor_mas_alto;
}
//funcion enviar reseña estrellas
function guardar_estrellas(e) {
    array_datos = {
        estrellas: get_estrella_mayor_valor(),
        id_usuario: e.dataset.id_usuario,
        id_publicacion: e.dataset.id_publicacion,
    };
    fetch("../../backend/guardar_estrellas.php", {
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(array_datos),
        method: "POST",
    }).then(location.reload());
}

//rellenar promedio de estrellas

window.addEventListener("load", async () => {
    if (window.location.pathname.includes("perfil.php")) {
        id_publicacion = document.querySelector("body").dataset.id_publicacion;
        promedio_estrellas = await fetch(
            "../../backend/get_promedio_estrellas.php",
            {
                headers: { "Content-Type": "text/plain" },
                body: id_publicacion,
                method: "POST",
            }
        )
            .then((res) => res.text())
            .then((res) => res);
        promedio_estrellas = Number(promedio_estrellas);
        estrellas_promedio = document.querySelectorAll(".star_promedio");
        estrellas_promedio.forEach((estrella_p) => {
            if (estrella_p.dataset.value <= promedio_estrellas) {
                estrella_p.classList.add("rellenas");
            } else {
                estrella_p.classList.remove("rellenas");
            }
        });
        p_text_promedio = document.getElementById("cantidad_estrellas");
        p_text_promedio.textContent = promedio_estrellas + " estrellas";
    }
});
