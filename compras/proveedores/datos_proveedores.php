<?php 
session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require_once("../../../clases/utilidades.class.php");
echo"<script>document.getElementById('par_nomproveedor').focus()</script>";

//require("../../sesion.php");
$sql = "SELECT a.*, b.*, c.*, d.* FROM clientes_proveedores a, provincias b, cantones c, parroquias d where id_cli_pro = '".@$_REQUEST['par_id_proveedor']."' and d.id_parroquia=a.id_parroquia and d.id_provincia=a.id_provincia and d.id_canton=a.id_canton and d.id_provincia=b.id_provincia and d.id_canton=c.id_canton and c.id_provincia=a.id_provincia and b.id_provincia=a.id_provincia";

$result = pg_query($bd_conexion,$sql);
$nombre=pg_fetch_result($result,0,"nombre");
$direccion=pg_fetch_result($result,0,"direccion");
$telefono=pg_fetch_result($result,0,"telefono");
$contacto=pg_fetch_result($result,0,"contacto");
$tel_contacto=pg_fetch_result($result,0,"tel_contacto");
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
        <script type="text/javascript" src="javascript/compras/proveedores.js"> </script>
    </head>

<table  width="100%" align="center" class="tbldatos1">
	<tr>
		<td colspan="3" align="center" class="fondo_fila_amarilla";>Datos del Proveedor</td>
	</tr>
	<tr>
		<td width="15%">Nombre Proveedor</td>
		<td><input type='text' style="width:200px;" value='<?php echo $nombre ?>' name='par_nomproveedor' id='par_nomproveedor' maxlength='50' onKeyPress="enter2tab(event,'par_id_provincia',0);" onKeyUp="document.getElementById('par_nomproveedor').value=document.getElementById('par_nomproveedor').value.toUpperCase();"  /><font color="#CC0000"> <i> (*) </i></font> </td>
    <td width="70%"> 
    </td>
    </tr>
        <TR>
        <td  width="120">Provincia</td>
		<td >
			<input type="text" id="par_id_provincia" name="par_id_provincia" value='<?php echo $provincia ?>' size="10" maxlength="4" onKeyUp="CodigoToSelect(document.getElementById('par_id_provincia').value,document.getElementById('par_des_provincia'))" onKeyPress="enter2tab(event,'par_id_canton',0); return solo_numeros(event);" onBlur="par_busca_cantones_p();"/>
			<select id="par_des_provincia" name="par_des_provincia" onChange="document.getElementById('par_id_provincia').value=document.getElementById('par_des_provincia').options[document.getElementById('par_des_provincia').selectedIndex].value; par_busca_cantones_p();">
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
			</select><font color="#CC0000"> <i> (*) </i></font> 
        </td>
        </TR>
        <TR>
        <td  width="120">Cantón</td>
        <td >
			<div id="par_busca_cantones_div"><input type="text" id="par_id_canton" name="par_id_canton" value='<?php echo $canton ?>' size="10" maxlength="4" onKeyUp="CodigoToSelect(document.getElementById('par_id_canton').value,document.getElementById('par_des_canton'));" onKeyPress="enter2tab(event,'par_id_parroquia',0); return solo_numeros(event);" />
			<select id="par_des_canton" name="par_des_canton"  onChange="document.getElementById('par_id_canton').value=document.getElementById('par_des_canton').options[document.getElementById('par_des_canton').selectedIndex].value;par_ busca_parroquias_p();">
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
			</select><font color="#CC0000"> <i> (*) </i></font> 
            </div>
		</td>
        </TR>
        <TR>
        <TR>
        <td  width="120">Parroquia</td>
		<td >
			<div id="par_busca_parroquias_div"><input type="text" id="par_id_parroquia" name="par_id_parroquia" value='<?php echo $parroquia ?>' size="10" maxlength="4" onKeyUp="CodigoToSelect(document.getElementById('par_id_parroquia').value,document.getElementById('par_des_parroquia'))" onKeyPress="enter2tab(event,'par_dirproveedor',0); return solo_numeros(event);" />
			<select id="par_des_parroquia" name="par_des_parroquia"  onChange="document.getElementById('par_id_parroquia').value=document.getElementById('par_des_parroquia').options[document.getElementById('par_des_parroquia').selectedIndex].value;">
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
			</select><font color="#CC0000"> <i> (*) </i> </font>
            </div>
		</td>
        </TR>
		</td>
        </TR>
        <TR>
        <tr>
		<td>Dirección</td>
		<td><input type='text' style="width:300px;" value='<?php echo $direccion ?>' name='par_dirproveedor' id='par_dirproveedor' maxlength='200' onKeyPress="enter2tab(event,'par_celproveedor',0);"  /></td><td><font color="#CC0000"> <i> (*) </i></font> </td>
	</tr>
	<tr>
		<td>Teléfono</td>
		<td><input type='text' style="width:300px;" value='<?php echo $telefono ?>' name='par_celproveedor' id='par_celproveedor' maxlength='15' onKeyPress="enter2tab(event,'par_contacto',0);" /></td><td><font color="#CC0000"> <i> (*) </i></font> </td>
    </tr>
    <tr>
		<td>Teléfono de Contacto</td>
		<td><input type='text'  style="width:300px;" value='<?php echo $contacto ?>' name='par_contacto' id='par_contacto' maxlength='15' onKeyPress="enter2tab(event,'par_per_contacto',0);" /></td>
    </tr>
    <tr>
		<td>Persona de Contacto</td>
		<td><input type='text'  style="width:300px;" value='<?php echo $tel_contacto ?>' name='par_per_contacto' id='par_per_contacto' maxlength='15' onKeyPress="enter2tab(event,'par_emailproveedor',0);" /></td>
    </tr>
  	<tr>
		<td>E-Mail</td>
		<td><input type="text" id="par_emailproveedor" name="par_emailproveedor" style="width:300px;" value='<?php echo $email ?>' maxlength="50" onKeyPress="enter2tab(event,'par_des_tip_contribuyente',0);"  /> </td>
	</tr>
	<tr>
    <td>Tipo de Contribuyente</td>
		<td><input type="hidden" name="par_id_tip_contribuyente" id="par_id_tip_contribuyente"  maxlength="4" size="3" style="text-align:left; font-size: 16; " value='<?php echo $id_tip_contribuyente ?>' onKeyUp="CodigoToSelect(document.getElementById('par_id_tip_contribuyente').value,document.getElementById('par_des_tip_contribuyente'));" lang="s"/>
<select id="par_des_tip_contribuyente" name="par_des_tip_contribuyente"  onChange="document.getElementById('par_id_tip_contribuyente').value=document.getElementById('par_des_tip_contribuyente').options[document.getElementById('par_des_tip_contribuyente').selectedIndex].value;">
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
				</select>
</td><td><font color="#CC0000"> <i> (*) </i></font></td>
</tr>
<tr>
	<td>Días de Crédito</td>
	<td><input type='text' style="width:100px; text-align:right;" value='<?php if ($dias_credito=="") echo 0.00; else echo $dias_credito ?>' name='par_dias_credito' id='par_dias_credito' maxlength='200' onKeyPress="enter2tab(event,'par_lim_credito',0);MASK(event,this,this.value,'-###,###,##0',1);return solo_numeros(event);"  /> días</td>
    </td>
</tr>
<tr>
	<td>Límite de Crédito</td>
	<td><input type='text' style="width:100px; text-align:right;" value='<?php if ($lim_credito==0) echo 0.00; else echo $lim_credito ?>' name='par_lim_credito' id='par_lim_credito' maxlength='200' onKeyPress="enter2tab(event,'par_estaproveedor',0);MASK(event,this,this.value,'-###,###,##0.00',1);return solo_dinero(event);"  /> USD</td>
    </td>
</tr>
<tr>
		<td>Estatus</td>
		<td align="left">
			<input type="radio" id="par_estaproveedor" name="par_estaproveedor" value="A" checked <?php if ($sta_cliente=="A") echo "checked"; ?>>Activo
			<input type="radio" id="par_estaproveedor" name="par_estaproveedor" value="I" <?php if ($sta_cliente=="I") echo "checked"; ?>>Inactivo
		</td>
	</tr>
    <tr>
    <td colspan="2" align="center"><font color="#CC0000"> <i> (*) Campos obligatorios</i></font> 
    </td>
    </tr>
</table>
 

<table width="100%" align="center" class="tbldatos1">
	<tr>
        <td colspan="5" align="center">
		   	<button type="button" id="par_prov_limpiar" name="par_prov_limpiar" title="Limpiar pantalla" onClick="par_prov_limpiar();" style="width:65px; height:50px;"><img src="css/imagenes/iconos/cancelar.png"></button>
           	<button type="button" id="par_prov_guarda" name="par_prov_guarda" onClick="par_prov_guardar();" title="Guardar Proveedor" style="width:65px; height:50px;"><img src="css/imagenes/iconos/guardar.png"></button>
       	</td>
	</tr>
</table>


<div id="par_guardar_proveedor"></div>
</html>