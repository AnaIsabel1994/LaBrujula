<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

session_start();

//Página donde se realiza el registro del usuario
$email=$_POST['email'];
$motivo=$_POST['motivo'];
$mensaje=$_POST['mensaje'];

$titulo='Tipo de mensaje: '.$motivo;

$contenido='Remitente: '.$email.'<br><br>';
$contenido=$contenido.'Mensaje: <br>'.$mensaje.'<br>';

$cabecera  = 'MIME-Version: 1.0' . "\r\n";
$cabecera .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$cabecera.="From: labrujula.correo@gmail.com";
$aceptado=mail('labrujula.correo@gmail.com',$titulo,$contenido,$cabecera);
if ($aceptado){
    echo json_encode(array('codigo' => '1', 'mensaje' => 'El mensaje ha sido enviado con éxito'));
}else{
    echo json_encode(array('codigo' => '2', 'mensaje' => 'Se ha producido un error al enviar el mensaje'));
} 
?>