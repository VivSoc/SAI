<?php
class cierre_caja
{
function buscar_cie_caja($codcaja)
{
	require_once("clases/funciones.php");
	$fecactual=date();
//primero busca si el cod_caja tabla apertura_caja está asociado al usario activo
	$sql="select id_caja from abre_cajas where id_caja='".strtoupper(@$_REQUEST['codcaja'])."' and id_usuario='".$_SESSION['scu_cedusu']."' and sta_abertura='A'";
		$x=pg_query($sql);
			if(pg_num_rows($x)<=0)
			{
				echo"<script language='javascript'>swal('El Código ingresado no corresponde a ninguna caja abierta por este usuario','','error')</script>";
			}
			else
			{
				//aqui abre datos cierre de caja				
				echo"<script language='javascript'>cierre_caja()</script>";	
			}
}
function cerrar_caja($idpago,$monpago,$pagos,$feccie,$cedusuario,$codcaja)
{
	var_dump();
	/*require_once("clases/funciones.php");
	//buscar fondo
	$objUtilidades=new utilidades;
	$fondo=$objUtilidades->buscar_datos($sql="select fondo_caja_cop,fondo_caja_usd,fondo_caja_bs from apertura_caja where cod_caja='".$codcaja."' and fec_apertura='".$feccie."' and ced_usuario='".$cedusuario."' and sta_apertura='A'");
	$fondocop=$fondo['fondo_caja_cop'];
	$fondousd=$fondo['fondo_caja_usd'];
	$fondobss=$fondo['fondo_caja_bs'];
	
	//buscar movim caja E+/I-
	$egresos=$objUtilidades->buscar_datos($sql="SELECT sum(cop_mov) cop_e,sum(usd_mov) usd_e, sum(bs_mov) bss_e FROM MOVIMIENTOS_caja where mov_caja='E' and fec_mov='".$feccie."' and ced_usuario='".$cedusuario."' and cod_caja='".$codcaja."'");
	$cop_e=$egresos['cop_e'];
	$usd_e=$egresos['usd_e'];
	$bss_e=$egresos['bss_e'];

	$ingresos=$objUtilidades->buscar_datos($sql="SELECT sum(cop_mov) cop_i,sum(usd_mov) usd_i, sum(bs_mov) bss_i FROM MOVIMIENTOS_caja where mov_caja='I' and fec_mov='".$feccie."' and ced_usuario='".$cedusuario."' and cod_caja='".$codcaja."'");
	$cop_i=$ingresos['cop_i'];
	$usd_i=$ingresos['usd_i'];
	$bss_i=$ingresos['bss_i'];
	
	/******  ******/
/*	$montocop2=$montocop+$cop_e-$cop_i;
	$montousd2=$montousd+$usd_e-$usd_i;
	$montobs2=$montobs+$bss_e-$bss_i;
	
	
	$sql="select sum(cop_efectivo) copefe,sum(usd_efectivo) usdefe,sum(usd_transf) usdtransf,sum(bss_efectivo) bssefe,sum(bss_transf) bsstransf,sum(bss_debito) bssdeb,sum(bss_credito) bsscre,sum(bss_pmovil) bsspmovil from ventas a, ventas_detalle_pago b 
	where a.fecha_venta='".date('d/m/Y')."' and b.id_venta=a.id_venta";
	$ok=pg_query($sql);
	$copefe=(pg_fetch_result($ok,0,'copefe')==''?0:pg_fetch_result($ok,0,'copefe'));
	$usdefe=(pg_fetch_result($ok,0,'usdefe')==''?0:pg_fetch_result($ok,0,'usdefe'));
	$usdtra=(pg_fetch_result($ok,0,'usdtransf')==''?0:pg_fetch_result($ok,0,'usdtransf'));
	$bssefe=(pg_fetch_result($ok,0,'bssefe')==''?0:pg_fetch_result($ok,0,'bssefe'));
	$bsstra=(pg_fetch_result($ok,0,'bsstransf')==''?0:pg_fetch_result($ok,0,'bsstransf'));
	$bssdeb=(pg_fetch_result($ok,0,'bssdeb')==''?0:pg_fetch_result($ok,0,'bssdeb'));
	$bsscre=(pg_fetch_result($ok,0,'bsscre')==''?0:pg_fetch_result($ok,0,'bsscre'));
	$bssmov=(pg_fetch_result($ok,0,'bsspmovil')==''?0:pg_fetch_result($ok,0,'bsspmovil'));
	
	/*****Ingresado por el usuario contra lo registrado EN SISTEMA******/
/*	$difcop=$montocop2-$copefe-$fondocop;
	$difusd=$montousd2-$usdefe-$fondousd;
	$difbss=$montobs2-$bssefe-$fondobss;
	$difdeb=$montodebito-$bssdeb;
	$difcre=$montocredito-$bsscre;
	
	$codigo=generar_codigo_bd("cierre_caja","id_cierre");
	
	
	$sql1="INSERT INTO cierre_caja(id_cierre, cod_caja, fec_cierre, hora_cierre, ced_usuario, efectivo_cop, efectivo_usd, tranf_usd, efectivo_bs, debito_bs, credito_bs, tranf_bs, pmovil_bs, dif_cop, dif_usd, dif_bs, dif_deb, dif_cre)VALUES ('".$codigo."','".$codcaja."','".date('d/m/Y')."','".date('H:i:s')."','".$cedusuario."',".$montocop.",".$montousd.",".$usdtra.",".$montobs.",".$montodebito.",".$montocredito.",".$bsstra.",".$bssmov.",".$difcop.",".$difusd.",".$difbss.",".$difdeb.",".$difcre.")";
	if(pg_query($sql1))
	{
		$sql2="update apertura_caja set sta_apertura='C' where cod_caja='".$codcaja."'";
		$ok=pg_query($sql2);
		echo"<script language='javascript'>imprimir_cierre(\"".$codigo."\");</script>";
	}
	else
	{
		echo"<script language='javascript'>swal('Ha ocurrido un error en el Cierre de Caja', 'Por favor verifique los datos', 'warning')</script>";
	}*/
}

}// Fin de la Clase
?>
