<?php
class cuentas_pagar
{

function registro_abono_cxp($idctapagar,$monabono,$fecabono,$obsabono)
{
//	var_dump($idctapagar." ".$monabono." ".$fecabono." ".$obsabono);	
	$sql="INSERT INTO detalle_cuentas_pagar(id_cue_pagar, fec_abono, mon_abono, observaciones) VALUES
	 ('".$idctapagar."','".$fecabono."',".$monabono.",'".$obsabono."')";
//	 var_dump($sql);

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
