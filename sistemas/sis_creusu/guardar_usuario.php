<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
    </head>
<?php
@session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");

//$oficinas = ;
$oficinas = @$_REQUEST['scu_codoficina'];
$CodigoInterno = generar_codigointerno("PARDEFUSU", "codintusu", $_SESSION["codofi"]);
$nomusu = @$_REQUEST['scu_priape']."  ".@$_REQUEST['scu_segape']." ".@$_REQUEST['scu_prinom']." ".@$_REQUEST['scu_segnom'];

$sql = "SELECT 
			codintusu,
			prinom, 
			segnom, 
			priape, 
			segape, 
			nomusu, 
			cadpas
  		FROM 
  			pardefusu
  		where 
  			cedusu = '".@$_REQUEST['scu_cedusu']."'";
$result = pg_query($bd_conexion,$sql);
$codintusu = @pg_result($result,0,"codintusu");

$sql2="select count(logemp) as total from pardefusu where logemp='".strtoupper(@$_REQUEST['scu_usuario'])."' and cedusu not like '".@$_REQUEST['scu_cedusu']."'";

$resultado = pg_query($bd_conexion,$sql2);
$repetido= pg_result($resultado,0,"total");

if($repetido==0)
{
	
if (pg_num_rows($result)>0)
{
	//en pardefusu el codcar es id_tip_usuario de la tabla usuarios
	$sql = "UPDATE 
				pardefusu
   			SET 
   				prinom='".latin1(@$_REQUEST['scu_prinom'])."', 
   				segnom='".latin1(@$_REQUEST['scu_segnom'])."', 
   				priape='".latin1(@$_REQUEST['scu_priape'])."',
   				segape='".latin1(@$_REQUEST['scu_segape'])."', 
       			nomusu='".latin1($nomusu)."',
       			logemp='".strtoupper(@$_REQUEST['scu_usuario'])."',
       			emausu='".@$_REQUEST['scu_email']."',
       			pas_syn='".@$_REQUEST['scu_clave']."',
       			cadpas='".@$_REQUEST['scu_estatus']."',
       			codcar='".@$_REQUEST['scu_descar']."',
				estuni='".@$_REQUEST['scu_estatus']."'
 			WHERE 
 				cedusu='".@$_REQUEST['scu_cedusu']."' ";

	$result = pg_query($bd_conexion,$sql);
	if (pg_affected_rows($result)>0) 
    {
    	$sql = "delete from segusuofi where codintusu = '".$codintusu."'";
    	$result = pg_query($bd_conexion,$sql);
		$sql = "insert into segusuofi (codintusu,codofi) values ('".$codintusu."','001')";
    	$result = pg_query($bd_conexion,$sql);
    	$i=0;
		echo "<SCRIPT LANGUAGE='javascript'>swal('El usuario se actulizó','correctamente', 'success');</script>";
  /*  	while($i<count($oficinas) && $oficinas[$i]!="")
    	{
    		
			
    		$i=$i+1;
    	}*/
    }		
    else
    {
		echo "<SCRIPT LANGUAGE='javascript'>swal('No se pudo actualizar el usuario','Por favor verifique datos', 'error');</script>";
    }

}
else
{
	$sql = "INSERT INTO pardefusu(
            	codintusu, 
            	cedusu, 
            	prinom, 
            	segnom, 
            	priape, 
            	segape, 
            	nomusu,
            	logemp, 
            	cadpas,
            	feccad, 
            	codintapr, 
            	codintaut, 
            	codintsup, 
            	pas_syn,
				emausu,
				estuni,
				codcar)
			VALUES (
				'".$CodigoInterno."',
				'".@$_REQUEST['scu_cedusu']."', 
    			'".latin1(@$_REQUEST['scu_prinom'])."', 
    			'".latin1(@$_REQUEST['scu_segnom'])."', 
    			'".latin1(@$_REQUEST['scu_priape'])."',
    			'".latin1(@$_REQUEST['scu_segape'])."', 
    			'".latin1($nomusu)."',
    			'".strtoupper(@$_REQUEST['scu_usuario'])."', 
    			'N',
    			current_date, 
    			'".$_SESSION["codintusu"]."', 
            	'".$_SESSION["codintusu"]."', 
            	'".$_SESSION["codintusu"]."',
            	'".@$_REQUEST['scu_clave']."',
				'".@$_REQUEST['scu_email']."',
				'".@$_REQUEST['scu_estatus']."',
				'".@$_REQUEST['scu_descar']."')";
				
		
	$result = pg_query($bd_conexion,$sql);
	
	if (pg_affected_rows($result)>0) 
    {
    	
		$sql = "delete from segusuofi where codintusu = '".$codintusu."'";
    	$result = pg_query($bd_conexion,$sql);
		$sql = "insert into segusuofi (codintusu,codofi) values ('".$CodigoInterno."','001')";
			
    		$result = pg_query($bd_conexion,$sql);
 /*   	$i=0;
    	while($i<count($oficinas) && $oficinas[$i]!="")
    	{
    		
    		$i=$i+1;
    	}*/
		echo "<SCRIPT LANGUAGE='javascript'>swal('El usuario se registró','correctamente', 'success');</script>";
    }		
    else
    {
		echo "<SCRIPT LANGUAGE='javascript'>swal('No se pudo resgistrar el usuario','Por favor verifique', 'error');</script>";
    }
}

}else
	echo "<SCRIPT LANGUAGE='javascript'>swal('El usuario no puede ser utilizado,','Ya se encuentra asignado a otra persona', 'warning');</script>";
 

?>
</html>