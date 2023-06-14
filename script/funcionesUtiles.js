//Funcion que dado el nombre de una variable, lee la URL de la pagina, y devuelve su valor
function valorVariable(nombre) {
    nombre = nombre.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + nombre + "=([^&#]*)"),
    resultado = regex.exec(location.search);
    return resultado === null ? "" : decodeURIComponent(resultado[1].replace(/\+/g, " "));
}

//Función que, dado un String como parametro, valida que cumpla el patrón de un email
function validarEmail(email){
    let patron=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return patron.test(email);
}
//Funcion que, dado un string valida que:
/*
* - Contenga al menos 1 digito, una letra mayuscula, una letra minuscula y un punto
* - Su longitud sea como mínimo de 7 caracteres y como máximo de 20 caracteres
*/
function validarClave(clave){
    let patron=/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[\.]).{7,20}$/;
    return patron.test(clave);
}
function validarImagen(nombreArchivo){
    let patron=/.*(\.jpeg|\.jpg|\.png)$/;
    return patron.test(clave);
}
function validarTexto(nombreArchivo){
    let patron=/.*\.txt$/;
    return patron.test(clave);
}