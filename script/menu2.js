window.addEventListener("DOMContentLoaded",()=>{
    let inicio=document.querySelector(".colInicio");
    let info=document.querySelector(".colInfo");
    let queVer=document.querySelector(".colVer");
    
    //Dado el id, correspondiente a una ciudad, modifica el menú secundario
    async function rellenarDesplegable2(id){
        //Modifico el enlace Inicio
        inicio.firstElementChild.href="./destino.html?id="+id;
        //Modifico el enlace Información importante
        info.firstElementChild.href="./info.html?id="+id;
        //Relleno el desplegable del enlace Que ver
        //Realizo un fetch al servidor, para obtener una lista de los puntos de interes asociados a la ciudad
        try{
            let response=await fetch("https://weblabrujula.es/php/listarPtosInteres.php?id="+id);
            let respuesta=await response.json();//Información extraida, en formato JSON

            let nuevoGrupo;
            let listaElementos;
            if (respuesta.monumentos.length>0){
                //Creo el elemento "padre"
                nuevoGrupo=document.createElement('li');
                nuevoGrupo.classList.add('dropdown');
                nuevoGrupo.innerHTML='<a href="#"><span>Monumentos</span><i class="bi bi-chevron-right"></i></a><ul></ul>';
                //Añado los elementos, pertenecientes a la categoría
                listaElementos=nuevoGrupo.lastElementChild;
                for (let i=0;i<respuesta.monumentos.length;i++){
                    listaElementos.innerHTML=listaElementos.innerHTML+'<li><a href="./ptoInteres.html?id='+id+'&cod='+respuesta.monumentos[i].codigo+'">'+respuesta.monumentos[i].nombre+'</a></li>';
                }
                queVer.lastElementChild.appendChild(nuevoGrupo);
            }
            if (respuesta.barrios.length>0){
                //Creo el elemento "padre"
                nuevoGrupo=document.createElement('li');
                nuevoGrupo.classList.add('dropdown');
                nuevoGrupo.innerHTML='<a href="#"><span>Barrios</span><i class="bi bi-chevron-right"></i></a><ul></ul>';
                //Añado los elementos, pertenecientes a la categoría
                listaElementos=nuevoGrupo.lastElementChild;
                for (let i=0;i<respuesta.barrios.length;i++){
                    listaElementos.innerHTML=listaElementos.innerHTML+'<li><a href="./ptoInteres.html?id='+id+'&cod='+respuesta.barrios[i].codigo+'">'+respuesta.barrios[i].nombre+'</a></li>';
                }
                queVer.lastElementChild.appendChild(nuevoGrupo);
            }
           
            if (respuesta.iglesias.length>0){
                //Creo el elemento "padre"
                nuevoGrupo=document.createElement('li');
                nuevoGrupo.classList.add('dropdown');
                nuevoGrupo.innerHTML='<a href="#"><span>Iglesias</span><i class="bi bi-chevron-right"></i></a><ul></ul>';
                //Añado los elementos, pertenecientes a la categoría
                listaElementos=nuevoGrupo.lastElementChild;
                for (let i=0;i<respuesta.iglesias.length;i++){
                    listaElementos.innerHTML=listaElementos.innerHTML+'<li><a href="./ptoInteres.html?id='+id+'&cod='+respuesta.iglesias[i].codigo+'">'+respuesta.iglesias[i].nombre+'</a></li>';
                }
                queVer.lastElementChild.appendChild(nuevoGrupo);
            }

            if (respuesta.museos.length>0){
                //Creo el elemento "padre"
                nuevoGrupo=document.createElement('li');
                nuevoGrupo.classList.add('dropdown');
                nuevoGrupo.innerHTML='<a href="#"><span>Museos</span><i class="bi bi-chevron-right"></i></a><ul></ul>';
                //Añado los elementos, pertenecientes a la categoría
                listaElementos=nuevoGrupo.lastElementChild;
                for (let i=0;i<respuesta.museos.length;i++){
                    listaElementos.innerHTML=listaElementos.innerHTML+'<li><a href="./ptoInteres.html?id='+id+'&cod='+respuesta.museos[i].codigo+'">'+respuesta.museos[i].nombre+'</a></li>';
                }
                queVer.lastElementChild.appendChild(nuevoGrupo);
            }

            if (respuesta.vCercanas.length>0){
                //Creo el elemento "padre"
                nuevoGrupo=document.createElement('li');
                nuevoGrupo.classList.add('dropdown');
                nuevoGrupo.innerHTML='<a href="#"><span>Visitas cercanas</span><i class="bi bi-chevron-right"></i></a><ul></ul>';
                //Añado los elementos, pertenecientes a la categoría
                listaElementos=nuevoGrupo.lastElementChild;
                for (let i=0;i<respuesta.vCercanas.length;i++){
                    listaElementos.innerHTML=listaElementos.innerHTML+'<li><a href="./ptoInteres.html?id='+id+'&cod='+respuesta.vCercanas[i].codigo+'">'+respuesta.vCercanas[i].nombre+'</a></li>';
                }
                queVer.lastElementChild.appendChild(nuevoGrupo);
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
        let id=parseInt(valorVariable('id'));//Llamo a la funcion que saca el valor del ID de la URL
        rellenarDesplegable2(id);//Se crea el desplegable Que ver (en función del id de la ciudad)
        comprobarAdmin();
    })
})