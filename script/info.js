window.addEventListener("DOMContentLoaded",()=>{
    let documentacion=document.getElementById("tarjetaDocumentacion");
    let fiestas=document.getElementById("tarjetaFiestas");
    let hComercial=document.getElementById("tarjetaHComercial");
    let llegada=document.getElementById("tarjetaLlegada");
    let precios=document.getElementById("tarjetaPrecios");
    let tiempo=document.getElementById("tarjetaTiempo");
    let transporte=document.getElementById("tarjetaTransporte");

    //Funcion que dado el nombre de una variable, lee la URL de la pagina, y devuelve su valor

    //Funcion que, dado el ID correspondiente a una ciudad, modifica el DOM para mostrar la información importante referente a ella.
    async function mostrarInfo(id){
        try{
            let response=await fetch("https://weblabrujula.es/php/verInfo.php?id="+id);
            let respuesta=await response.json();//Información extraida, en formato JSON
            //Compruebo que el codigo de respuesta sea 1 (no se han producido errores en el proceso)
            if(respuesta.codigo=='1'){
                documentacion.innerHTML=respuesta.documentacion;
                fiestas.innerHTML=respuesta.fiestas;
                hComercial.innerHTML=respuesta.hComercial;
                llegada.innerHTML=respuesta.llegada;
                precios.innerHTML=respuesta.precios;
                tiempo.innerHTML=respuesta.tiempo;
                transporte.innerHTML=respuesta.transporte;
            }else{
                location.href="./index.html";
            }
        }catch(error){
            console.log("Error: "+error);
        }
    }
    window.addEventListener("load",()=>{
        let id=parseInt(valorVariable('id'));//Llamo a la funcion que saca el valor del ID de la URL
        mostrarInfo(id);

    })
})