<?php
class compras
{
function eliminar_item_compra($tabla,$cod,$lote)
{
	$sql="DELETE FROM $tabla WHERE cod_pro_com='".$cod."' and num_lote='".$lote."'";
	pg_query($sql);
}

function guardar_compras($idforpag,$idpago,$monpago,$banco,$numref,$pagos,$tmp_tabla,$idpro,$iddoc,$numdoc,$fecdoc,$tipcompra,$fecvencomp,$totcompra,$fecregcom)
{
	//var_dump($pagos);	
	//$id_compra=num_control('compras','id_compra');	
	$id_compra=generar_id_compra('compras','id_compra','comp');
	$sql="select registrar_compras('".$tmp_tabla."','".$idpro."','".$iddoc."','".$numdoc."','".$fecdoc."','".$tipcompra."','".$fecvencomp."','".$idforpag."','".$_SESSION['usuario']."',".$totcompra.",'".$fecregcom."')";
	$ok=pg_query($sql);
	 $idcom=pg_fetch_row($ok);
	//var_dump($sql);	
	
	if ($ok)
	{
		$sql="DELETE FROM $tmp_tabla";
			$ok3=pg_query($sql);
		/**guardar formas de pago**/
		for ($i = 0; $i <= $pagos; $i++) 
		{
			//var_dump($pagos);
			if($monpago[$i]>0)
			{
				$idbanco=$banco[$i]!=''?$banco[$i]:'9999';
				$forpag="INSERT INTO compras_forma_pago(id_compra, id_for_pago, mon_pago, id_banco, num_transaccion) 
				VALUES ('".$idcom[0]."','".$idpago[$i]."',".$monpago[$i].",'".$idbanco."','".$numref[$i]."')";
				//var_dump($forpag);
				$ok2=pg_query($forpag);				
			}
		}
		echo"<script language='javascript'>swal('Compra registrada', 'Exitosamente', 'success')</script>";
		
		
			
	}
	else
		echo"<script language='javascript'>swal('Error al registrar', 'por algún motivo no se pudo registrar, pongase en contacto con el administrador', 'error')</script>";
}
function eliminar_temp($tabla)
{
	$sql="DELETE FROM ".$tabla;
	pg_query($sql);
	
}

}// Fin de la Clase
?>
