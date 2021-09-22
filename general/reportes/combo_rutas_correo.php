<?php
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/utilidades.class.php");
require("../../../sesion.php");

switch(@$_POST["acc"])
{
 case 1:
$accion="onchange=document.getElementById('ruta_desde_correo').value=document.getElementById('nombre_ruta_desde_correo').options[document.getElementById('nombre_ruta_desde_correo').selectedIndex].value;"; 
 break;	
 
 case 2:
$accion="onchange=document.getElementById('ruta_hasta_correo').value=document.getElementById('nombre_ruta_hasta_correo').options[document.getElementById('nombre_ruta_hasta_correo').selectedIndex].value;"; 
 break;
 
}

$objUtilidades=new utilidades;
$objUtilidades->seleccionarCombo("select codrut, substr(desrut,0,50) from pardefrut where codcic='".@$_POST["oficina"]."'  order by codrut",@$_POST["nombre_combo"],$accion,'',$readonly='',$retornar=0);
?>