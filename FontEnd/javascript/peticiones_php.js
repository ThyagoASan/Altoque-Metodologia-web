// Las rutas se resuelven desde las páginas de FontEnd/html_y_css/.
// Evita depender del nombre de la carpeta del proyecto en htdocs.
export async function hacerPeticionesBD(nombre_php, peticion) {
    if (!/^[a-zA-Z0-9_-]+\.php$/.test(nombre_php)) {
        throw new Error("Nombre de endpoint inválido.");
    }

    const respuesta = await fetch(`../../backend/${nombre_php}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: typeof peticion === "string" ? peticion : JSON.stringify(peticion),
    });

    if (!respuesta.ok) {
        throw new Error(`Error HTTP ${respuesta.status} al consultar ${nombre_php}`);
    }

    return respuesta.json();
}
