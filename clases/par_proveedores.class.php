<?php
class par_proveedores
{
function guardar_proveedores($id_proveedor,$nomproveedor,$provincia,$canton,$parroquia,$dirproveedor,$celproveedor,$emailproveedor,$contacto,$per_contacto,$tip_contribuyente,$estaproveedor,$dias_credito,$lim_credito)
{
	if ($emailproveedor=='')
		$emailproveedor='N/S';
	if($contacto=='')
		$contacto='N/S';
	if($per_contacto=='')
		$per_contacto='N/S';
	
		
	$sql="select * from clientes_proveedores where id_cli_pro='".$id_proveedor."'";
	$x=pg_query($sql);
	
	if(pg_num_rows($x)<=0)
	{
		$sql1="INSERT INTO clientes_proveedores(
            id_cli_pro, nombre, direccion, telefono, contacto,
			tel_contacto, email, id_tip_contribuyente, estatus, lim_credito,
			id_provincia, id_canton, id_parroquia, dias_credito)
    VALUES ('".$id_proveedor."','".$nomproveedor."', '".$dirproveedor."', '".$celproveedor."', '".$contacto."', 
			'".$per_contacto."', '".$emailproveedor."','".$tip_contribuyente."', '".$estaproveedor."', '".$lim_credito."',
            '".$provincia."','".$canton."','".$parroquia."','".$dias_credito."')";
		$mensaje="Datos del cliente registrados exitosamente";
		echo "<script language='javascript'>par_prov_limpiar()</script>";
		
	}
	else
	{
		$sql1= "UPDATE clientes_proveedores
   SET nombre='".$nomproveedor."', direccion='".$dirproveedor."', telefono='".$celproveedor."', contacto='".$contacto."', tel_contacto='".$per_contacto."', email='".$emailproveedor."', id_tip_contribuyente='".$tip_contribuyente."', estatus='".$estaproveedor."', lim_credito='".$lim_credito."', id_provincia='".$provincia."', id_canton='".$canton."', id_parroquia='".$parroquia."', dias_credito='".$dias_credito."' WHERE id_cli_pro='".$id_proveedor."'";
		$mensaje="Datos del cliente actualizados exitosamente";
		echo "<script language='javascript'>par_prov_limpiar()</script>";
	}
		if(pg_query($sql1))
		{
			
			echo"<script language='javascript'>swal('".$mensaje."', 'Proveedor:".$nomproveedor."', 'success')
			par_prov_limpiar()</script>";
		}
		else
		{
			echo"<script language='javascript'>swal('Por algún motivo no se pudo registar', 'Por favor contacte al desarrollador', 'error')</script>";
		}
		echo"<script language='javascript'></script>";
}

}// Fin de la Clase par_empresas
?>
