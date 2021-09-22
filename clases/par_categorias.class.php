
<?php
class par_categorias
{
function guardar_categorias($codcategoria,$descategoria,$stacategoria,$precategoria)
{
	$mensaje="";
require_once("clases/funciones.php");
	if ($_REQUEST['codcategoria']=="NUEVO")
	{
		$codigo=generar_codigo_bd("categorias","cod_categoria");
		$sql1="INSERT INTO categorias(cod_categoria, des_categoria, sta_categoria, pre_categoria) 
		VALUES('".$codigo."','".$descategoria."','".$stacategoria."','".$precategoria."')";
		$mensaje="A";
	}
	else
	{
		$newcodcat=@$_REQUEST['codcategoria'];
		$sql="select * from categorias where cod_categoria='".strtoupper($newcodcat)."'";
		$x=pg_query($sql);
			if(pg_num_rows($x)<=0)
			{
				$codigo=generar_codigo_bd("categorias","cod_categoria");
				$sql1="INSERT INTO categorias(cod_categoria,des_categoria,sta_categoria,pre_categoria) 
		VALUES('".$codigo."','".$descategoria."','".$stacategoria."','".$precategoria."')";
				$mensaje="A";
			}
			else
			{
				$sql1= "UPDATE categorias SET 
				des_categoria='".$descategoria."',
				sta_categoria='".$stacategoria."'
				WHERE cod_categoria='".$newcodcat."'";
				$mensaje="";
			}
	}
	
		if(pg_query($sql1))
		{
			if ($mensaje=="A")
			{
				echo"<script language='javascript'>swal('La nueva categoria fue registrada', 'con exito', 'success')</script>";
			}
			else
			{
				echo"<script language='javascript'>swal('La categoria fue actualizada', 'con exito', 'success')</script>";
			}
		}
		else
		{
			echo"<script language='javascript'>swal('Error al registrar', 'por algún motivo no se pudo registrar, pongase en contacto con el administrador', 'error')</script>";
		}
}
function validar_prefijo_cat($pre_categoria)
{
require_once("clases/funciones.php");
	$sql="select * from categorias where pre_categoria='".@$_REQUEST['pre_categoria']."'";
			$x=pg_query($sql);
				if(pg_num_rows($x)>0)
				{
					echo"<script language='javascript'>swal('El prefijo de la categoría ya está registrado', 'Por favor verifique', 'warning')</script>";
					echo"<script language='javascript'>document.getElementById('pre_categoria').value=''</script>";
				}
	
}
}// Fin de la Clase
?>