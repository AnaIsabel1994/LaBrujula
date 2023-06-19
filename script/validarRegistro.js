window.addEventListener("DOMContentLoaded",()=>{
    let formulario=document.getElementById("formRegistro");
    let email=document.getElementById("emailReg");
    let clave1=document.getElementById("claveReg1");
    let clave2=document.getElementById("claveReg2");
    let fechaN=document.getElementById("fechaNReg");
    let termCond=document.getElementById("termCond");
    let boton=document.getElementById("enviar");
    let mensajesError=document.getElementById("mensajesError");

    async function registrarUsuario(){
        let datosFormulario=new FormData();
        datosFormulario.append("email", email.value);
        datosFormulario.append("clave",clave1.value);
        if (fechaN.value!=""){
            datosFormulario.append("fNac",fechaN.value);
        }
        let response=await fetch("https://weblabrujula.es/php/registro.php", {
            method: "post",
            body: datosFormulario,
       });
       let respuesta=await response.json();//Información extraida, en formato JSON
       if (respuesta.codigo==1){
           mensajesError.style.color='green';
           mensajesError.innerHTML="Se ha enviado un email de confirmación a la dirección aportada.";
           setTimeout(function() {
                location.href="./index.html";
            }, 3000);
       }else{
           mensajesError.innerHTML+="<p>"+respuesta.mensaje+"</p>";
           boton.disabled=false;
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
            boton.disabled=true;//Deshabilito el botón enviar, para evitar que vuelva a pulsarse, mientras realizo las comprobaciones
            mensajesError.innerHTML="";//Vacio el DIV de errores
            let centinela=true;
            if (email.value==""){
                mensajesError.innerHTML+="<p>No has introducido una dirección de correo electrónico</p>";
                centinela=false;
            }
            if (clave1.value=="" || !validarClave(clave1.value)){
                if (clave1.value==""){
                    mensajesError.innerHTML+="<p>Introduce una contraseña</p>";
                    centinela=false;
                }else{
                    mensajesError.innerHTML+="<p>La contraseña no es válida</p>";
                    centinela=false;
                }
            }else{
                if (clave2.value!=clave1.value){
                    mensajesError.innerHTML+="<p>Las contraseñas no coinciden</p>";
                    centinela=false;
                }
            }
            if (termCond.checked==false){
                mensajesError.innerHTML+="<p>Tienes que marcar la casilla de 'Acepto los términos...' para continuar</p>";
                centinela=false;
            }

            if (!centinela){//Si hay algun error, muestro el DIV mensajesError, habilito de nuevo el boton Enviar, y cancelo el envio del formulario
                boton.disabled=false;
                window.scrollTo(0,0);
            }else{
                registrarUsuario();
            }
        })
    })
})