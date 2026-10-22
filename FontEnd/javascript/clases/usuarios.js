import * as PETICIONES from "../peticiones_php.js";
export class usuarios {
    constructor(nombre_completo, email, contraseña) {
        this.nombre_completo = nombre_completo ?? null;
        this.email = email;
        this.contraseña = contraseña;
    }
}
export const leer_usuarios = () => {
    return PETICIONES.hacerPeticionesBD("usuarios.php", {
        accion: "leer_usuarios",
    });
};
export const agregar_usuario = (usuario) => {
    PETICIONES.hacerPeticionesBD("usuarios.php", {
        accion: "agregar_usuario",
        datos: usuario,
    });
};
export const verficar_usuario = (lista, user) => {
    return (promesa = new Promise((resolve) => {
        for (let usuario of lista) {
            if (
                usuario.correo === user.correo &&
                usuario.contraseña === user.contraseña
            ) {
                resolve(true);
                break;
            }
        }
        resolve(false);
    }));
};
export const verficar_correo_usuario = (lista, user) => {
    for (let usuario of lista) {
        if (usuario.correo === user.correo) {
            return true;
        }
    }
    return false;
};
