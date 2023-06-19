<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');
include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

//Página donde se piden (y comprueban) las credenciales para acceder al Perfil
$usuario=$_POST['email'];
$clave=$_POST['clave'];

$script="SELECT * FROM USUARIOS WHERE EMAIL='".$usuario."'";

//Consulto la base de datos buscando el usuario
$resultado=mysqli_query($c,$script);
//Pueden darse 3 situaciones:
/*
-Usuario existe, y las claves coinciden (codigo:1)
-El usuario no existe (codigo:2, fallo:1)
-Usuario existe, pero no coincide la contraseña (codigo:2, fallo:2)
*/
if (mysqli_num_rows($resultado)!=0){//El usuario existe
    $fila=mysqli_fetch_row ($resultado);//Datos del usuario
    if (password_verify($clave,$fila[3])){
        if ($fila[0]==1){//El usuario es el administrador
            //Redirige a la página de Administración
            $_SESSION['tUsuario']='admin';//Tipo de usuario
            echo json_encode(array('codigo' => '1', 'tipo' => 'admin', 'varSesion'=>$_SESSION['tUsuario']));
        }else{
            //Redirige a la página de Usuario
            $_SESSION['tUsuario']='usuario';
            $_SESSION['usuario']=$fila[1];
            echo json_encode(array('codigo' => '1', 'tipo' => 'usuario', 'varSesion'=>$_SESSION['tUsuario']));
        }
    }else{
        echo json_encode(array('codigo' => '2', 'mensaje' => 'La clave es incorrecta'));
    }
}else{
    $script="SELECT * FROM USUARIOS_TEMP WHERE EMAIL='".$usuario."'";
    $resultado=mysqli_query($c,$script);
    if (mysqli_num_rows($resultado)!=0){//El usuario existe, pero la cuenta está pendiente de validar
        echo json_encode(array('codigo' => '2', 'mensaje' => 'El registro está pendiente de verificar; compueba tu correo electrónico. Si no encuentras el correo de verificacion, ve a He olvidado mi contraseña'));
    }else{
        echo json_encode(array('codigo' => '2', 'mensaje' => 'El usuario no existe'));
    }
}
?>