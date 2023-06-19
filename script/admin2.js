window.addEventListener("DOMContentLoaded",()=>{
    /* Identificadores */
    let cerrarSesion=document.getElementById("cerrarSesion"); 
    let volverAdmin=document.getElementById("volverAdmin");     
    let divAgregarPais=document.getElementById("divAgregarPais");
    let divEliminarPais=document.getElementById("divEliminarPais");
    let divAgregarCiudad=document.getElementById("divAgregarCiudad");
    let divEliminarCiudad=document.getElementById("divEliminarCiudad");
    let divModificarCiudad=document.getElementById("divModificarCiudad");
    let divSelFavoritos=document.getElementById("divSelFavoritos");
    let divAgregarPto=document.getElementById("divAgregarPto");
    let divEliminarPto=document.getElementById("divEliminarPto");
    let divModificarPto=document.getElementById("divModificarPto");
    let divGestUsuarios=document.getElementById("divGestUsuarios");
    let mensajesError=document.getElementById("mensajesError");

    
    //Funcion que verifica que existe la variable de sesión de administrador
    async function comprobarAdmin(){
        let response=await fetch("https://weblabrujula.es/php/comprobarAdmin.php");
        let respuesta=await response.json();//Información extraida, en formato JSON
        if (respuesta.codigo==2){//No hay sesión de usuario activa
            location.href="./index.html";
        }
    }
    async function agregarPais(formulario){//Añade un nuevo país
        let response=await fetch("https://weblabrujula.es/php/agregarPais.php", {
            method: "post",
            body: formulario
       });
        let respuesta=await response.json();//Información extraida, en formato JSON
        if(respuesta.codigo!=1){
            mensajesError.innerHTML=mensajesError.innerHTML+respuesta.mensaje;
            window.scrollTo(0,0);
        }else{
            location.href="./admin.html";
        }
    }
    
    async function paisesSelect(opcion){//Rellena el select con los países disponibles
        if (opcion==1){//Modif/Borrar paises
            try{ 
                let inputSelect=document.getElementById("nombreBorrarPais");
                let response=await fetch("https://weblabrujula.es/php/listarPaises.php");
                let respuesta=await response.json();//Información extraida, en formato JSON
                for (let i=0;i<respuesta.length;i++){
                    let opcion=document.createElement("option");
                    opcion.value=respuesta[i].id;
                    opcion.textContent=respuesta[i].nombre;
                    inputSelect.appendChild(opcion);
                }                
                return true;
            }catch(error){
                console.log("Error: "+error);
            }
        }else{//Añadir ciudad
            try{ 
                let inputSelect=document.getElementById("paisNuevaCiudad");
                let response=await fetch("https://weblabrujula.es/php/listarPaises.php");
                let respuesta=await response.json();//Información extraida, en formato JSON
                for (let i=0;i<respuesta.length;i++){
                    let opcion=document.createElement("option");
                    opcion.value=respuesta[i].id;
                    opcion.textContent=respuesta[i].nombre;
                    inputSelect.appendChild(opcion);
                }                
                return true;
            }catch(error){
                console.log("Error: "+error);
            }
        }
        
    }
    async function usuariosSelect(){
        try{ 
                let inputSelect=document.getElementById("idSelUsuario");
                let response=await fetch("https://weblabrujula.es/php/listarUsuarios.php");
                let respuesta=await response.json();//Información extraida, en formato JSON
                for (let i=0;i<respuesta.length;i++){
                    let opcion=document.createElement("option");
                    opcion.value=respuesta[i].id;
                    opcion.textContent=respuesta[i].email;
                    inputSelect.appendChild(opcion);
                }                
                return true;
            }catch(error){
                console.log("Error: "+error);
            }
    }
    async function ciudadesSelect(opcion){
        if (opcion==1){//Nuevo punto turistico
            try{ 
                let inputSelect=document.getElementById("ciudadNuevoPto");
                let response=await fetch("https://weblabrujula.es/php/listarCiudades2.php");
                let respuesta=await response.json();//Información extraida, en formato JSON
                for (let i=0;i<respuesta.length;i++){
                    let opcion=document.createElement("option");
                    opcion.value=respuesta[i].idCiudad;
                    opcion.textContent=respuesta[i].nombreCiudad+" ("+respuesta[i].nombrePais+")";
                    inputSelect.appendChild(opcion);
                }                
                return true;
            }catch(error){
                console.log("Error: "+error);
            }
        }else{//Eliminar ciudad
            try{ 
                let inputSelect=document.getElementById("nombreSelCiudad");
                let response=await fetch("https://weblabrujula.es/php/listarCiudades2.php");
                let respuesta=await response.json();//Información extraida, en formato JSON
                for (let i=0;i<respuesta.length;i++){
                    let opcion=document.createElement("option");
                    opcion.value=respuesta[i].idCiudad;
                    opcion.textContent=respuesta[i].nombreCiudad+" ("+respuesta[i].nombrePais+")";
                    inputSelect.appendChild(opcion);
                }                
                return true;
            }catch(error){
                console.log("Error: "+error);
            }
        }
    }
    async function ptosSelect(){
        try{ 
                let inputSelect=document.getElementById("nombreSelPto");
                let response=await fetch("https://weblabrujula.es/php/listarPtosInteres2.php");
                let respuesta=await response.json();//Información extraida, en formato JSON
                for (let i=0;i<respuesta.length;i++){
                    let opcion=document.createElement("option");
                    opcion.value=respuesta[i].idPto;
                    opcion.textContent=respuesta[i].nombrePto+" ("+respuesta[i].nombreCiudad+", "+respuesta[i].nombrePais+")";
                    inputSelect.appendChild(opcion);
                }                
                return true;
            }catch(error){
                console.log("Error: "+error);
            }
    }
    async function eliminarPais(idPais){
        let response=await fetch("https://weblabrujula.es/php/eliminarPais.php?idPais="+idPais);
        let respuesta=await response.json();//Información extraida, en formato JSON
        if(respuesta.codigo!=1){
            mensajesError.innerHTML=mensajesError.innerHTML+respuesta.mensaje;
            window.scrollTo(0,0);
        }else{
            location.href="./admin.html";
        }
    }
    async function eliminarCiudad(idCiudad){
        let response=await fetch("https://weblabrujula.es/php/eliminarCiudad.php?idCiudad="+idCiudad);
        let respuesta=await response.json();//Información extraida, en formato JSON
        if(respuesta.codigo!=1){
            mensajesError.innerHTML=mensajesError.innerHTML+"<p>"+respuesta.mensaje+"</p>";
            window.scrollTo(0,0);
        }else{
            location.href="./admin.html";
        }
    }
    async function eliminarPto(idPto){
        let response=await fetch("https://weblabrujula.es/php/eliminarPto.php?pId="+idPto);
       let respuesta=await response.json();//Información extraida, en formato JSON
        if(respuesta.codigo!=1){
            mensajesError.innerHTML=mensajesError.innerHTML+respuesta.mensaje;
            window.scrollTo(0,0);
        }else{
            location.href="./admin.html";
        }
    }
    async function eliminarUsuario(idUsuario){
        let response=await fetch("https://weblabrujula.es/php/eliminarUsuario.php?uId="+idUsuario);
       let respuesta=await response.json();//Información extraida, en formato JSON
        if(respuesta.codigo!=1){
            mensajesError.innerHTML=mensajesError.innerHTML+respuesta.mensaje;
            window.scrollTo(0,0);
        }else{
            location.href="./admin.html";
        }
    }
    async function verCiudades(){
        try{ 
                let listado=document.getElementById("tablaCiudades");
                let response=await fetch("https://weblabrujula.es/php/listarDestinos.php");
                let respuesta=await response.json();//Información extraida, en formato JSON
                for (let i=0;i<respuesta.length;i++){
                    let fila=document.createElement("tr");
                    fila.innerHTML="<td class='pa-3'>"+respuesta[i].nombre+"</td><td class='pa-3'>"+respuesta[i].pais+"</td><td class='pa-3'><input type='checkbox' id='"+respuesta[i].id+"' value=''></td>";
                    if (respuesta[i].sugerido=='SI'){
                        fila.lastChild.lastChild.checked=true;
                    }
                    
                    listado.appendChild(fila);
                }                
                return true;
            }catch(error){
                console.log("Error: "+error);
            }
    }
    async function actualizarRecomendados(){
        //Compruebo que no haya marcados más de tres ciudades
        let ciudadesAux=document.getElementById("tablaCiudades").children;
        let contador=0;
        let listaMarcados=[];
        for (let i=0;i<ciudadesAux.length;i++){
            let marcado=ciudadesAux[i].lastChild.lastChild;
            if (marcado.checked){
                contador=contador+1;
                listaMarcados.push(marcado.id);
            }
        }
        if (contador>3){
            mensajesError.innerHTML="No puedes marcar mas de 3 ciudades";
            window.scrollTo(0,0);
        }else{
            let param="";
            if (contador>0){
                param="?dest1="+listaMarcados[0];
                if (contador>1){
                    param=param+"&dest2="+listaMarcados[1];
                    if (contador>2){
                        param=param+"&dest3="+listaMarcados[2];
                    }
                }
            }
            let response=await fetch("https://weblabrujula.es/php/cambiarSugerencias.php"+param);
            let respuesta=await response.json();//Información extraida, en formato JSON
            if(respuesta.codigo==1){
                location.href="./admin.html";
            }
        }
    }
    


    window.addEventListener("load",()=>{
        comprobarAdmin();
        let id='0';
        id=valorVariable('cod');//Llamo a la funcion que saca el valor del ID de la URL
        let formulario;
        switch (id){
            case 'p1':
                divAgregarPais.style.display="block";
                formulario=document.getElementById("formNuevoPais");
                formulario.addEventListener("submit",(ev)=>{
                    mensajesError.innerHTML="";
                    ev.preventDefault();
                    let datosFormulario=new FormData(ev.target);
                    if (datosFormulario.get('nombreNuevoPais')!=""){
                        agregarPais(datosFormulario);
                    }else{
                        mensajesError.innerHTML+="<p>Introduce un nombre</p>";
                        window.scrollTo(0,0);
                    }
                })
                break;
            case 'p2':
                paisesSelect(1).then((pr)=>{//Cuando se termine de rellenar el select
                    divEliminarPais.style.display="block";
                    document.getElementById("formEliminarPais").addEventListener("submit",(ev)=>{
                        ev.preventDefault();
                        let idPais=document.getElementById("nombreBorrarPais");
                        eliminarPais(idPais.value);
                    })
                }).catch((error)=>{
                    console.log(error.message);
                });
                break;
            case 'c1':
                divAgregarCiudad.style.display="block";
                paisesSelect(2).then((pr)=>{//Cuando se termine de rellenar el select
                    formulario=document.getElementById("formNuevaCiudad");
                    formulario.addEventListener("submit",(ev)=>{
                        mensajesError.innerHTML="";
                        centinela=true;
                        if (document.getElementById('nombreNuevaCiudad').value==""){
                            mensajesError.innerHTML+="<p>Introduce un nombre</p>";
                            centinela=false;
                        }
                        if (document.getElementById('imagenNuevaCiudad').value=="" || !validarImagen(document.getElementById('imagenNuevaCiudad').value)){
                            mensajesError.innerHTML+="<p>El formato de imagen no es válido; debe ser .jpg o .png</p>";
                            centinela=false;
                        }
                        if (document.getElementById('descNuevaCiudad').value=="" || !validarTexto()){
                            mensajesError.innerHTML+="<p>El formato del archivo de descripcion general no es válido (debe ser .txt)</p>";
                            centinela=false;
                        }
                        if (document.getElementById('docuNuevaCiudad').value=="" || !validarTexto()){
                            mensajesError.innerHTML+="<p>El formato del archivo de documentación no es válido (debe ser .txt)</p>";
                            centinela=false;
                        }
                        if (document.getElementById('festNuevaCiudad').value=="" || !validarTexto()){
                            mensajesError.innerHTML+="<p>El formato del archivo de festivos no es válido (debe ser .txt)</p>";
                            centinela=false;
                        }
                        if (document.getElementById('horaNuevaCiudad').value=="" || !validarTexto()){
                            mensajesError.innerHTML+="<p>El formato del archivo de horarios no es válido (debe ser .txt)</p>";
                            centinela=false;
                        }
                        if (document.getElementById('llegNuevaCiudad').value=="" || !validarTexto()){
                            mensajesError.innerHTML+="<p>El formato del archivo de como llegar no es válido (debe ser .txt)</p>";
                            centinela=false;
                        }
                        if (document.getElementById('preciosNuevaCiudad').value=="" || !validarTexto()){
                            mensajesError.innerHTML+="<p>El formato del archivo de precios no es válido (debe ser .txt)</p>";
                            centinela=false;
                        }
                        if (document.getElementById('tiempoNuevaCiudad').value=="" || !validarTexto()){
                            mensajesError.innerHTML+="<p>El formato del archivo de tiempo no es válido (debe ser .txt)</p>";
                            centinela=false;
                        }
                        if (document.getElementById('transpNuevaCiudad').value=="" || !validarTexto()){
                            mensajesError.innerHTML+="<p>El formato del archivo de como moverse/transporte no es válido (debe ser .txt)</p>";
                            centinela=false;
                        }
                        if (!centinela){
                            ev.preventDefault();
                            window.scrollTo(0,0);
                        }
                    })
                }).catch((error)=>{
                    console.log(error.message);
                });
                break;
            case 'c2':
                divEliminarCiudad.style.display="block";
                ciudadesSelect(2).then((pr)=>{//Cuando se termine de rellenar el select
                    document.getElementById("formEliminarCiudad").addEventListener("submit",(ev)=>{
                        ev.preventDefault();
                        let idCiudad=document.getElementById("nombreSelCiudad");
                        eliminarCiudad(idCiudad.value);
                    })
                    document.getElementById("btnSelCiudad").addEventListener("click",(ev)=>{
                        document.getElementById("idModifCiudad").value=document.getElementById("nombreSelCiudad").value;
                        divModificarCiudad.style.display="block";//Hago visible el formulario de modificar datos
                        let btnModifCiudad=document.getElementById("btnModifCiudad");
                        //btnModifCiudad.disabled=true;
                        document.getElementById("formModifCiudad").addEventListener("submit",()=>{
                            if (document.getElementById('imagenModifCiudad').value!="" && !validarImagen(document.getElementById('imagenModifCiudad').value)){
                                mensajesError.innerHTML+="<p>El formato de la imagen no es válido (.png/.jpeg)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('descModifCiudad').value!="" && !validarTexto(document.getElementById('descModifCiudad').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo de Informacion general no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('docuModifCiudad').value!="" && !validarTexto(document.getElementById('docuModifCiudad').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo de Documentacion no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('festModifCiudad').value!="" && !validarTexto(document.getElementById('festModifCiudad').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo de Festivos no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('horaModifCiudad').value!="" && !validarTexto(document.getElementById('horaModifCiudad').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo Horario comercial no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('llegModifCiudad').value!="" && !validarTexto(document.getElementById('llegModifCiudad').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo Como llegar no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('preciosModifCiudad').value!="" && !validarTexto(document.getElementById('preciosModifCiudad').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo Precios no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('tiempoModifCiudad').value!="" && !validarTexto(document.getElementById('tiempoModifCiudad').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo Tiempo no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('transpModifCiudad').value!="" && !validarTexto(document.getElementById('transpModifCiudad').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo Transporte no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (!centinela){
                                ev.preventDefault();
                                window.scrollTo(0,0);
                            }
                        })
                    })
                }).catch((error)=>{
                    console.log(error.message);
                });
                break;
            case 'c3':
                verCiudades().then((pr)=>{//Cuando se termine de rellenar la tabla
                    divSelFavoritos.style.display="block";
                    document.getElementById("btnActualizar").addEventListener("click",(ev)=>{
                        mensajesError.innerHTML="";
                        actualizarRecomendados();
                    })
                }).catch((error)=>{
                    console.log(error.message);
                });
                break;
            case 'pi1':
                divAgregarPto.style.display="block";
                ciudadesSelect(1).then((pr)=>{//Cuando se termine de rellenar el select
                    formulario=document.getElementById("formNuevoPto");
                    formulario.addEventListener("submit",(ev)=>{
                        mensajesError.innerHTML="";
                        centinela=true;
                        if (document.getElementById('nombreNuevoPto').value==""){
                            mensajesError.innerHTML+="<p>Introduce un nombre</p>";
                            centinela=false;
                        }
                        if (document.getElementById("tipoNuevoPto").value=="" || document.getElementById("tipoNuevoPto").value=="0"){
                            mensajesError.innerHTML+="<p>Tienes que seleccionar un tipo</p>";
                            centinela=false;
                        }
                        if (document.getElementById('imagenNuevoPto').value==""){
                            mensajesError.innerHTML+="<p>El formato de la imagen no es válido (.png/.jpeg)</p>";
                            centinela=false;
                        }
                        if (document.getElementById('infoNuevoPto').value==""){
                            mensajesError.innerHTML+="<p>El formato del archivo Información general no es válido (debe ser .txt)</p>";
                            centinela=false;
                        }
                        if (!centinela){
                            ev.preventDefault();
                            window.scrollTo(0,0);
                        }
                    });
                }).catch((error)=>{
                    console.log(error.message);
                });
                break;
            case 'pi2':
                divEliminarPto.style.display="block";
                ptosSelect().then((pr)=>{//Cuando se termine de rellenar el select
                    document.getElementById("formEliminarPto").addEventListener("submit",(ev)=>{
                        ev.preventDefault();
                        let idPto=document.getElementById("nombreSelPto");
                        eliminarPto(idPto.value);
                    })
                    document.getElementById("btnSelPto").addEventListener("click",(ev)=>{
                        document.getElementById("idModifPto").value=document.getElementById("nombreSelPto").value;
                        divModificarPto.style.display="block";//Hago visible el formulario de modificar datos
                        document.getElementById("formModifPto").addEventListener("submit",()=>{
                            if (document.getElementById('imagenModifPto').value!="" && !validarImagen(document.getElementById('imagenModifPto').value)){
                                mensajesError.innerHTML+="<p>El formato de la imagen no es válido (.png/.jpeg)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('infoModifPto').value!="" && !validarTexto(document.getElementById('infoModifPto').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo de Informacion general no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('info2ModifPto').value!="" && !validarTexto(document.getElementById('info2ModifPto').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo de Horarios/Precios no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (document.getElementById('info3ModifPto').value!="" && !validarTexto(document.getElementById('info3ModifPto').value)){
                                mensajesError.innerHTML+="<p>El formato del archivo de Datos curiosos no es válido (.txt)</p>";
                                centinela=false;
                            }
                            if (!centinela){
                                ev.preventDefault();
                                window.scrollTo(0,0);
                            }
                        })
                    })
                }).catch((error)=>{
                    console.log(error.message);
                });
                break;
            case 'a':
                usuariosSelect().then((pr)=>{//Cuando se termine de rellenar el select
                    divGestUsuarios.style.display="block";
                    document.getElementById("formEliminarUsuario").addEventListener("submit",(ev)=>{
                        ev.preventDefault();
                        let idPais=document.getElementById("idSelUsuario");
                        eliminarUsuario(idPais.value);
                    })
                }).catch((error)=>{
                    console.log(error.message);
                });
                break;
            default:
                location.href="./admin.html";
        }
        cerrarSesion.addEventListener("click",()=>{
            location.href="./php/cerrarSesion.php";
        })
        volverAdmin.addEventListener("click",()=>{
            location.href="./admin.html";
        })
        
        
    })
})