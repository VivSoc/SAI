<?php
class par_ivas
{

function validar_monto_iva($mon_iva)
{
require_once("clases/funciones.php");
	$sql="select * from ivas where mon_iva='".@$_REQUEST['mon_iva']."'";
			$x=pg_query($sql);
				if(pg_num_rows($x)>0)
				{
					echo"<script language='javascript'>swal('El monto del iva ya está registrado', 'Por favor verifique', 'warning')</script>";
					echo"<script language='javascript'>document.getElementById('mon_iva').value=''</script>";
				}
}

function validar_letra_iva($mon_iva)
{
require_once("clases/funciones.php");
	$sql="select * from ivas where let_iva='".@$_REQUEST['let_iva']."'";
			$x=pg_query($sql);
				if(pg_num_rows($x)>0)
				{
					echo"<script language='javascript'>swal('La letra asignada al iva ya está registrada', 'Por favor verifique', 'warning')</script>";
					echo"<script language='javascript'>document.getElementById('let_iva').value=''</script>";
				}
	
}

}// Fin de la Clase
?>