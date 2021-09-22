<?php
session_start();
class abre_caja
{
function buscar_abrir_caja($codcaja)
{
	$mensaje="";
require_once("clases/funciones.php");
//primero busca si el cod_caja existe en tabla cajas
	$sql="select id_caja from cajas where id_caja='".strtoupper(@$_REQUEST['codcaja'])."' and sta_caja='A'";
		$x=pg_query($sql);
			if(pg_num_rows($x)<=0)
			{
				echo"<script language='javascript'>swal('Verifique datos', 'Código de caja no registrado, por favor verifique', 'warning')</script>";
			}
			else
			{
				//aquí busca si la caja está abierta en abre_cajas
				$sql="select * from abre_cajas where id_caja='".strtoupper(@$_REQUEST['codcaja'])."' and sta_abertura='A'";
				$y=pg_query($sql);
					if(pg_num_rows($y)<=0)
					{
						$fecha=date('d/m/Y');
						//aquí busca si el usuario ya abrió una caja en el día
						$sql="select * from abre_cajas where sta_abertura='A' and id_usuario='".$_SESSION['scu_cedusu']."' and fec_abertura='".$fecha."'";
						$y=pg_query($sql);
							if(pg_num_rows($y)<=0)
							{
								echo"<script language='javascript'>abertura_caja()</script>";
							}
							else
							{
								echo"<script language='javascript'>swal('El usuario ya posee una caja abierta', 'no puede abrir dos cajas el mismo día', 'error')</script>";
							}
					}
					else
					{
					echo"<script language='javascript'>swal('La caja ya está abierta', 'seleccione otra caja para abrir', 'warning')</script>";
					}
					
					
			}
}
function abrir_caja($cedusuario,$codcaja,$fecha,$montousd)
{
require_once("clases/funciones.php");
	$mensaje="";
	$codigo=generar_codigo_bd("abre_cajas","id_abertura");
	$sql1="INSERT INTO abre_cajas(id_abertura, id_caja, fec_abertura, id_usuario, fondo_caja, sta_abertura)
    VALUES ('".$codigo."','".$codcaja."','".$fecha."','".$cedusuario."','".$montousd."','A')";
				$mensaje="A";
		
		if(pg_query($sql1))
		{
			if ($mensaje="A")
			{
	//		$_SESSION['cod_caja']=$codcaja;
	//		$_SESSION['caja']='A';
			echo"<script language='javascript'>swal('La caja se abrió exitosamente', 'Ya puede ingresar al módulo de ventas', 'success');//verifica_caja();</script>";
			$descaja="select des_caja from cajas where id_caja='".$codcaja."'";
			$x=pg_query($descaja);
			$nomcaja=pg_fetch_row($x);
			echo"<script language='javascript'>document.getElementById('prueba').value='".$nomcaja[0]."'</script>";
			}
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
				echo"<script language='javascript'>swal('No hay caja abierta', 'Debe abrir caja para ingresar al modulo de ventas', 'warning')</script>";
	
							
			}
			else
			{
				echo"<script language='javascript'>document.getElementById('cuerpo_ventas_cliente').innerHTML='';</script>";	
				require("vistas/ventas/filtro_ventas.php");
			}

}

function verifica_caja_sesion()
{
	require_once("clases/funciones.php");
	$objUtilidades=new utilidades;
	$fecsol=date('d/m/Y');
	$nom_caja=$objUtilidades->buscar_datos($sql = "select a.*, b.des_caja from apertura_caja a, cajas b where a.ced_usuario='".$_SESSION['ced_usuario']."' and a.sta_apertura='A' and a.fec_apertura='".$fecsol."'and b.cod_caja=a.cod_caja");

	if($nom_caja['des_caja']!="")
	{
		$descaja=utf8_decode($nom_caja['des_caja']);
		echo"<script language='javascript'>document.getElementById('prueba').value='".$descaja."'
		 </script>";
	}
	else
	{
		$descaja='No tiene caja abierta';
		echo"<script language='javascript'>document.getElementById('prueba').value='".$descaja."'</script>";
	}

}

}// Fin de la Clase
?>
