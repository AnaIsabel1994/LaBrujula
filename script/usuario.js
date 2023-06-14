window.addEventListener("DOMContentLoaded",()=>{
    /* Identificadores de los botones */
    let cerrarSesion=document.getElementById("cerrarSesion");
    let bloquePtos=document.getElementById("tarjetasDestinos");
    let bloqueNada=document.getElementById("ningunFavorito");
    
    //Funcion que verifica que existe la variable de sesión de usuario
    async function comprobarUsuario(){
        let response=await fetch("https://weblabrujula.es/php/comprobarUser.php");
        let respuesta=await response.json();//Información extraida, en formato JSON
        if (respuesta.codigo==2){//No hay sesión de usuario activa
            location.href="./index.html";
        }
    }
    async function verGuardados(){
        let response=await fetch("https://weblabrujula.es/php/listadoFavoritos.php");
        let respuesta=await response.json();//Información extraida, en formato JSON
        if (respuesta.codigo==1){//El usuario tiene algun punto de interés marcado como favorito
            bloqueNada.style.display="none";

            //Una vez que se ha mostrado el bloque correspondiente, lo relleno con la información recibida
            let tarjeta;
            let listado;
            let elemento;
            for (let i=0;i<respuesta.lista.length;i++){
                
                bloquePtos.innerHTML+='<div class="col-lg-4 col-md-6 col-sm-12 destinosFavoritos"><div class="card tarjetaGuardados"><img src="'+respuesta.lista[i].imagenCiudad+'" class="card-img-top" alt="Imagen de la ciudad"><div class="card-body"><h5 class="card-title">'+respuesta.lista[i].nombreCiudad+'</h5><p class="card-text">'+respuesta.lista[i].nombrePais+'</p></div></div></div>';
                tarjeta=bloquePtos.lastChild.lastChild;
                tarjeta.innerHTML=tarjeta.innerHTML+'<ul class="list-group list-group-flush"></ul>';
                listado=tarjeta.lastChild;
                for (let j=0;j<respuesta.lista[i].listaPtos.length;j++){
                    elemento=document.createElement("li");
                    elemento.classList.add("list-group-item");
                    elemento.innerHTML='<a href="./ptoInteres.html?id='+respuesta.lista[i].idCiudad+'&cod='+respuesta.lista[i].listaPtos[j].idPto+'">'+respuesta.lista[i].listaPtos[j].nombrePto+'</a>';
                    listado.appendChild(elemento);
                }
                tarjeta.innerHTML=tarjeta.innerHTML+'<div class="card-body botonPdf"><button type="button" class="btn btn-primary" id="'+respuesta.lista[i].idCiudad+'" data-bs-target="#confirmacionPdf">Descargar PDF</button></div>';
                
            }
            let botonesPdf=document.getElementsByClassName("botonPdf");
            for (let i=0;i<botonesPdf.length;i++){
                botonesPdf[i].firstChild.addEventListener("click",(ev)=>{
                    //Redirijo a la página que muestra, y permite descargar un PDF con la info.
                    window.open("./php/generarPdf.php?id="+ev.target.id, '_blank');
                })
            }
        }else{//El usuario no tiene algún punto de interés marcados como favoritos
            bloqueNada.style.display="block";
        }
    }
    window.addEventListener("load",()=>{
        comprobarUsuario();
        verGuardados();
        //Escucha de eventos para cada botón, que redirige a su correspondiente destino
        cerrarSesion.addEventListener("click",()=>{
            location.href="./php/cerrarSesion.php";
        })
    })
})