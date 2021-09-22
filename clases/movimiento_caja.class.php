<?php
class movimiento_caja
{
function guardar_mov_caja($operacion, $fec, $cedusu, $codcaj, $monusd, $mot)
{
	require_once("clases/funciones.php");
	$codigo=generar_codigo_bd("movimientos_caja","id_movimiento");
	$sql1="INSERT INTO movimientos_caja(id_movimiento, mov_caja, mon_movimiento, fec_movimiento, id_caja, obs_mov)
    VALUES ('".$codigo."', '".$operacion."', ".$monusd.", '".$fec."', '".$codcaj."', '".$mot."')";
	
		if(pg_query($sql1))
		{
			echo"<script language='javascript'>swal('Movimiento de caja registrado', '', 'success')</script>";
			echo"<script language='javascript'>limpiar_mov_caja()</script>";
		}
		else
		{
			echo"<script language='javascript'>swal('Error al registrar', 'por algún motivo no se pudo registrar, pongase en contacto con el desarrollador', 'error')</script>";
		}
		
}
function evaluar_aperturas()
{
	$fecha=date('d/m/Y');
$sql="select * from apertura_caja where ced_usuario='".$_SESSION['ced_usuario']."' and sta_apertura='A' and fec_apertura='".$fecha."'";
		$x=pg_query($sql);
			if(pg_num_rows($x)<=0)
			{
				require("../../vistas/ventas/apertura_caja/filtro_apertura_caja.php");
			}
			else
			{
				echo"<script language='javascript'>swal('Ya posee una caja abierta', 'Un usuario no puede abrir dos cajas el mismo día', 'error')</script>";
			}

}
function validar_caja_usuario()
{
	$fecha=date('d/m/Y');
		$sql="select * from apertura_caja where ced_usuario='".$_SESSION['ced_usuario']."' and fec_apertura='".$fecha."' and sta_apertura='A'";
		$x=pg_query($sql);
			if(pg_num_rows($x)<=0)
			{
				require("vistas/ventas/tabs_ventas.php");
				echo"<script language='javascript'>document.getElementById('cuerpo_ventas_cliente').innerHTML='';</script>";	
				echo"<script language='javascript'>swal('No hay caja abierta', 'Debe abrir una caja para ingresar al módulo de ventas', 'warning')</script>";
	
							
			}
			else
			{
				echo"<script language='javascript'>document.getElementById('cuerpo_ventas_cliente').innerHTML='';</script>";	
				require("vistas/ventas/filtro_ventas.php");
			}

}


}// Fin de la Clase
?>
