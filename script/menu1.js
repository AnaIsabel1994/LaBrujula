window.addEventListener("DOMContentLoaded",()=>{
    let listaDestinos = document.getElementById('listaPaises');//Elemento padre del desplegable (primer UL)
    //Función que, dado como parametro el id de un pais, recibe una lista de las ciudades de ese país, guardadas en la base de datos
    async function incluirCiudades(id){
        let idPais='pais'+id;
        let pais=document.getElementById(idPais);
        let listaCiudades=document.createElement('ul');
        let nuevaCiudad;
        //Hago una llamada al servidor, que devlverá una lista de ciudades
        try{
            let response=await fetch("https://weblabrujula.es/php/listarCiudades.php?id="+id);
            let respuesta=await response.json();//Información extraida, en formato JSON
            
            if (respuesta.length>0){
                //Si hay ciudades, las añado al menú desplegable
                let flecha=document.createElement('i');
                flecha.classList.add('bi');
                flecha.classList.add('bi-chevron-right');
                pais.firstChild.appendChild(flecha);
                for (let i=0;i<respuesta.length;i++){
                    nuevaCiudad=document.createElement('li');
                    nuevaCiudad.innerHTML="<a href=./destino.html?id="+respuesta[i].id+">"+respuesta[i].nombre+"</a>";
                    listaCiudades.appendChild(nuevaCiudad);
                }
                pais.appendChild(listaCiudades);
            }else{
                //Si aun no hay ciudades de ese país, deshabilito el enlace
                pais.classList.add('disabled');

            }
        }catch(error){
            console.log("Error: "+error);
        }
    }
    
    //Función que asigna al carrusel los destinos marcados como sugeridos
    async function rellenarDesplegable(){
        let listaPaises;
        //Hago una llamada al servidor, que devlverá una lista de países
        try{
            let response=await fetch("https://weblabrujula.es/php/listarPaises.php");
            let respuesta=await response.json();//Información extraida, en formato JSON
            let nuevoPais;
            for (let i=0;i<respuesta.length;i++){
                nuevoPais=document.createElement('li');
                nuevoPais.classList.add("dropdown");
                nuevoPais.id='pais'+respuesta[i].id;
                nuevoPais.innerHTML="<a href='#'><span>"+respuesta[i].nombre+"</span></a>";
                listaDestinos.appendChild(nuevoPais);
                incluirCiudades(respuesta[i].id);
            }
        }catch(error){
            console.log("Error: "+error);
        }
    }

    //Función que comprueba si existe cookie de sesión (sin persistencia), correspondiente al usuario
    async function enlaceCuenta(){
        let response=await fetch("https://weblabrujula.es/php/comprobarUser.php");
        let respuesta=await response.json();//Información extraida, en formato JSON
        //Si existe, modificará el enlace del apartado Cuenta
        let enlace=document.getElementById("enlaceCuenta");
        if (respuesta.codigo==1){//Hay sesión de usuario activa
            enlace.href="./cuenta.html";
        }
    }
    window.addEventListener("load",()=>{
        rellenarDesplegable();//Se crea el desplegable Destinos
        enlaceCuenta();//Compruebo si hay que modificar el enlace Cuenta
    })
    let botonResponsivo=document.getElementsByClassName("mobile-nav-toggle")[0];
    let menuPrincipal=document.getElementsByClassName("menuPrincipal")[0];
    botonResponsivo.addEventListener("click",()=>{
        menuPrincipal.classList.toggle("navbar-mobile");
        let menuDestinos=menuPrincipal.firstElementChild.children[1];
        menuDestinos.firstElementChild.addEventListener("click",(ev)=>{
            menuDestinos.lastElementChild.classList.toggle("dropdown-active");
            let menuPaises=menuDestinos.lastElementChild.children;
            for (let i=0;i<menuPaises.length;i++){
                menuPaises[i].firstElementChild.addEventListener("click",(ev)=>{
                    menuPaises[i].lastElementChild.classList.toggle("dropdown-active");
                })
            }
        })
        
    })
})