<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
    </head>
<?php
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");

$sql = "UPDATE 
			pardefusu
		SET 
   			pas_syn='".@$_REQUEST['scc_clave1']."'
		WHERE 
 			codintusu='".$_SESSION['codintusu']."'";

$result = pg_query($bd_conexion,$sql);
if (pg_affected_rows($result)>0) 
{
	//$_SESSION["clave"]=md5(@$_REQUEST['scc_clave1']);
	echo "<SCRIPT LANGUAGE='javascript'>swal('La clave se actualizó','correctamente', 'success');</script>"; 
}		
else
{
	echo "<SCRIPT LANGUAGE='javascript'>swal('Error al actualizar la clave','Por favor verifique', 'error');</script>";
}

?>
</html>