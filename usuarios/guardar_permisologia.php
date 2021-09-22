<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
    </head>
<?php
require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require_once("../../clases/utilidades.class.php");
require_once("../../clases/funciones.php");
require("../../sesion.php");

$aplicacion=@$_POST["aplicacion"];
$codacc=@$_POST["codacc"];
$codintusu=$_SESSION["codintusu_sis"];
$codofi=$_SESSION["mod_usu_sistema"];
$objUtilidades=new utilidades;

$total=count($aplicacion);

for($i=0;$i<$total;$i++)
{
$sentencia2="select count(codacc) as existe from paraccsyn where codintusu='".$codintusu."' and codofi='".$codofi."' and codapl='".$aplicacion[$i]."'";
$acceso=$objUtilidades->buscar_datos($sentencia2);

if($acceso["existe"]>0)
{
 $sql="update paraccsyn set 
 codacc='$codacc[$i]' where 
 codintusu='".$codintusu."' and 
 codofi='".$codofi."' and 
 codapl='".$aplicacion[$i]."'";
 pg_query($sql);
 
}
else
{	
 $sql="insert into paraccsyn(codintusu,codapl,codacc,codofi) values ('$codintusu','$aplicacion[$i]','$codacc[$i]','$codofi')";	
 pg_query($sql); 
}

}
echo "<SCRIPT LANGUAGE='javascript'>swal('Permisos asignados','correctamente', 'success');</script>";
echo "<h2>Permisos Asignados Correctamente</h2>";
$_SESSION["cedusu_seg"]="";
$_SESSION["mod_usu_sistema"]="";
$_SESSION["codintusu_sis"]="";
?>
</html>
