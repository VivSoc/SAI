<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");


if(@$_POST["grupo_actual"]=="N")
{
$sql="Insert into tomgru (grupo,codinttom) values ('".@$_REQUEST["id_asignar_grupo"]."','".@$_REQUEST["toma"]."')";
$result10=pg_query($bd_conexion,$sql);

cuadro_mensaje2("Se inserto Correctamente la cuenta ".@$_REQUEST["cuenta_grupo"]." en el Grupo: ".@$_REQUEST["descrip_grupo"]);
}else
{
$sql="update tomgru set grupo='".@$_REQUEST["id_asignar_grupo"]."' where codinttom='".@$_REQUEST["toma"]."'";

$result10=pg_query($bd_conexion,$sql);
cuadro_mensaje2("Se Modific&oacute; Correctamente la cuenta ".@$_REQUEST["cuenta_grupo"].", se cambi&oacute; para en el Grupo: ".@$_REQUEST["descrip_grupo"]);	
}

?>
