<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

//Cuando se introduce un email en el apartado Recuperar contraseña, primero se comprueba que el email está en la BBD
$usuario=$_POST['usuario'];
$script="SELECT * FROM USUARIOS WHERE EMAIL='".$usuario."'";
$resultado=mysqli_query($c,$script);
if (mysqli_num_rows($resultado)!=0){//El usuario existe
    //Se envía un email a la dirección de correo electrónico, con un enlace de recuperación
    $mensaje='Para cambiar tu clave, haz clic en el siguiente enlace:<br>';
    $mensaje=$mensaje.'<a href="www.google.es">Enlace</a>';
    $cabecera  = 'MIME-Version: 1.0' . "\r\n";
    $cabecera .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $cabecera.="From: labrujula.correo@gmail.com";
    mail("anaisa.villaperi@gmail.com","Cambio de clave",$mensaje,$cabecera);
}else{
    echo json_encode(array('codigo' => '2','mensaje' => 'No hay ninguna cuenta asociada a este email'));
}
?>