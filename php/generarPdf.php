<?php

include "./fpdf/fpdf.php";//Incluimos la clase
//define('FPDF_FONTPATH',"../fpdf/makefont/");//Ruta de las fuentes que se van a utilizar
	
include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

session_start();

date_default_timezone_set('Europe/Madrid');
setlocale(LC_TIME, "spanish");


class extfpdf extends FPDF
{
    function Header(){
        $this->Image('../img/LOGO.png',5,5,30);//Logo de la web
        $this->SetFont('Arial','B',18);//Fuente
        // Move to the right
        //$this->Cell(80);
        $this->Setxy(40,17);//Posición del cursor
        $this->MultiCell(70, 5, utf8_decode("La Brujula"),0,'L',false);
        // Title
        //$this->Cell(30,10,'La Brujula',1,0,'C');
        // Line break
        $this->Ln(20);
        
    }
}

//Creo el PDF
//$pdf1 = new extfpdf("P",'mm','A4');
$pdf1 = new extfpdf("P",'mm','A4');

$pdf1->setdisplaymode('fullpage',"single");//Modo de representación de la página
$pdf1->setmargins(20,20);//Margenes laterales y superior
$pdf1->setautopagebreak(true,15);//Salto de página y margen inferior


//Saco la información del texto que se va a añadir
$script="SELECT C.NOMBRE, P.NOMBRE, F.ID_PTO, C.ID_CIUDAD
FROM FAVORITOS F JOIN PUNTOS_TURISTICOS T ON F.ID_PTO=T.ID_PTO
JOIN CIUDADES C ON C.ID_CIUDAD=T.ID_CIUDAD
JOIN PAISES P ON P.ID_PAIS=C.ID_PAIS
WHERE F.ID_USUARIO=(SELECT ID_USUARIO FROM USUARIOS WHERE EMAIL='".$_SESSION['usuario']."') AND C.ID_CIUDAD='".$_GET['id']."'";

$resultado=mysqli_query($c,$script); 
for ($i=0;$i<mysqli_num_rows($resultado);$i++){
    $fila=mysqli_fetch_row($resultado);
    $ruta="../archivos/".$fila[3]."/".$fila[2]."/";
    
    //Busco los archivos de los que quiero leer información
    $archivo1=$ruta."info1.txt";
    $f1=fopen($archivo1,"r");//Abrimos el fichero del que vamos a copiar la información
    $texto=fread($f1,filesize($archivo1));//Leemos su contenido
    //echo $texto;
    
    $pdf1->addpage();//Añadimos página, necesario, ya que vamos a incluir contenidos
    $ciudad=$fila[0];
    $pais="(".$fila[1].")";
    $pdf1->SetTextColor(233,152,81);
    $pdf1->SetFont("courier","B", 25);
    $pdf1->Sety(40);
    $pdf1->MultiCell(0,5,utf8_decode($ciudad),0,"C",false);//Nombre de la ciudad
    $pdf1->Ln(4);
    
    $pdf1->SetFont("courier","B", 20);
    $pdf1->MultiCell(0,5,utf8_decode($pais),0,"C",false);//Nombre del país
    $pdf1->Ln(10);
    
    $contador=0;
    
    while($contador!=-1){
        $indice=strpos($texto, "<");
        $impresion="";
        if ($indice === false) {
            $contador=-1;
        } else {
            $indice1=strpos($texto, "<");
            $letra=substr($texto, $indice1+1, 1);
            $impresion="";
            $nuevoTexto="";
            $indice2=0;
            //Saco el texto que se va a imprimir, y modifico el texto general
            if ($letra=='h'){
                $pdf1->SetTextColor(233,152,81);
                $pdf1->SetFont("courier","B", 12);
                $indice2=strpos($texto, "</");
                $impresion=substr($texto, $indice1+4, $indice2-7);
                $nuevoTexto=substr($texto, $indice2+4);
            }else if($letra=='p'){
                $pdf1->SetTextColor(0,0,0);
                $pdf1->SetFont("courier","", 12);
                $indice2=strpos($texto, "</");
                $impresion=substr($texto, $indice1+3, $indice2-6);
                $nuevoTexto=substr($texto, $indice2+4);
            }
            $pdf1->MultiCell(0,5,utf8_decode($impresion),0,"L",false);//Texto
            $texto=$nuevoTexto;
            $contador++;
        }
    }
    fclose($f1);
}
$pdf1->Output();
$pdf1->close;
?>