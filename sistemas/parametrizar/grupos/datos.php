<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");


if (@$_REQUEST["opcion"]=="guardar")
{
	$sql="select grupo,descrip from grupos where grupo = '".@$_REQUEST["id_grupo"]."'";
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)==0)
	{
		$sql = "Insert into grupos (
					grupo,
					descrip,
					encargado,
					cargo) 
				values (
					'".@$_REQUEST["id_grupo"]."',
					'".@$_REQUEST["id_descripcion"]."',
					'".@$_REQUEST["encargado"]."',
					'".@$_REQUEST["cargo"]."')";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se inserto Correctamente el Grupo: ".@$_REQUEST["id_descripcion"]);
	}
	else
	{
		$sql = "update grupos set 
					descrip='".@$_REQUEST["id_descripcion"]."',
					encargado='".@$_REQUEST["encargado"]."',
					cargo='".@$_REQUEST["cargo"]."'					
				where 
					grupo='".@$_REQUEST["id_grupo"]."'";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se actualizo Correctamente el Grupo: ".@$_REQUEST["id_descripcion"]);
	}
}
?>
