window.addEventListener("DOMContentLoaded",()=>{
    let formulario=document.getElementById("formClave");
    let email=document.getElementById("emailRecuperacion");
    let mensajesError=document.getElementById("mensajesError");

    async function solicitarCambioClave(){
        let datosFormulario=new FormData();
        datosFormulario.append("email",email.value);
        let response=await fetch("https://weblabrujula.es/php/cambioClave1.php", {
            method: "post",
            body: datosFormulario,
       });
        let respuesta=await response.json();//Información extraida, en formato JSON
       if (respuesta.codigo==1){
           mensajesError.style.color='green';
           mensajesError.innerHTML=respuesta.mensaje;
           setTimeout(function() {
                location.href="./index.html";
            }, 3000);
       }else{
           mensajesError.innerHTML+="<p>"+respuesta.mensaje+"</p>";
           window.scrollTo(0,0);
       }
    }
    //Función que comprueba si existe cookie de sesión (sin persistencia), correspondiente al usuario
    async function comprobarUsuario(){
        let response=await fetch("https://weblabrujula.es/php/comprobarUser.php");
        let respuesta=await response.json();//Información extraida, en formato JSON
        //Si existe, modificará el enlace del apartado Cuenta
        if (respuesta.codigo==1){//Hay sesión de usuario activa
            location.href="./cuenta.html";
        }
    }
    async function comprobarAdmin(){
        let response=await fetch("https://weblabrujula.es/php/comprobarAdmin.php");
        let respuesta=await response.json();//Información extraida, en formato JSON
        if (respuesta.codigo==1){//Hay sesión de usuario activa
            let response=await fetch("https://weblabrujula.es/php/cerrarSesion.php");
        }
    }

    window.addEventListener("load",()=>{
        mensajesError.style.display="block";
        comprobarAdmin();
        comprobarUsuario();
        formulario.addEventListener("submit",(ev)=>{
            ev.preventDefault();//Cancelo el envío de formulario
            mensajesError.innerHTML="";//Vacio el DIV de errores
            let centinela=true;
            if (email.value=="" || !validarEmail(email.value)){
                mensajesError.innerHTML+="<p>No has introducido una dirección de correo electrónico valida</p>";
                centinela=false;
                window.scrollTo(0,0);
            }
            if (centinela){//Si hay algun error, muestro el DIV mensajesError, y cancelo el envio del formulario
                solicitarCambioClave();
            }
        })
    })
})