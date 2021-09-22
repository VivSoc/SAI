<?php
class ordenes
{
function eliminar_item_orden($tabla,$cod)
{
	$sql="DELETE FROM $tabla WHERE cod_pro_com='".$cod."'";
	pg_query($sql);
}

function guardar_orden_compras($tmp_tabla,$idpro,$iddoc,$fecreg)
{
	$id_orden=generar_id_compra('ordenes_compra','id_orden','ORDE');
	$sql="INSERT INTO ordenes_compra(id_orden, tipo_orden, fec_reg_orden, id_cli_pro, id_usuario) VALUES ('".$id_orden."','ORDEN DE COMPRA','".$fecreg."','".$idpro."','".$_SESSION['usuario']."')";
	$ok=pg_query($sql);
	$sql2="select * from ".$tmp_tabla;
	$ok2=pg_query($sql2);
	while(($datos=pg_fetch_assoc($ok2))>0)
	{
		$sql3="INSERT INTO ordenes_compras_detalle(id_orden, id_producto, can_pro_com,und_medida) VALUES ('".$id_orden."','".$datos['cod_pro_com']."','".$datos['can_pro_com']."','".$datos['med_pro_com']."')";
		$ok3=pg_query($sql3);
		
	}
	
	if ($ok && $ok3)
	{
		$sql4="DELETE FROM $tmp_tabla";
			$ok4=pg_query($sql4);
		echo"<script language='javascript'>swal('Orden de Compra Registrada', 'Exitosamente', 'success')
		imprimir_orden_compra('".$id_orden."');</script>";
		
	}
	else
		echo"<script language='javascript'>swal('Error al registrar la Orden de Compra', 'por algún motivo no se pudo registrar, pongase en contacto con el administrador', 'error')</script>";
}
function eliminar_temp_odc($tabla)
{
	$sql="DELETE FROM ".$tabla;
	pg_query($sql);
	
}

}// Fin de la Clase
?>
