<?php
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/utilidades.class.php");
require("../../../sesion.php");
?>
<script type="text/javascript" src="javascript/general/general.js"> </script>
<script type"text/javascript" src="javascript/utilidades.js"> </script>


<div id="movimiento_tipo"> <!-- DIV 1 -->

<table width="600" align="center" class="tbldatos1">
    <tr>
         <td colspan="4" align="center" id="fondo_blanco"   >LISTADO DE MOVIMIENTOS POR TIPO</td>
   </tr>
   
<tr>

   		<td>Fecha Desde</td>
		<td><input type="text" id="gen_fecha_desde_fmp" name="gen_fecha_desde_fmp" style="width:60px;" maxlength="10" value="<?php echo date("d/m/Y"); ?>"  onkeypress="enter2tab(event,'gen_fecha_hasta_fmp',0);" ></td>
        

       
        <td>Fecha Hasta</td>
        <td><input type="text" id="gen_fecha_hasta_fmp" name="gen_fecha_hasta_fmp" style="width:60px;" maxlength="10" value="<?php echo date("d/m/Y"); ?>"  onkeypress="enter2tab(event,'gen_numcta_fmc',0);" ></td>        
        
 </tr> 
 	<tr>
		<td>Tipo Desde: </td>
		<td>
			<input type="text" id="gen_tipodes" name="gen_tipodes" size="2" maxlength="3" onkeyup="CodigoToSelect(document.getElementById('gen_tipodes').value,document.getElementById('gen_destipdes'))" onkeypress="return solo_numeros(event);" />
			<select id="gen_destipdes" name="gen_destipdes" style="width:250px;" onchange="document.getElementById('gen_tipodes').value=document.getElementById('gen_destipdes').options[document.getElementById('gen_destipdes').selectedIndex].value">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from parhismov where codmov <> '999' order by codmov");
				while ($registro=pg_fetch_assoc($result))
				{
					echo "<option value=\"".$registro["codmov"]."\">".$registro["codmov"]." - ".$registro["desmov"]."</option>";
				}
				?>
			</select>
		</td>
    </tr>
    <tr>
    
        <td>Tipo Hasta: </td>
		<td>
			<input type="text" id="gen_tipohas" name="gen_tipohas" size="2" maxlength="3" onkeyup="CodigoToSelect(document.getElementById('gen_tipohas').value,document.getElementById('gen_destiphas'))" onkeypress="return solo_numeros(event);" />
			<select id="gen_destiphas" name="gen_destiphas" style="width:250px;" onchange="document.getElementById('gen_tipohas').value=document.getElementById('gen_destiphas').options[document.getElementById('gen_destiphas').selectedIndex].value">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from parhismov where codmov <> '999' order by codmov");
				while ($registro=pg_fetch_assoc($result))
				{
					echo "<option value=\"".$registro["codmov"]."\">".$registro["codmov"]." - ".$registro["desmov"]."</option>";
				}
				?>
			</select>
		</td>
    </tr>
    
   <tr>
		<td >Oficina desde</td>
		<td  colspan="3">
			<input type="text" id="gen_codofi_desde" name="gen_codofi_desde" size="2" maxlength="3" onkeyup="CodigoToSelect(document.getElementById('gen_codofi_desde').value,document.getElementById('gen_oficina_desde'))" onkeypress="return solo_numeros(event);" />
			<select id="gen_oficina_desde" name="gen_oficina_desde" style="width:250px;" onchange="document.getElementById('gen_codofi_desde').value=document.getElementById('gen_oficina_desde').options[document.getElementById('gen_oficina_desde').selectedIndex].value">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from paroficom where codofi <> '999' order by codofi");
				while ($registro=pg_fetch_assoc($result))
				{
					echo "<option value=\"".$registro["codofi"]."\">".$registro["codofi"]." - ".$registro["nomofi"]."</option>";
				}
				?>
			</select>
		</td>
    </tr>
    
    
    <tr>
		<td >Oficina hasta</td>
		<td  colspan="3">
			<input type="text" id="gen_codofi_hasta" name="gen_codofi_hasta" size="2" maxlength="3" onkeyup="CodigoToSelect(document.getElementById('gen_codofi_hasta').value,document.getElementById('gen_oficina_hasta'))" onkeypress="return solo_numeros(event);" />
			<select id="gen_oficina_hasta" name="gen_oficina_hasta" style="width:250px;" onchange="document.getElementById('gen_codofi_hasta').value=document.getElementById('gen_oficina_hasta').options[document.getElementById('gen_oficina_hasta').selectedIndex].value">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from paroficom where codofi <> '999' order by codofi");
				while ($registro=pg_fetch_assoc($result))
				{
					echo "<option value=\"".$registro["codofi"]."\">".$registro["codofi"]." - ".$registro["nomofi"]."</option>";
				}
				?>
			</select>
		</td>
    </tr>
    
    
       
		<tr class="fondo_fila_azul">
        <td colspan="4" align="center">
<input type="button" name="b_movtipo" id="b_movtipo" value="Generar Reporte" onclick="reporte_movimiento_tipo()" ></td>
	</tr>
    
 
    
</table>

</div> <!-- FIN DIV liquidar -->
