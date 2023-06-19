<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

//Página donde se realiza el primer paso del cambio de clave
$usuario=$_POST['email'];

$script="SELECT ID_USUARIO FROM USUARIOS WHERE EMAIL='".$usuario."' AND ID_USUARIO!=1";

//Consulto la base de datos buscando el usuario
$resultado=mysqli_query($c,$script);
//Si el usuario existe
if (mysqli_num_rows($resultado)!=0){
    $fila=mysqli_fetch_row($resultado);
    $mensaje="Se ha solicitado un cambio de clave en la web <a href='https://weblabrujula.es' alt='Enlace a la pagina principal de la web'>La Brujula</a>.<br>Para cambiarla, haz clic en el siguiente enlace: <br>";
    $mensaje=$mensaje.'<a href="https://weblabrujula.es/cambiarClave.html?id='.$fila[0].'" alt="Enlace para cambio de clave">Enlace</a><br>';
    $mensaje=$mensaje."Si no has sido tu, simplemente ignora este mensaje.";
    $cabecera  = 'MIME-Version: 1.0' . "\r\n";
    $cabecera .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $cabecera.="From: labrujula.correo@gmail.com";
    $aceptado=mail($usuario,"Solicitud cambio de clave en La Brujula",$mensaje,$cabecera);
    if ($aceptado){
        echo json_encode(array('codigo' => '1', 'mensaje' => 'Se ha enviado un mail al correo indicado, con las instrucciones para cambiar tu clave.'));
    }else{//Si no se ha podido enviar el mail, borro el registro de la tabla temporal
        $script="DELETE FROM USUARIOS_TEMP WHERE ID_REG=".$fila[0];
        mysqli_query($c,$script);
        echo json_encode(array('codigo' => '2', 'mensaje' => 'Se ha producido un error al enviar el correo con las instrucciones.'));
    }  
}else{//Si el usuario no está registrado
    //Compruebo si el registro está pendiente de validar
    $script="SELECT ID_REG FROM USUARIOS_TEMP WHERE EMAIL='".$usuario."'";
    $resultado=mysqli_query($c,$script);
    if (mysqli_num_rows($resultado)!=0){
        $fila=mysqli_fetch_row($resultado);
        $mensaje='Para completar tu registro en la web, haz clic en el siguiente enlace:<br>';
        $mensaje=$mensaje.'<a href="https://weblabrujula.es/php/finalizarRegistro.php?id='.$fila[0].'">Enlace</a>';
        $cabecera  = 'MIME-Version: 1.0' . "\r\n";
        $cabecera .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabecera.="From: labrujula.correo@gmail.com";
        $aceptado=mail($usuario,"Registro en La Brujula",$mensaje,$cabecera);
        if ($aceptado){
            echo json_encode(array('codigo' => '2', 'mensaje' => 'El registro aun esta pendiente de validar. Revisa tu correo.'));
        }else{//Si no se ha podido enviar el mail, borro el registro de la tabla temporal
            $script="DELETE FROM USUARIOS_TEMP WHERE ID_REG=".$fila[0];
            mysqli_query($c,$script);
            echo json_encode(array('codigo' => '2', 'mensaje' => 'La direccion de correo electronico no esta registrada'));
        }  
    }else{
        echo json_encode(array('codigo' => '2', 'mensaje' => 'La direccion de correo no esta registrada.'));   
    }
}
?>