<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
    	<script src="js/ui/jquery.ui.tabs.js" type="text/javascript"></script>
		<script type="text/javascript">
	$(function() {
		$('#mod_seguridad').tabs({ fxFade: false, fxSpeed: 'fast' });
    });
</script>
	</head>
<?php
require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require("../../clases/utilidades.class.php");
require_once("../../clases/funciones.php");
require("../../sesion.php");
$cedula=@$_POST["mod_usu_cedula"];

$objUtilidades=new utilidades;
$sentencia="select codintusu,cedusu,nomusu,logemp from pardefusu where trim(cedusu)='".$cedula."'";

$usuario=$objUtilidades->buscar_datos($sentencia);

if($usuario["codintusu"]=="")
{
	echo "<SCRIPT LANGUAGE='javascript'>swal('Número de documento no encontrado','Debe registrar el usuario en la opción Sistema -> Registro de Usuarios', 'warning');</script>";
  
 echo "<h2>Número de documento no encontrado, Debe registrar el usuario en la opción Sistema -> Registro de Usuarios</h2>"; 
  
}else
{
$oficina=@$_POST["mod_usu_sistema"];	
$sql_of="select nomofi from paroficom where codofi='$oficina'";
$oficina=$objUtilidades->buscar_datos($sql_of);
?>
<script type="text/javascript" src="javascript/usuarios/javascript.js"> </script>
<table width="95%" align="center" class="tbldatos1">
    <tr height="30px">
      <td  align="center" colspan="2" class="fondo_fila_amarilla" >CREACI&Oacute;N DE USUARIOS</td>
   </tr>
   
   <TR height="30px" >
         <TD width="25%">Cédula:</TD>
         <TD width="75%">  
<input type="text" name="mod_ced_usu" id="mod_ced_usu"  size="15" value="<?php echo $usuario["cedusu"] ?>" readonly/>
         </TD>
    </TR>  
    
    <TR height="30px" >
         <TD width="25%">Nombre de Usuario:</TD>
         <TD width="75%">  
<input type="text" name="mod_nom_usu" id="mod_nom_usu"  size="50" value="<?php echo $usuario["nomusu"] ?>" readonly/>
         </TD>
    </TR>   
    
        <TR height="30px" >
         <TD width="25%">Login de Usuario:</TD>
         <TD width="75%">  
<input type="text" name="mod_log_usu" id="mod_log_usu"  size="50" value="<?php echo $usuario["logemp"] ?>" readonly/>
         </TD>
    </TR>     
   
   <TR height="30px" >
         <TD width="25%">Oficina:</TD>
         <TD width="75%">  
<input type="text" name="mod_ofi_seg" id="mod_ofi_seg"  size="50" value="<?php echo $oficina["nomofi"] ?>" readonly/>
         </TD>
    </TR>

</table>

<link rel="stylesheet" href="css/jquery.tabs.css" type="text/css" media="print, projection, screen">

<div id="mod_seguridad" style="width:95%;">
	<ul>
		<li><a href="#mod_general_seg"><span>Ventas</span></a></li> 
        <li><a href="#mod_atencion_seg"><span>Cuentas por Cobrar</span></a></li> 
	    <li><a href="#mod_cortes_seg"><span>Compras</span></a></li>
        <li><a href="#mod_ord_seg"><span>Cuentas por Pagar</span></a></li> 
        <li><a href="#mod_mod_par"><span>Parametrización</span></a></li>
        <li><a href="#mod_sis_seg"><span>Sistema</span></a></li>

     </ul>   
	<div id="mod_general_seg">
   		<?php 
		$_SESSION["cedusu_seg"]=$usuario["cedusu"];
		$_SESSION["mod_usu_sistema"]=@$_POST["mod_usu_sistema"];
		$_SESSION["codintusu_sis"]=$usuario["codintusu"];
		
		require("mod_general_seg.php"); ?>
	</div> 
    
    <div id="mod_atencion_seg">
   		<?php 
		require("mod_atencion_seg.php"); ?>
	</div> 
         
    <div id="mod_cortes_seg">
		<?php require("mod_cortes_seg.php"); ?>    
    </div> 
    
    <div id="mod_ord_seg">
		<?php require("mod_ord_seg.php"); ?>      
    </div> 
    
    
    <div id="mod_mod_par"> 
   		<?php require("mod_mod_par.php"); ?>
	</div>    
  
     <div id="mod_sis_seg"> 
   		<?php require("mod_sis_seg.php"); ?>
	</div>    	
    					
</div>
<table width="95%" align="center" class="tbldatos1">
    <tr height="30px">
      <td  align="center" class="fondo_fila_amarilla" ><input  type="submit"  value="Guardar Permisos" onclick="guardar_permisos_usuario()"/></td>
   </tr>
</table>   

<?php
}
?>
</html>