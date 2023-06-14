window.addEventListener("DOMContentLoaded",()=>{
    let formulario=document.getElementById("formContacto");
    let motivo=document.getElementById("motivo");
    let email=document.getElementById("email");
    let mensaje=document.getElementById("mensaje");
    let boton=document.getElementById("enviar");
    let mensajesError=document.getElementById("mensajesError");
    //Función que envía a PHP el mensaje enviado mediante el formulario de contacto
    async function enviarMensaje(){
        let datosFormulario=new FormData();
        datosFormulario.append("email", email.value);
        datosFormulario.append("motivo",motivo.value);
        datosFormulario.append("mensaje",mensaje.value);
        let response=await fetch("https://weblabrujula.es/php/formContacto.php", {
            method: "post",
            body: datosFormulario,
       });
        let respuesta=await response.json();//Información extraida, en formato JSON
        if (respuesta.codigo==1){
            mensajesError.style.color='green';
            mensajesError.innerHTML=respuesta.mensaje;
            setTimeout(function() {
                location.href="./index.html";
            }, 3000)
        }else{
            mensajesError.innerHTML+="<p>"+respuesta.mensaje+"</p>";
            boton.disabled=false;
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
        formulario.addEventListener("submit",(ev)=>{
            ev.preventDefault();//Cancelo el envío de formulario
            boton.disabled=true;//Deshabilito el botón enviar, para evitar que vuelva a pulsarse, mientras realizo las comprobaciones
            mensajesError.innerHTML="";//Vacio el DIV de errores
            let centinela=true;
            if (email.value==""){
                mensajesError.innerHTML+="<p>No has introducido una dirección de correo electrónico</p>";
                centinela=false;
            }
            if (mensaje.value==""){
                mensajesError.innerHTML+="<p>No has escrito ningún mensaje.</p>";
                centinela=false;
            }
            if (motivo.value==0){
                mensajesError.innerHTML+="<p>Tienes que seleccionar un motivo del mensaje.</p>";
                centinela=false;
            }
            if (!centinela){//Si hay algun error, muestro el DIV mensajesError, habilito de nuevo el boton Enviar, y cancelo el envio del formulario
                
                boton.disabled=false;
            }else{
                enviarMensaje();
            }
        })
    })
})