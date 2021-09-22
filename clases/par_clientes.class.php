<?php
class par_clientes
{
function guardar_clientes($id_cliente,$nomcliente,$provincia,$canton,$parroquia,$dircliente,$celcliente,$emailcliente,$tip_contribuyente,$estacliente,$dias_credito,$lim_credito)
{
	if ($emailcliente=='')
		$emailcliente='N/S';
		
	$sql="select * from clientes_proveedores where id_cli_pro='".$id_cliente."'";
	$x=pg_query($sql);
	
	if(pg_num_rows($x)<=0)
	{
		$sql1="INSERT INTO clientes_proveedores(
            id_cli_pro, nombre, direccion, telefono, contacto, tel_contacto, 
            email, id_tip_contribuyente, estatus, lim_credito, id_provincia, 
            id_canton, id_parroquia, dias_credito)
    VALUES ('".$id_cliente."','".$nomcliente."', '".$dircliente."', '".$celcliente."', 'N/S', 'N/S', 
            '".$emailcliente."','".$tip_contribuyente."', '".$estacliente."', '".$lim_credito."',
            '".$provincia."','".$canton."','".$parroquia."','".$dias_credito."')";
		$mensaje="Datos del cliente registrados exitosamente";
		
	}
	else
	{
		$sql1= "UPDATE clientes_proveedores
   SET nombre='".$nomcliente."', direccion='".$dircliente."', telefono='".$celcliente."', contacto='N/S', tel_contacto='N/S', email='".$emailcliente."', id_tip_contribuyente='".$tip_contribuyente."', estatus='".$estacliente."', lim_credito='".$lim_credito."', id_provincia='".$provincia."', id_canton='".$canton."', id_parroquia='".$parroquia."', dias_credito='".$dias_credito."' WHERE id_cli_pro='".$id_cliente."'";
		$mensaje="Datos del cliente actualizados exitosamente";
	}
		if(pg_query($sql1))
		{
			
			echo"<script language='javascript'>swal('".$mensaje."', 'Cliente:".$nomcliente."', 'success')
				par_cli_limpiar()</script>";
		}
		else
		{
			echo"<script language='javascript'>swal('Por algún motivo no se pudo registar', 'Por favor contacte al desarrollador', 'error')</script>";
		}
		echo"<script language='javascript'></script>";
}

}// Fin de la Clase par_empresas
?>
