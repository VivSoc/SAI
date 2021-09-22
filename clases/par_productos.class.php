<?php
class par_productos
{
function guardar_producto($parcodpro,$partippro,$parcodcat,$parcodmarca,$parcodmodelo,$parcodtamano,$parcodforma,$parcodmaterial,$parcodcolor,$parcodpresenta,$parcodorigen,$parcodpropieta,$parcodubica,$parpeso,$parcodpes,$pardesproc,$parprecompra,$parprevendet,$parprevenmay,$parmoniva,$parssctomax,$parcanpro,$parcodunidad,$parcanmin,$parcanmax,$parstapro,$parfotopro,$permite_descuento,$num_lote,$fec_caducidad,$can_lote,$id_alterno)
//,$pardesprol
{
	require_once("clases/funciones.php");
		$objUtilidades=new utilidades;
		$mensaje="";
		if ($parcodpro=="NUEVO")
		{		
			$parcodcat=substr($parcodcat,0,4);
			$objUtilidades=new utilidades;
			$codigo=generar_codigo_producto("productos","id_producto",$parcodcat);
		$sql="INSERT INTO productos(
            id_producto, id_categoria, id_marca, id_modelo,
			id_tamano, id_forma, id_material, 
			id_color, id_presentacion, id_origen,
			pre_compra, id_propietario, stock_min, stock_max, id_ubicacion,
			foto_producto, can_producto, des_corta, tipo_producto, id_unidad,
			mon_iva, sta_descuento, porcen_descuento_max, sta_producto, id_unidad_peso,
			peso_producto, pre_venta_detal, pre_venta_mayor, id_alterno)
    VALUES ('".$codigo."', '".$parcodcat."', '".substr($parcodmarca,0,4)."', '".substr($parcodmodelo,0,4)."',
			 '".substr($parcodtamano,0,4)."', '".substr($parcodforma,0,4)."', '".substr($parcodmaterial,0,4)."',
			  '".substr($parcodcolor,0,4)."', '".substr($parcodpresenta,0,4)."','".substr($parcodorigen,0,4)."',
			    ".$parprecompra.", '".$parcodpropieta."', ".$parcanmin.", ".$parcanmax.", '".$parcodubica."',
            	'".substr($parfotopro,-15)."', ".$parcanpro.", '".$pardesproc."', '".$partippro."', '".$parcodunidad."',
			 	 ".$parmoniva.", '".$permite_descuento."', ".$parssctomax.", '".$parstapro."', '".$parcodpes."',
				".$parpeso.", ".$parprevendet.", ".$parprevenmay.", '".$id_alterno."')";
			echo "<script language='javascript'>par_productos_limpiar()</script>";
			$mensaje="A";
		}
		else
		{
			
			$sql="UPDATE productos SET id_categoria='".substr($parcodcat,0,4)."', 
			id_marca='".substr($parcodmarca,0,4)."', 
			id_modelo='".substr($parcodmodelo,0,4)."', 
			id_tamano='".substr($parcodtamano,0,4)."', 
			id_forma='".substr($parcodforma,0,4)."', 
			id_material='".substr($parcodmaterial,0,4)."',
			 id_color='".substr($parcodcolor,0,4)."', 
			 id_presentacion='".substr($parcodpresenta,0,4)."',
			  id_origen='".substr($parcodorigen,0,4)."',
			   pre_compra=".$parprecompra.", 
			   id_propietario='".$parcodpropieta."',
			    stock_min=".$parcanmin.",
				 stock_max=".$parcanmax.", 
				 id_ubicacion='".substr($parcodubica,0,4)."',
				  foto_producto='".substr($parfotopro,-15)."', 
				  can_producto=".$parcanpro.", 
				  des_corta='".$pardesproc."', 
				  tipo_producto='".$partippro."',
				   id_unidad='".$parcodunidad."', 
				   mon_iva=".$parmoniva.", 
				   sta_descuento='".$permite_descuento."',
				    porcen_descuento_max=".$parssctomax.", 
					sta_producto='".$parstapro."',
					 id_unidad_peso='".$parcodpes."',
					  peso_producto=".$parpeso.",
					   pre_venta_detal=".$parprevendet.",
					    pre_venta_mayor=".$parprevenmay.",
						id_alterno='".$id_alterno."'
 			WHERE id_producto='".$parcodpro."';";

			$sql2="UPDATE lotes
   					SET fec_caducidad='".$fec_caducidad."', can_lote=".$can_lote."
 					WHERE id_producto='".$parcodpro."' and num_lote='".$num_lote."'";
			
			echo "<script language='javascript'>par_productos_limpiar()</script>";
			
		}
		if(pg_query($sql))
		{
			if ($mensaje=="A")
			{
				echo"<script language='javascript'>swal('El producto fue registrado', 'con exito', 'success')</script>";
			}
			else
				if(pg_query($sql))
				{
					if(pg_query($sql2))
					{
						echo"<script language='javascript'>swal('El producto fue actualizado incluyendo datos del lote', 'con exito', 'success')</script>";
					}
					else
					{
					echo"<script language='javascript'>swal('El producto fue actualizado', 'con exito', 'success')</script>";
					}
				}
			}
		else
		{
			echo"<script language='javascript'>swal('Error al registrar', 'por algún motivo no se pudo registrar, pongase en contacto con el desarrollador', 'error')</script>";
		}
			

}
function busca_datos_lote($num_lote, $id_producto)
{
	$objUtilidades=new utilidades;
	$datos=$objUtilidades->buscar_datos("select a.id_unidad, b.*, c.des_unidad from productos a, lotes b, unidades c where a.id_producto='".$id_producto."' and b.num_lote='".$num_lote."' and  b.id_producto=a.id_producto and c.id_unidad=a.id_unidad");
		echo"<script language='javascript'>
		document.getElementById('can_lote').value='".$datos['can_lote']."'
		document.getElementById('uni_can_lote').value='".$datos['des_unidad']."'
		document.getElementById('fec_caducidad').value='".formato_fecha($datos['fec_caducidad'])."'
		document.getElementById('fec_compra').value='".formato_fecha($datos['fec_compra'])."'		
		</script>";		

}


}// Fin de la Clase
?>