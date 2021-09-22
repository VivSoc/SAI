<?php 
session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require_once("../../../clases/utilidades.class.php");
echo"<script>document.getElementById('nomcliente').focus()</script>";

//require("../../sesion.php");
$sql = "SELECT a.*, b.*, c.*, d.* FROM clientes_proveedores a, provincias b, cantones c, parroquias d where id_cli_pro = '".@$_REQUEST['id_cliente']."' and d.id_parroquia=a.id_parroquia and d.id_provincia=a.id_provincia and d.id_canton=a.id_canton and d.id_provincia=b.id_provincia and d.id_canton=c.id_canton and c.id_provincia=a.id_provincia and b.id_provincia=a.id_provincia";

$result = pg_query($bd_conexion,$sql);
$nombre=pg_fetch_result($result,0,"nombre");
$direccion=pg_fetch_result($result,0,"direccion");
$telefono=pg_fetch_result($result,0,"telefono");
$email=pg_fetch_result($result,0,"email");
$id_tip_contribuyente=pg_fetch_result($result,0,"id_tip_contribuyente");
$provincia=pg_fetch_result($result,0,"id_provincia");
$canton=pg_fetch_result($result,0,"id_canton");
$parroquia=pg_fetch_result($result,0,"id_parroquia");
$sta_cliente=pg_fetch_result($result,0,"estatus");
$lim_credito=pg_fetch_result($result,0,"lim_credito");
$dias_credito=pg_fetch_result($result,0,"dias_credito");


?>
<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
        <script type="text/javascript" src="javascript/ventas/clientes.js"> </script>
    </head>

<table  width="100%" align="center" class="tbldatos1">
	<tr>
		<td colspan="3" align="center" class="fondo_fila_amarilla";>Datos del Cliente</td>
	</tr>
	<tr>
		<td width="15%">Nombre Cliente</td>
		<td><input type='text' style="width:200px;" value='<?php echo $nombre ?>' name='nomcliente' id='nomcliente' maxlength='50' onKeyPress="enter2tab(event,'id_provincia',0);" onKeyUp="document.getElementById('nomcliente').value=document.getElementById('nomcliente').value.toUpperCase();"  /><font color="#CC0000"> <i> (*) </font></i> </td>
    <td width="70%"> 
    </td>
    </tr>
        <TR>
        <td  width="120">Provincia</td>
		<td >
			<input type="text" id="id_provincia" name="id_provincia" value='<?php echo $provincia ?>' size="10" maxlength="4" onKeyUp="CodigoToSelect(document.getElementById('id_provincia').value,document.getElementById('des_provincia'))" onKeyPress="enter2tab(event,'id_canton',0); return solo_numeros(event);" onBlur="busca_cantones();"/>
			<select id="des_provincia" name="des_provincia" onChange="document.getElementById('id_provincia').value=document.getElementById('des_provincia').options[document.getElementById('des_provincia').selectedIndex].value; busca_cantones();">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from provincias where sta_provincia='A' order by id_provincia");
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["id_provincia"] == $provincia)
					{
						echo "<option value=\"".$registro["id_provincia"]."\" selected=selected>".$registro["id_provincia"]." - ".utf8($registro["des_provincia"])."</option>";
					}
					else
					{
						echo "<option value=\"".$registro["id_provincia"]."\">".$registro["id_provincia"]." - ".utf8($registro["des_provincia"])."</option>";
					}
				}
				?>
			</select><font color="#CC0000"> <i> (*) </font></i> 
        </td>
        </TR>
        <TR>
        <td  width="120">Cantón</td>
        <td >
			<div id="busca_cantones_div"><input type="text" id="id_canton" name="id_canton" value='<?php echo $canton ?>' size="10" maxlength="4" onKeyUp="CodigoToSelect(document.getElementById('id_canton').value,document.getElementById('des_canton'));" onKeyPress="enter2tab(event,'id_parroquia',0); return solo_numeros(event);" />
			<select id="des_canton" name="des_canton"  onChange="document.getElementById('id_canton').value=document.getElementById('des_canton').options[document.getElementById('des_canton').selectedIndex].value; busca_parroquias();">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from cantones where id_provincia = '".$provincia."' and sta_canton='A' order by id_provincia");
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["id_canton"] == $canton)
					{
						echo "<option value=\"".$registro["id_canton"]."\" selected=selected>".$registro["id_canton"]." - ".utf8($registro["des_canton"])."</option>";
					}
					else
					{
						echo "<option value=\"".$registro["id_canton"]."\">".$registro["id_canton"]." - ".utf8($registro["des_canton"])."</option>";
					}
				}
				?>
			</select><font color="#CC0000"> <i> (*) </font></i> 
            </div>
		</td>
        </TR>
        <TR>
        <TR>
        <td  width="120">Parroquia</td>
		<td >
			<div id="busca_parroquias_div"><input type="text" id="id_parroquia" name="id_parroquia" value='<?php echo $parroquia ?>' size="10" maxlength="4" onKeyUp="CodigoToSelect(document.getElementById('id_parroquia').value,document.getElementById('des_parroquia'))" onKeyPress="enter2tab(event,'dircliente',0); return solo_numeros(event);" />
			<select id="des_parroquia" name="des_parroquia"  onChange="document.getElementById('id_parroquia').value=document.getElementById('des_parroquia').options[document.getElementById('des_parroquia').selectedIndex].value;">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from parroquias where id_provincia = '".$provincia."' and id_canton='".$canton."' and sta_parroquia='A' order by id_provincia");
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["id_parroquia"] == $canton)
					{
						echo "<option value=\"".$registro["id_parroquia"]."\" selected=selected>".$registro["id_parroquia"]." - ".utf8($registro["des_parroquia"])."</option>";
					}
					else
					{
						echo "<option value=\"".$registro["id_parroquia"]."\">".$registro["id_parroquia"]." - ".utf8($registro["des_parroquia"])."</option>";
					}
				}
				?>
			</select><font color="#CC0000"> <i> (*) </font></i> 
            </div>
		</td>
        </TR>
		</td>
        </TR>
        <TR>
        <tr>
		<td>Dirección</td>
		<td><input type='text' style="width:300px;" value='<?php echo $direccion ?>' name='dircliente' id='dircliente' maxlength='200' onKeyPress="enter2tab(event,'celcliente',0);"  /></td><td><font color="#CC0000"> <i> (*) </font></i> </td>
	</tr>
	<tr>
		<td>Teléfono</td>
		<td><input type='text'  style="width:300px;" value='<?php echo $telefono ?>' name='celcliente' id='celcliente' maxlength='15' onKeyPress="enter2tab(event,'emailcliente',0);" /></td><td><font color="#CC0000"> <i> (*) </font></i> </td>
    </tr>
  	<tr>
		<td>E-Mail</td>
		<td><input type="text" id="emailcliente" name="emailcliente" style="width:300px;" value='<?php echo $email ?>' maxlength="50" onKeyPress="enter2tab(event,'des_tip_contribuyente',0);" required /> </td>
	</tr>
	<tr>
    <td>Tipo de Contribuyente</td>
		<td><input type="hidden" name="id_tip_contribuyente" id="id_tip_contribuyente"  maxlength="4" size="3" style="text-align:left; font-size: 16; " value='<?php echo $id_tip_contribuyente ?>' onKeyUp="CodigoToSelect(document.getElementById('id_tip_contribuyente').value,document.getElementById('des_tip_contribuyente'));" lang="s"/>
<select id="des_tip_contribuyente" name="des_tip_contribuyente"  onChange="document.getElementById('id_tip_contribuyente').value=document.getElementById('des_tip_contribuyente').options[document.getElementById('des_tip_contribuyente').selectedIndex].value;">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from tipos_contribuyentes where sta_tip_contribuyente='A' order by id_tip_contribuyente");
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["id_tip_contribuyente"] == $id_tip_contribuyente)
					{
						echo "<option value=\"".$registro["id_tip_contribuyente"]."\" selected=selected>".$registro["id_tip_contribuyente"]." - ".utf8($registro["des_tip_contribuyente"])."</option>";
					}
					else
					{
						echo "<option value=\"".$registro["id_tip_contribuyente"]."\">".$registro["id_tip_contribuyente"]." - ".utf8($registro["des_tip_contribuyente"])."</option>";
					}
				}
				?> 

</td><td><font color="#CC0000"> <i> (*) </font></i></td>
</tr>
<tr>
	<td>Días de Crédito</td>
	<td><input type='text' style="width:100px; text-align:right;" value='<?php if ($dias_credito=="") echo 0.00; else echo $dias_credito ?>' name='dias_credito' id='dias_credito' maxlength='200' onKeyPress="enter2tab(event,'lim_credito',0);MASK(event,this,this.value,'-###,###,##0',1);return solo_numeros(event);"  /> días</td>
    </td>
</tr>
<tr>
	<td>Límite de Crédito</td>
	<td><input type='text' style="width:100px; text-align:right;" value='<?php if ($lim_credito=="") echo 0.00; else echo $lim_credito ?>' name='lim_credito' id='lim_credito' maxlength='200' onKeyPress="enter2tab(event,'estacliente',0);MASK(event,this,this.value,'-###,###,##0.00',1);return solo_dinero(event);"  /> USD</td>
    </td>
</tr>
<tr>
		<td>Estatus</td>
		<td align="left">
			<input type="radio" id="estacliente" name="estacliente" value="A" checked <?php if ($sta_cliente=="A") echo "checked"; ?>>Activo
			<input type="radio" id="estacliente" name="estacliente" value="I" <?php if ($sta_cliente=="I") echo "checked"; ?>>Inactivo
		</td>
	</tr>
    <tr>
    <td colspan="2" align="center"><font color="#CC0000"> <i> (*) Campos obligatorios</font></i> 
    </td>
    </tr>
</table>
 

<table width="100%" align="center" class="tbldatos1">
	<tr>
        <td colspan="5" align="center">
		   	<button type="button" id="par_cli_limpiar" name="par_cli_limpiar" title="Limpiar pantalla" onClick="par_cli_limpiar();" style="width:65px; height:50px;"><img src="css/imagenes/iconos/cancelar.png"></button>
           	<button type="button" id="par_cli_guarda" name="par_cli_guarda" onClick="par_cli_guardar();" title="Guardar cliente" style="width:65px; height:50px;"><img src="css/imagenes/iconos/guardar.png"></button>
       	</td>
	</tr>
</table>


<div id="guardar_cliente"></div>
</html>