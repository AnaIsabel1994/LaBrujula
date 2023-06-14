window.addEventListener("DOMContentLoaded",()=>{
    let formulario=document.getElementById("formNuevaClave");
    let clave=document.getElementById("nuevaClave");
    let mensajesError=document.getElementById("mensajesError");

    async function cambiarClaveUsuario(id){
        let datosFormulario=new FormData();
        datosFormulario.append("idUsuario",id);
        datosFormulario.append("nuevaClave",clave.value);
        let response=await fetch("https://weblabrujula.es/php/cambioClave2.php", {
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
           mensajesError.style.display="block";
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
        comprobarAdmin();
        let id=parseInt(valorVariable('id'));//Llamo a la funcion que saca el valor del ID de la URL
        mensajesError.style.display="block";
        comprobarUsuario();
        formulario.addEventListener("submit",(ev)=>{
            ev.preventDefault();//Cancelo el envío de formulario
            mensajesError.innerHTML="";//Vacio el DIV de errores
            let centinela=true;
            if (clave.value=="" || !validarClave(clave.value)){
                mensajesError.innerHTML+="<p>No has introducido una clave valida</p>";
                centinela=false;
            }
            if (centinela){
                cambiarClaveUsuario(id);
            }
        })
    })
})