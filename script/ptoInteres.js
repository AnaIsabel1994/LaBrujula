window.addEventListener("DOMContentLoaded",()=>{
    let favorito=document.querySelector(".guardarFav");
    let btnFav=document.getElementById("btnFav");
    let imagenPtoInteres=document.getElementById("imagenPtoInteres");
    let iGeneral=document.querySelector(".infoGeneral");
    let iUtil=document.querySelector(".datosInteres");
    let iCuriosa=document.querySelector(".datosInteresantes");

    //Funcion que, dado el ID correspondiente a un punto de interes, modifica el DOM para mostrar la información importante referente a ella.
    async function mostrarInformacion(id){
        try{
            let response=await fetch("https://weblabrujula.es/php/verPtoInteres.php?id="+id);
            let respuesta=await response.json();//Información extraida, en formato JSON
            //Compruebo que el codigo de respuesta sea 1 (no se han producido errores en el proceso)
            if(respuesta.codigo=='1'){
                imagenPtoInteres.src=respuesta.imagen;
                iGeneral.innerHTML=respuesta.infoGeneral;
                if (respuesta.infoUtil!=false){
                    iUtil.innerHTML=respuesta.infoUtil;
                }
                
                if(respuesta.infoCuriosa!=false){
                    iCuriosa.innerHTML=respuesta.infoCuriosa;
                }
                
            }else{
                location.href ='./index.html';
            }
        }catch(error){
            console.log("Error: "+error);
        }
    }

    //Funcion que comprueba si el usuario está logueado, o no
    //Si lo está, muestra la opción "Marcar como favorito" en los puntos de interes (display:block)
    async function mostrarFavorito(){
        let logueado=false;
        try{
            let response=await fetch("https://weblabrujula.es/php/comprobarUser.php");
            let respuesta=await response.json();//Información extraida, en formato JSON
            if (respuesta.codigo==1){
                favorito.style.display="flex";
            }else{
                favorito.style.display="none";
            }
        }catch(error){
            console.log("Error: "+error);
        }
        
    }

    //Funcion que cambia el estado de favorito, en funcion de si el usuario lo tiene o no guardado como tal
    async function esFavorito(id){
        let fav=false;
        try{
            let response=await fetch("https://weblabrujula.es/php/comprobarFavorito.php?id="+id);
            let respuesta=await response.json();//Información extraida, en formato JSON
            if (respuesta.codigo==1){
                btnFav.textContent="Quitar de favoritos";
            }
        }catch(error){
            console.log("Error: "+error);
        }
        
    }
    //Funcion que cambia el estado de un destino (favorito/no favorito)
    async function marcarFavorito(id,accion){
        try{
            let response=await fetch("https://weblabrujula.es/php/marcarFavorito.php?id="+id+"&accion="+accion);
            let respuesta=await response.json();//Información extraida, en formato JSON
            if (respuesta.codigo==1){
                if (accion=='si'){
                    btnFav.textContent="Quitar de favoritos"
                }else{
                    btnFav.textContent="Guardar como favorito"
                }
            }else{
                console.log(respuesta.mensaje);
                console.log(respuesta.script);
            }
        }catch(error){
            console.log("Error: "+error);
        }
    }


    window.addEventListener("load",()=>{
        let codigo=parseInt(valorVariable('cod'));//Llamo a la funcion que saca el valor del COD de la URL
        mostrarFavorito();
        esFavorito(codigo);
        mostrarInformacion(codigo);//Llamo a la función que modifica el DOM, para mostrar la informacion
        btnFav.addEventListener("click",(ev)=>{
            if (btnFav.textContent=="Guardar como favorito"){
                marcarFavorito(codigo,'si');
            }else{
                marcarFavorito(codigo,'no');
            }
        })
    })
})