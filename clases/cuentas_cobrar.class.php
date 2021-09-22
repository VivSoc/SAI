<?php
class cuentas_cobrar
{

function registro_abono_cxc($idctacobrar,$monabono,$fecabono,$obsabono)
{
//	var_dump($idctapagar." ".$monabono." ".$fecabono." ".$obsabono);	
	$sql="INSERT INTO detalle_cuentas_cobrar(id_cue_cobrar, fec_abono, mon_abono, observaciones) VALUES
	 ('".$idctacobrar."','".$fecabono."',".$monabono.",'".$obsabono."')";

	$ok=pg_query($sql);
	if ($ok)
	{
		echo"<script language='javascript'>swal('Abono registrado', 'Exitosamente', 'success')</script>";
	}
	else
		echo"<script language='javascript'>swal('Error al registrar Abono', 'por algún motivo no se pudo registrar, pongase en contacto con el administrador', 'error')</script>";
}
}// Fin de la Clase
?>
