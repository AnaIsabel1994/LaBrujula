<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

//Página donde se realiza el registro del usuario
$usuario=$_POST['email'];
$clave=$_POST['clave'];

$script="SELECT * FROM USUARIOS WHERE EMAIL='".$usuario."'";

//Consulto la base de datos buscando el usuario
$resultado=mysqli_query($c,$script);
//Si el usuario no existe
if (mysqli_num_rows($resultado)==0){
    //Compruebo que no esté pendiente de validar su registro
    $script="SELECT * FROM USUARIOS_TEMP WHERE EMAIL='".$usuario."'";
    $resultado=mysqli_query($c,$script);
    if (mysqli_num_rows($resultado)!=0){
        echo json_encode(array('codigo' => '2', 'mensaje' => 'El registro está pendiente de verificar; compueba tu correo electrónico'));
    }else{
        //Añado los datos a la tabla USUARIOS_TEMP
        if (isset($_POST['fNac'])){
            $script="INSERT INTO USUARIOS_TEMP (EMAIL,FECHA_NAC,CLAVE) VALUES ('".$usuario."','".$_POST['fNac']."','".password_hash($clave, PASSWORD_DEFAULT)."')";
            mysqli_query($c,$script);//Inserto el registro en la tabla temporal de usuarios
        }else{
            $script="INSERT INTO USUARIOS_TEMP (EMAIL,CLAVE) VALUES ('".$usuario."','".password_hash($clave, PASSWORD_DEFAULT)."')";
            mysqli_query($c,$script);//Inserto el registro en la tabla temporal de usuarios
        }
        //Extraigo el id de la tabla USUARIOS_TEMP
        $script="SELECT * FROM USUARIOS_TEMP WHERE EMAIL='".$usuario."'";
        $resultado=mysqli_query($c,$script);
        $fila=mysqli_fetch_row ($resultado);//Datos de la consulta
        $mensaje='Para completar tu registro en la web, haz clic en el siguiente enlace:<br>';
        $mensaje=$mensaje.'<a href="https://weblabrujula.es/php/finalizarRegistro.php?id='.$fila[0].'">Enlace</a>';
        $cabecera  = 'MIME-Version: 1.0' . "\r\n";
        $cabecera .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabecera.="From: labrujula.correo@gmail.com";
        $aceptado=mail($usuario,"Registro en La Brujula",$mensaje,$cabecera);
        if ($aceptado){
            echo json_encode(array('codigo' => '1', 'mensaje' => 'Se ha enviado un mail de confirmacion al correo indicado'));
        }else{//Si no se ha podido enviar el mail, borro el registro de la tabla temporal
            $script="DELETE FROM USUARIOS_TEMP WHERE ID_REG=".$id;
            mysqli_query($c,$script);
            echo json_encode(array('codigo' => '2', 'mensaje' => 'Se ha producido un error al enviar el correo de confirmación'));
        }  
    }
}else{//Si el usuario ya existe, devuelvo un mensaje de error
    echo json_encode(array('codigo' => '2', 'mensaje' => 'El email enviado ya pertenece a un usuario registrado.'));
}
?>