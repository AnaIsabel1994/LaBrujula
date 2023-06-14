window.addEventListener("DOMContentLoaded",()=>{
    let carrusel = document.querySelector('#destinosSugeridos');

    //Función que asigna al carrusel los destinos marcados como sugeridos
    async function asignarCarrusel(){
        let destinos=carrusel.children;
        //Realizo una petición al servidor, que devuelve un array con las tres ciudades marcadas como destino sugerido
        try{
            let response=await fetch("https://weblabrujula.es/php/destinosSugeridos.php");
            let respuesta=await response.json();//Información extraida, en formato JSON

            //Compruebo el JSON
            if (respuesta.codigo==2){
                document.getElementById("destinos").innerHTML=respuesta.mensaje;
            }else{
                //Asigno al carrusel, los destinos devueltos por la consulta
                let imagen;
                let enlace;
                for (let i=0;i<respuesta.sugerencias.length;i++){
                    enlace=destinos[i].firstElementChild;
                    //Creo un elemento imagen
                    imagen=document.createElement("img");
                    //Modifico sus propiedades
                    imagen.src="./archivos/"+respuesta.sugerencias[i].id+"/fotoIndex"+respuesta.sugerencias[i].formatoFoto;
                    imagen.alt="Enlace al destino "+respuesta.sugerencias[i].nombre;
                    imagen.classList.add("d-block");
                    //Añado las clases
                    imagen.classList.add("w-50");
                    imagen.classList.add("h-auto");
                    imagen.classList.add("mx-auto");
                    //Sustituyo en el carrusel el elemento correspondiete, por el creado
                    enlace.replaceChild(imagen,enlace.firstElementChild);
                    //Añado el título
                    enlace.lastElementChild.innerHTML="<h1 class='font-weight-bold text-white'>"+respuesta.sugerencias[i].nombre+"</h1>";
                    //Añado el enlace al destino correspondiente
                    enlace.href="./destino.html?id="+respuesta.sugerencias[i].id;
                }
                let numeroElementos=destinos.length-1;
                let indicadores=document.getElementById("carouselIndicators");
                while(respuesta.sugerencias.length<numeroElementos){
                    let ultimoElemento=destinos[numeroElementos-1];
                    carrusel.removeChild(ultimoElemento);
                    numeroElementos=carrusel.children.length-1;
                    
                    
                    let boton=indicadores.children[indicadores.children.length-1];
                    indicadores.removeChild(boton);
                }
            }
        }catch(error){
            console.log("Error: "+error);
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
        asignarCarrusel();
    })
})