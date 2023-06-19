window.addEventListener("DOMContentLoaded",()=>{
    let formulario=document.getElementById("formInicioSesion");
    let email=document.getElementById("email");
    let clave=document.getElementById("clave");
    let boton=document.getElementById("enviar");
    let mensajesError=document.getElementById("mensajesError");
    //Función que envía a PHP los datos de inicio de sesión, recoge la respuesta, e inicia sesión o muestra un mensaje de error según corresponda
    async function inicioSesion(){
        let datosFormulario=new FormData();
        datosFormulario.append("email", email.value);
        datosFormulario.append("clave",clave.value);
        let response=await fetch("https://weblabrujula.es/php/inicioSesion.php", {
            method: "post",
            body: datosFormulario,
       });
        let respuesta=await response.json();//Información extraida, en formato JSON
        if (respuesta.codigo==1){
            if (respuesta.tipo=='admin'){
                location.href="./admin.html";
            }else{
                location.href="./cuenta.html";
            }
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
        //Si existe, modificará el enlace del apartado Cuenta
        if (respuesta.codigo==1){//Hay sesión de usuario activa
            location.href="./admin.html";
        }
    }

    window.addEventListener("load",()=>{
        //Compruebo si ya está iniciada la sesión
        comprobarUsuario();
        comprobarAdmin();
        mensajesError.style.display="block";
        formulario.addEventListener("submit",(ev)=>{
            ev.preventDefault();//Cancelo el envío de formulario
            boton.disabled=true;//Deshabilito el botón enviar, para evitar que vuelva a pulsarse, mientras realizo las comprobaciones
            mensajesError.innerHTML="";//Vacio el DIV de errores
            let centinela=true;
            if (email.value==""){
                mensajesError.innerHTML+="<p>No has introducido una dirección de correo electrónico</p>";
                centinela=false;
            }
            if (clave.value==""){
                mensajesError.innerHTML+="<p>Introduce una clave</p>";
                centinela=false;
            }

            if (!centinela){//Si hay algun error, muestro el DIV mensajesError, habilito de nuevo el boton Enviar, y cancelo el envio del formulario
                boton.disabled=false;
                window.scrollTo(0,0);
            }else{
                inicioSesion();
            }
        })
    })
})