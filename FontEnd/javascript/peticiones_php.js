export const hacerPeticionesBD = (nombre_php, peticion) => {
    try {
        console.log("prueba");
        return fetch(
            `http://localhost/Proyecto-Altoque-_desarrollo_y_Arquitect_web/backend/${nombre_php}`,
            {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: peticion,
            }
        )
            .then((res) => res.json())
            .then((datos) => datos);
    } catch (e) {
        console.log(e);
        debugger;
    }
};
