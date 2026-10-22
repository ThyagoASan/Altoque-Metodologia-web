import * as USUARIOS from "./clases/usuarios.js";

const base_de_datos = indexedDB.open("base_usuarios", 1);
let lista_de_usuarios = [];
base_de_datos.addEventListener("upgradeneeded", () => {
    resultado = base_de_datos.result;
    resultado.createObjectStore("usuarios", { autoIncrement: true });
});
base_de_datos.addEventListener("success", async () => {
    lista_de_usuarios = await leer_objetos();
    console.log(lista_de_usuarios);
});

const agregar_objetos = async (objeto) => {
    console.log(objeto);
    consulta_transaction = base_de_datos.result.transaction(
        "usuarios",
        "readwrite"
    );
    confirmacion_transaction = consulta_transaction.objectStore("usuarios");
    confirmacion_transaction.add(objeto);
};
const modificar_objetos = (key, objeto) => {
    consulta_transaction = base_de_datos.result.transaction(
        "usuarios",
        "readwrite"
    );
    confirmacion_transaction = consulta_transaction.objectStore("usuarios");
    confirmacion_transaction.put(objeto, key);
};
const borrar_objetos = (key) => {
    consulta_transaction = base_de_datos.result.transaction(
        "usuarios",
        "readwrite"
    );
    confirmacion_transaction = consulta_transaction.objectStore("usuarios");
    confirmacion_transaction.delete(key);
};
const leer_objetos = () => {
    let resultado = base_de_datos.result;
    const consulta_transaction = resultado.transaction("usuarios", "readonly");
    const confirmacion_transaction =
        consulta_transaction.objectStore("usuarios");
    const cursor = confirmacion_transaction.openCursor();
    let todos_los_usuarios = [];
    cursor.addEventListener("success", () => {
        if (cursor.result) {
            todos_los_usuarios.push(cursor.result.value);
            cursor.result.continue();
        }
    });
    return todos_los_usuarios;
};
try {
    if (window.location.pathname !== "/html%20y%20css/sesion.html") {
        const formulario_registro = document.querySelector(".formulario1");
        console.log(JSON.stringify(lista_de_usuarios));
        formulario_registro.addEventListener("submit", async () => {
            let nombre_completo_registro = document.getElementById(
                "nombre_completo_registro"
            ).value;
            let email_registro =
                document.getElementById("email_registro").value;
            let contraseña_registro = document.getElementById(
                "contraseña_registro"
            ).value;
            let nuevo_usuario = new USUARIOS.usuarios(
                nombre_completo_registro,
                email_registro,
                contraseña_registro
            );
            if (
                !USUARIOS.verficar_correo_usuario(
                    lista_de_usuarios,
                    nuevo_usuario
                )
            ) {
                USUARIOS.agregar_usuario(nuevo_usuario);
                alert("Se registro exitosamente");
            } else {
                alert("Ya exite un usuario con ese correo.");
            }
        });
    } else {
        formulario_login = document.querySelector(".formulario_login");
        console.log(formulario_login);
        formulario_login.addEventListener("submit", async (e) => {
            let correo_login = document.getElementById("email_login").value;
            let contraseña_login =
                document.getElementById("contraseña_login").value;
            let nuevo_usuario = new USUARIOS.usuarios(
                null,
                correo_login,
                contraseña_login
            );
            lista_de_usuarios = USUARIOS.leer_usuarios();
            console.log(lista_de_usuarios);
            alert("dsaf");
            if (
                await USUARIOS.verficar_usuario(
                    lista_de_usuarios,
                    nuevo_usuario
                )
            ) {
                e.preventDefault();
                alert("Se inicio sesion correctamente.");
                window.location.href = "pagina1.html";
            } else {
                alert("error: usuario o contraseña incorrectos.");
            }
        });
    }
} catch (e) {
    console.log(e);
}
lista_de_usuarios = fetch(
    `http://localhost/Proyecto-Altoque-_desarrollo_y_Arquitect_web/backend/usuarios.php`,
    {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify("leer_usuarios"),
    }
)
    .then((res) => res.json())
    .then((datos) => datos);
for (let usuario of lista_de_usuarios) {
    document.write(usuario);
}
