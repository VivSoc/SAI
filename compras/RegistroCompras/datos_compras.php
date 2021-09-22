<link rel="stylesheet" href="css/sweetalert.css" type="text/css">
<link rel="stylesheet" href="css/autocompletar.css" type="text/css">

<script type="text/javascript" src="javascript/compras/compras.js"></script>
<script type="text/javascript" src="js/javascript.js"></script>
<script type="text/javascript">document.getElementById('numdoc').focus()</script>
<?php 
session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require_once("../../../clases/utilidades.class.php");

$sql = "SELECT * FROM clientes_proveedores where id_cli_pro = '".@$_REQUEST['id_proveedor']."' and estatus='A'";
$result = pg_query($bd_conexion,$sql);
if (pg_num_rows($result)<=0)
{
	echo"<script language='javascript'>
	swal('Proveedor está Inactivo o no está Registrado', 'Por favor verifique los datos', 'warning');
	document.getElementById('id_proveedor').focus()
	</script>";
	return;
}
?>

<div id='cuerpo_datos_compra'>
        <input type="hidden" id="pagos" value=0/>
<table  width="100%" align="center" class='tbldatos1' >
	<tr>
		<td >Razón Social</td>
		<td><input type='text' style="width:200px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"nombre")); ?>' name='razonproveedor' id='razonproveedor' maxlength='30'  readonly/>
		<td >Dirección</td>
		<td><input type='text' style="width:400px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"direccion")); ?>' name='dirproveedor' id='dirproveedor' maxlength='50' readonly  /></td>  
	</tr>
</table>
<table  width="100%" align="center" class='tbldatos1'>    
	<tr>
		<td colspan="6" align="center" class="fondo_fila_amarilla">Datos de la Compra</td>
	</tr>  
	<tr>
    	<td>Tipo Documento:</td>
        <td>  
        <input type="hidden" name="comptipdoc" id="comptipdoc"  maxlength="4" size="3" style="text-align:left; font-size: 16; "  onblur="CodigoToSelect(document.getElementById('comptipdoc').value,document.getElementById('compdestip'));" onkeypress="enter2tab(event,'parcodmodelo',0);" lang="s"/>
<?php
	$accion="onchange=document.getElementById('comptipdoc').value=document.getElementById('compdestip').options[document.getElementById('compdestip').selectedIndex].value;";
	$objUtilidades=new utilidades;
    $objUtilidades->seleccionarCombo("Select id_tip_documento,des_tip_documento From tipos_documentos where sta_tip_documento='A'","compdestip",$accion,$tipodocumento,$readonly='',$retornar=0);    
?>	</td>                  
        </td>
        <td>Número Documento:</td>
        <td><input type="text" id="numdoc" name="numdoc" maxlength="30" size="10"  onKeypress="enter2tab(event,'fecdoc',0);" autocomplete="on"/></td>
        <td>Fecha Documento:</td>
        <td><input type="text" id="fecdoc" name="fecdoc" maxlength="10" size="10"  value="<?php echo date('d/m/Y');?>" onKeypress="enter2tab(event,'tipocompra',0);" autocomplete="off"  />
        <input type="hidden" id="fecregcom" name="fecregcom" maxlength="10" size="10"  value="<?php echo date('d/m/Y');?>" onKeypress="enter2tab(event,'tipocompra',0);" autocomplete="off"  /></td>
	</tr>
    <tr>
    	<td>Tipo de Compra:</td>
        <td>  
			</select>
			<select id="tipocompra" name="tipocompra" onchange="activar_fecha_credito();" style="height:20px; width:100%">    
				<option value="Contado"  >Contado</option>    
				<option value="Credito" >Crédito</option>                       
			</select>
			
        </td>
        <td>Fecha Vencimiento:</td>
        <td><input type="text" id="fechaven" name="fechaven" maxlength="10" size="10" value="<?php echo date('d/m/Y');?>" disabled="disabled"  onKeypress="enter2tab(event,'forpago',0);"   /></td>
        <td>Forma de Pago:</td>
        <td><input type="hidden" name="compidforpag" id="compidforpag"  maxlength="4" size="3" style="text-align:left; font-size: 16; "  onblur="CodigoToSelect(document.getElementById('compidforpag').value,document.getElementById('compdesforpag'));" onkeypress="enter2tab(event,'parcodmodelo',0);" lang="s"/>
<?php
	$accion="onchange=document.getElementById('compidforpag').value=document.getElementById('compdesforpag').options[document.getElementById('compdesforpag').selectedIndex].value;mostrar_forpagos();";
	$objUtilidades=new utilidades;
    $objUtilidades->seleccionarCombo("Select id_for_pago,des_for_pago From formas_pago where sta_for_pago='A'","compdesforpag",$accion,$tipoforma,$readonly='',$retornar=0);    
?>	</td>   
	</tr>
    </table>
</div>
<div id='cuerpo_datos_pagos' style='display: none;'></div>
<table height="30%" width="100%" align="center" class="tbldatos1"> 
<tr>
		<td   align="left">Producto</td>
		<td  ><div class="input_container">
        	<input type="text" name="codprocompra" id="codprocompra"  maxlength="30" size="15" style="text-align:left; font-size: 20; " value="" onkeyup="javascript:this.value=this.value.toUpperCase();autocompletar();" onkeypress="enter2tab(event,'preprocompra',0);buscar_precio_compra(event);" lang="s"/>
            <ul id="lista_id"></ul>
    </div></td>
            <td>
            <input type="text" name="desprocompra" id="desprocompra"  maxlength="200" size="100" style="text-align:left; font-size: 11px;" readonly="readonly"  lang="s"/>
            <td>
            
            <input type="text" name="sta_pro" id="sta_pro"  maxlength="8" size="10" style="text-align:left; background:none; border:hidden; font-size: 14px; font-weight: bold;" readonly="readonly"  lang="s"/>

		</td> 
        
  </tr>
</table>
    <table width="100%" align="center" class="tbldatos1"> 
    <tr>
    <td >Tipo de Producto</td>
		<td colspan="3" ><input type="text" name="tippro" id="tippro"   maxlength="30" size="40" style="text-align:left; border:hidden; font-size: 40;" readonly="readonly"  lang="s"/></td>
		
        
		<td >% Descuento Máx.</td>
		<td ><input type="text" name="dsctomax" id="dsctomax"    size="10" style="text-align:right; border:hidden; font-size: 40;" readonly="readonly"  lang="s"/></td>
		<td >Stock Mínimo</td>
		<td ><input type="text" name="minimo" id="minimo"    size="10" style="text-align:right; border:hidden; font-size: 40;" readonly="readonly"  lang="s"/></td>
		<td >Stock Máximo</td>
		<td ><input type="text" name="maximo" id="maximo"    size="10" style="text-align:right; border:hidden; font-size: 40;" readonly="readonly"  lang="s"/></td>
        </tr>
        <tr>
		<td >Monto I.V.A.</td>
		<td ><input type="text" name="iva" id="iva"   size="10" style="text-align:right; border:hidden; font-size: 40;" readonly="readonly"  lang="s"/></td>
		<td >P.V.P. Detal Actual</td>
		<td ><input type='text' name='preproducto' id='preproducto' maxlength='50' size="8" style="text-align:right; font-size: 20;border:hidden; " readonly="readonly"  value='0.00'/></td>  
		<td >P.V.P. Mayor Actual</td>
		<td ><input type='text' name='prepromay' id='prepromay' maxlength='50' size="8" style="text-align:right; font-size: 20;border:hidden; " readonly="readonly"  value='0.00'/></td>  
		<td >Cant. Actual</td>
		<td ><input type='text' name='candisproducto' id='candisproducto' maxlength='50' style="width:80px;text-align:right;font-size: 20;border:hidden; " readonly="readonly" /></td>
		<td ><input type='text' name='unidadproact' id='unidadproact' maxlength='15' readonly="readonly" style="width:40px;text-align:right;font-size: 20;border:hidden; " /></td>  
          
    </tr>
	<tr>
	    <td >Costo</td>
		<td><input type='text' name='preprocompra' id='preprocompra' maxlength='50' size="8" value='0.00' style="text-align:right; font-size:20; "onkeypress="enter2tab(event,'compnumlote',0);MASK(event,this,this.value,'-###,###,##0.00',1);return solo_dinero(event);" /> </td>
		<td >N. Lote</td>
   		<td><input type='text' name='compnumlote' id='compnumlote' maxlength='50' size="8"  style="text-align:right; font-size:20; "onkeypress="enter2tab(event,'compfeclote',0);" /> </td>

		<td >Fecha Caducidad</td>
        <td><input type="text" id="compfeclote" name="compfeclote" maxlength="10" size="10" onclick="enter2tab(event,'unidadpronew',0);" value="<?php echo date('d/m/Y');?>"/></td>
		<td >Cantidad</td>
		<td><input type='number' style="width:80px; text-align:right; font-size: 20; " name='canprocompra' id='canprocompra' onkeypress="enter2tab(event,'preprovendet',0); return solo_dinero(event);"/></td>  
		<td><input type='text' name='unidadpronew' id='unidadpronew' disabled="disabled" maxlength='15' readonly style="width:40px;text-align:right;font-size: 20; " /></td>  		
    <td >P.V.P. Detal Nuevo</td>		
    <td><input type='text' name='preprovendet' id='preprovendet' maxlength='15' size="8" value="0.00"style="text-align:right;font-size: 20;" onkeypress="enter2tab(event,'preprovenmay',0);MASK(event,this,this.value,'-###,###,##0.00',1); return solo_dinero(event);" /> </td> 
    <td>P.V.P. Mayor Nuevo</td>		
    <td><input type='text' name='preprovenmay' id='preprovenmay' maxlength='15' size="8" value="0.00"style="text-align:right;font-size: 20;" onkeypress="enter2tab(event,'agrega_producto',0);MASK(event,this,this.value,'-###,###,##0.00',1); return solo_dinero(event);"  /> </td> 
    <td align="center"><button id="agrega_producto" onClick="agregar_producto_compra();" border=0 style="width:55px;height:50px;border-radius: 12px;" title="Agregar Producto"><img src="css/imagenes/iconos/add-pedido.png"/></button></td>
    </tr>
 </table>
</div>
