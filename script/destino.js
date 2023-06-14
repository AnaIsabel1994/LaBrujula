window.addEventListener("DOMContentLoaded",()=>{
    let imagen=document.getElementById("imagenCiudad");
    let info=document.getElementById("infoCiudad");
    let nombre=document.getElementById("nombreCiudad");
    //Funcion que, dado el ID correspondiente a una ciudad, modifica el DOM para mostrar la información referente a ella.
    async function mostrarDestino(id){
        try{
            let response=await fetch("https://weblabrujula.es/php/verCiudad.php?id="+id);
            let respuesta=await response.json();//Información extraida, en formato JSON
            //Compruebo que el codigo de respuesta sea 1 (no se han producido errores en el proceso)
            if(respuesta.codigo=='1'){
                nombre.textContent=respuesta.nombre;
                imagen.src=respuesta.imagen;
                imagen.alt="Imagen de "+respuesta.nombre;
                info.innerHTML=respuesta.info;
            }else{
                nombre.parentElement.style.color='red';
                nombre.parentElement.innerHTML="<p>"+respuesta.mensaje+"</p>";
                setTimeout(function() {
                    location.href="./index.html";
                }, 2000)
            }
        }catch(error){
            console.log("Error: "+error);
        }
    }
    window.addEventListener("load",()=>{
        let id=parseInt(valorVariable('id'));//Llamo a la funcion que saca el valor del ID de la URL
        mostrarDestino(id);

    })
})