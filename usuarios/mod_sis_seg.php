<?php
require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require_once("../../clases/utilidades.class.php");
require("../../sesion.php");
$cedula=$_SESSION["cedusu_seg"];
$oficina=$_SESSION["mod_usu_sistema"];


$objUtilidades=new utilidades;
$sentencia="select codintusu,cedusu,nomusu,logemp from pardefusu where trim(cedusu)='".$cedula."'";
$usuario=$objUtilidades->buscar_datos($sentencia);

$sql="select p2.codapl,p2.nombre_modulo,p2.nombre_pestana from paraccsynnom p2 where  p2.estatus='A' and id_modulo='9' order by p2.nombre_modulo ";
$ok=pg_query($sql);

echo '<table width="95%" align="center" class="tbldatos1" BORDER="1">
     <tr height="30px">
        <td  align="center" colspan="5" class="fondo_fila_amarilla" >Asignaci&oacute;n de Permisos</td>
     </tr>';
	 
echo "<tr align='center' class='fondo_fila_amarilla'>
        <td width='5%'>Num</td>
        <td width='5%'>Apl.</td>
		<td width='30%'>Módulo</td>
		<td width='55%'>Pestaña</td>
		<td width='5%'>Permiso</td>
      </tr>";
$i=1;	  
$vector="";	 
while(($permiso=pg_fetch_assoc($ok))>0)
{
$sentencia2="select codacc from 
paraccsyn where codintusu='".$usuario["codintusu"]."' and codapl='".$permiso['codapl']."' and codofi='$oficina'";
$chequeado=$objUtilidades->buscar_datos($sentencia2);

if($chequeado['codacc']==1)
 $check="checked='checked'";
  else 
   $check=""; 
echo "<tr>
        <td align='center'>$i</td>
        <td align='center'>$permiso[codapl]</td>
		<td>$permiso[nombre_modulo]</td>
		<td>$permiso[nombre_pestana]</td>
		<td align='center'><input type='checkbox' id='$permiso[codapl]' name='$permiso[codapl]' $check></td>
      </tr>";
$vector.=$permiso['codapl']."#";  
$i++;	  	
}
echo "<input type='hidden' name='mod_sis_seg2' id='mod_sis_seg2' value='$vector'>";
echo "<tr class='fondo_fila_amarilla'><td colspan='5' align='left'>Seleccionar Todos<input type='radio' name='mod_sis_seg3' onclick='asignar_permisos(\"".'mod_sis_seg2'."\",1)'>Seleccionar Ninguno<input type='radio' name='mod_sis_seg3' onclick='asignar_permisos(\"".'mod_sis_seg2'."\",0)'></td></tr>";
echo "</table>";

