<?php
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/utilidades.class.php");
require("../../../sesion.php");
?>
<script type="text/javascript" src="javascript/general/general.js"> </script>
<script type"text/javascript" src="javascript/utilidades.js"> </script>


<div id="movimiento_cuenta"> <!-- DIV 1 -->

<table width="600" align="center" class="tbldatos1">
    <tr>
         <td colspan="4" align="center" id="fondo_blanco"  >LISTADO DE MOVIMIENTOS POR CUENTA</td>
   </tr>
   
<tr>

   		<td  width="120" >Fecha Desde</td>
		<td  ><input type="text" id="gen_fecha_desde_fmc" name="gen_fecha_desde_fmc" style="width:60px;" maxlength="10" value="<?php echo date("d/m/Y"); ?>"  onkeypress="enter2tab(event,'gen_fecha_hasta_fmc',0);" ></td>
        

       
        <td width="120" >Fecha Hasta</td>
        <td  ><input type="text" id="gen_fecha_hasta_fmc" name="gen_fecha_hasta_fmc" style="width:60px;" maxlength="10" value="<?php echo date("d/m/Y"); ?>"  onkeypress="enter2tab(event,'gen_numcta_fmc',0);" ></td>        
        
 </tr> 
 
   <TD>Cuenta:</TD>
         <TD  colspan="3"><input type="text" name="gen_numcta_fmc" id="gen_numcta_fmc" maxlength="12" size="20"onkeypress="enter2tab(event,'b_movcta',0);" />
	</TD>

       
		<tr class="fondo_fila_azul">
        <td colspan="4" align="center">
<input type="button" name="b_movcta" id="b_movcta" value="Generar Reporte" onclick="reporte_movimiento_cuenta()" ></td>
	</tr>
    
    
 <tr
    
     
    
</table>

</div> <!-- FIN DIV liquidar -->
