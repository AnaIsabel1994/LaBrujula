window.addEventListener("DOMContentLoaded",()=>{
    /* Identificadores de los botones */
    let cerrarSesion=document.getElementById("cerrarSesion");
    let btnNPais=document.getElementById("nuevoPais");
    let btnEPais=document.getElementById("eliminarPais");
    let btnNCiudad=document.getElementById("nuevaCiudad");
    let btnMCiudad=document.getElementById("modifCiudad");
    let btnDestinosF=document.getElementById("destinosFav");
    let btnNPtoI=document.getElementById("nuevoPtoInteres");
    let btnMPtoI=document.getElementById("modifPtoInteres");
    let btnAdminU=document.getElementById("adminUsuarios");
    
    //Funcion que verifica que existe la variable de sesión de administrador
    async function comprobarAdmin(){
        let response=await fetch("https://weblabrujula.es/php/comprobarAdmin.php");
        let respuesta=await response.json();//Información extraida, en formato JSON
        if (respuesta.codigo==2){//Hay sesión de usuario activa
            location.href="./index.html";
        }
    }


    window.addEventListener("load",()=>{
        comprobarAdmin();
        //Escucha de eventos para cada botón, que redirige a su correspondiente destino
        cerrarSesion.addEventListener("click",()=>{
            location.href="./php/cerrarSesion.php";
        })
        //Agregar pais
        btnNPais.addEventListener("click",(ev)=>{
            location.href="./adminAcciones.html?cod=p1";
        })
        //Eliminar pais
        btnEPais.addEventListener("click",(ev)=>{
            location.href="./adminAcciones.html?cod=p2";
        })
        //Agregar ciudad
        btnNCiudad.addEventListener("click",(ev)=>{
            location.href="./adminAcciones.html?cod=c1";
        })
        //Modificar/Eliminar ciudad
        btnMCiudad.addEventListener("click",(ev)=>{
            location.href="./adminAcciones.html?cod=c2";
        })
        btnDestinosF.addEventListener("click",(ev)=>{
            location.href="./adminAcciones.html?cod=c3";
        })
        //Agregar punto de interés
        btnNPtoI.addEventListener("click",(ev)=>{
            location.href="./adminAcciones.html?cod=pi1";
        })
        //Modificar/Eliminar punto de interés
        btnMPtoI.addEventListener("click",(ev)=>{
            location.href="./adminAcciones.html?cod=pi2";
        })
        btnAdminU.addEventListener("click",(ev)=>{
            location.href="./adminAcciones.html?cod=a";
        })
    })
})