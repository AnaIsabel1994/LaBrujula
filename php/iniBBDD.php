<?php
ini_set('error_reporting',E_ALL & ~E_NOTICE &~E_DEPRECATED &~E_WARNING);

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

//Por si ya existiesen las tablas, realizo DROP de todas
mysqli_query($c,"DROP TABLE FAVORITOS");
mysqli_query($c,"DROP TABLE USUARIOS");
mysqli_query($c,"DROP TABLE USUARIOS_TEMP");
mysqli_query($c,"DROP TABLE PUNTOS_TURISTICOS");
mysqli_query($c,"DROP TABLE CIUDADES");
mysqli_query($c,"DROP TABLE PAISES");

//Creo las tablas
//Tabla USUARIOS
$script="CREATE TABLE USUARIOS (
    ID_USUARIO INT AUTO_INCREMENT,
    EMAIL VARCHAR(50) NOT NULL UNIQUE,
    FECHA_NAC DATE,
    CLAVE VARCHAR(100) NOT NULL,
    PRIMARY KEY (ID_USUARIO)
)";
mysqli_query($c,$script);

//Inserto al usuario administrador
$clave="ana";
$password=password_hash($clave, PASSWORD_DEFAULT);
$script="INSERT INTO USUARIOS (EMAIL,FECHA_NAC,CLAVE) VALUES ('anaisa.villaperi@gmail.com','1994-09-27','".$password."')";
mysqli_query($c,$script);

//Tabla USUARIOS_TEMP
$script="CREATE TABLE USUARIOS_TEMP (
    ID_REG INT AUTO_INCREMENT,
    EMAIL VARCHAR(50) NOT NULL UNIQUE,
    FECHA_NAC DATE,
    CLAVE VARCHAR(100) NOT NULL,
    PRIMARY KEY (ID_REG)
)";
mysqli_query($c,$script);

//Tabla PAÍSES
$script="CREATE TABLE PAISES(
    ID_PAIS INT AUTO_INCREMENT,
    NOMBRE VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (ID_PAIS)
)";
mysqli_query($c,$script);

//Tabla CIUDADES
$script="CREATE TABLE CIUDADES(
    ID_CIUDAD INT AUTO_INCREMENT,
    NOMBRE VARCHAR(50) NOT NULL,
    FORMATO_FOTO VARCHAR(5) NOT NULL,
    ID_PAIS INT NOT NULL,
    DEST_SUGERIDO ENUM('SI','NO') DEFAULT 'NO',
    PRIMARY KEY (ID_CIUDAD),
    FOREIGN KEY (ID_PAIS) REFERENCES PAISES (ID_PAIS) ON DELETE CASCADE
)";
mysqli_query($c,$script);


//Tabla PUNTOS_TURISTICOS
$script="CREATE TABLE PUNTOS_TURISTICOS(
    ID_PTO INT AUTO_INCREMENT,
    NOMBRE VARCHAR(100) NOT NULL,
    TIPO ENUM('MONUMENTO','BARRIO','IGLESIA','MUSEO','V_CERCANAS') NOT NULL,
    FORMATO_IMAGEN VARCHAR(5) NOT NULL,
    ID_CIUDAD INT NOT NULL,
    PRIMARY KEY (ID_PTO),
    FOREIGN KEY (ID_CIUDAD) REFERENCES CIUDADES (ID_CIUDAD) ON DELETE CASCADE
)";
mysqli_query($c,$script);

//Tabla FAVORITOS
$script="CREATE TABLE FAVORITOS(
    ID_USUARIO INT NOT NULL,
    ID_PTO INT NOT NULL,
    PRIMARY KEY (ID_USUARIO, ID_PTO),
    FOREIGN KEY (ID_USUARIO) REFERENCES USUARIOS (ID_USUARIO) ON DELETE CASCADE,
    FOREIGN KEY (ID_PTO) REFERENCES PUNTOS_TURISTICOS (ID_PTO) ON DELETE CASCADE
)";
mysqli_query($c,$script);

?>