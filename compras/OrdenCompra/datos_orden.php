<link rel="stylesheet" href="css/sweetalert.css" type="text/css">
<link rel="stylesheet" href="css/autocompletar.css" type="text/css">

<script type="text/javascript" src="javascript/compras/ordenescompras.js"></script>
<script type="text/javascript" src="js/javascript.js"></script>
<script type="text/javascript">document.getElementById('codpro_odc').focus()</script>
<?php 
session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require_once("../../../clases/utilidades.class.php");

$sql = "SELECT * FROM clientes_proveedores where id_cli_pro = '".@$_REQUEST['id_proveedor_odc']."' and estatus='A'";
$result = pg_query($bd_conexion,$sql);
if (pg_num_rows($result)<=0)
{
	echo"<script language='javascript'>
	swal('Proveedor está Inactivo o no está Registrado', 'Por favor verifique los datos', 'warning');
	document.getElementById('id_proveedor').focus()
	</script>";
	return;
}
$id_orden=generar_id_compra('ordenes_compra','id_orden','ORDE');

?>

<div id='cuerpo_datos_compra'>
<table  width="100%" align="center" class='tbldatos1' >
	<tr>
		<td >Razón Social</td>
		<td><input type='text' style="width:200px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"nombre")); ?>' name='razonproveedor_odc' id='razonproveedor_odc' maxlength='30'  readonly/>
		<td >Dirección</td>
		<td><input type='text' style="width:400px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"direccion")); ?>' name='dirproveedor_odc' id='dirproveedor_odc' maxlength='50' readonly  /></td>  
	</tr>
</table>
<table  width="100%" align="center" class='tbldatos1'>    
	<tr>
		<td colspan="6" align="center" class="fondo_fila_amarilla">Datos de la Orden de Compra</td>
	</tr>  
	<tr>
    	<td>Tipo Documento:</td>
        <td>  
        <input type="hidden" name="tipdoc_odc" id="tipdoc_odc"  maxlength="4" size="3" style="text-align:left; font-size: 16; "  onblur="CodigoToSelect(document.getElementById('comptipdoc').value,document.getElementById('compdestip'));" onkeypress="enter2tab(event,'numdoc_odc',0);" lang="s"/>Orden de Compra</td>                  
        </td>
        <td>Número Orden:</td>
        <td><input type="text" id="numdoc_odc" name="numdoc_odc" maxlength="12" size="10" value="<?php echo $id_orden;?>" readonly="readonly"  onKeypress="enter2tab(event,'fecdoc_odc',0);" autocomplete="on"/></td>
        <td>Fecha Orden:</td>
        <td><input type="text" id="fecdoc_odc" name="fecdoc_odc" maxlength="10" size="10"  value="<?php echo date('d/m/Y');?>" onKeypress="enter2tab(event,'tipocompra',0);" autocomplete="off"  />
        <input type="hidden" id="fecregcom" name="fecregcom" maxlength="10" size="10"  value="<?php echo date('d/m/Y');?>" onKeypress="enter2tab(event,'tipocompra',0);" autocomplete="off"  /></td>
	</tr>
    </table>
</div>
<table height="30%" width="100%" align="center" class="tbldatos1"> 
<tr>
		<td   align="left">Producto</td>
		<td  ><div class="input_container">
        	<input type="hidden" name="codalt_odc" id="codalt_odc"/>
        	<input type="text" name="codpro_odc" id="codpro_odc"  maxlength="10" size="15" style="text-align:left; font-size: 20; " value="" onkeyup="javascript:this.value=this.value.toUpperCase();autocompletar_odc();" onkeypress="enter2tab(event,'canpro_odc',0);buscar_precio_orden(event);" lang="s"/>
            <ul id="lista_id"></ul>
    </div></td>
            <td>
            <input type="text" name="despro_odc" id="despro_odc"  maxlength="200" size="80" style="text-align:left; font-size: 11px;" readonly="readonly"  lang="s"/>
            <td>
            
            <input type="text" name="sta_pro_odc" id="sta_pro_odc"  maxlength="8" size="10" style="text-align:left; background:none; border:hidden; font-size: 14px; font-weight: bold;" readonly="readonly"  lang="s"/>
			

		</td> 
        <td >Tipo de Producto</td>
		<td colspan="2" ><input type="text" name="tippro_odc" id="tippro_odc"   maxlength="30" size="40" style="text-align:left; border:hidden; font-size: 40;" readonly="readonly"  lang="s"/></td>
  </tr>
</table>
    <table  width="100%" align="center" class='tbldatos1'> 
    <tr>
		
        
		<td >% Descuento Máx.</td>
		<td ><input type="text" name="dsctomax_odc" id="dsctomax_odc"    size="10" style="text-align:right; border:hidden; font-size: 40;" readonly="readonly"  lang="s"/></td>
		<td >Stock Mínimo</td>
		<td ><input type="text" name="minimo_odc" id="minimo_odc"    size="10" style="text-align:right; border:hidden; font-size: 40;" readonly="readonly"  lang="s"/></td>
		<td >Stock Máximo</td>
		<td ><input type="text" name="maximo_odc" id="maximo_odc"    size="10" style="text-align:right; border:hidden; font-size: 40;" readonly="readonly"  lang="s"/></td>
		<td >Monto I.V.A.</td>
		<td ><input type="text" name="ivapro_odc" id="ivapro_odc"   size="10" style="text-align:right; border:hidden; font-size: 40;" readonly="readonly"  lang="s"/></td>
        </tr>
        <tr>    
		<td >P.V.P. Detal</td>
		<td ><input type='text' name='preprodet_odc' id='preprodet_odc' maxlength='8' size="8" style="text-align:right; font-size: 20;border:hidden; " readonly="readonly"  value='0.00'/></td>  
		<td >P.V.P. Mayor</td>
		<td ><input type='text' name='prepromay_odc' id='prepromay_odc' maxlength='8' size="8" style="text-align:right; font-size: 20;border:hidden; " readonly="readonly"  value='0.00'/></td>  
		<td >Cant. Actual</td>
		<td ><input type='text' name='candispro_odc' id='candispro_odc' maxlength='8' style="width:80px;text-align:right;font-size: 20;border:hidden; " readonly="readonly" /></td>
		<td ><input type='text' name='unidadpro_odc' id='unidadpro_odc' maxlength='15' readonly="readonly" style="width:40px;text-align:right;font-size: 20;border:hidden; " /></td>  
		<td >Cantidad</td>
		<td><input type='number' style="width:80px; text-align:right; font-size: 20; " name='canpro_odc' id='canpro_odc' onkeypress="enter2tab(event,'agrega_producto_odc',0);"/></td>  
		<td><input type='text' name='undpronew_odc' id='undpronew_odc' disabled="disabled" maxlength='15' readonly style="width:40px;text-align:right;font-size: 20; " /></td>  
     
    
    <td align="center"><button id="agrega_producto_odc" onClick="agregar_producto_odc();" border=0 style="width:55px;height:45px;border-radius: 12px;" title="Agregar Producto"><img src="css/imagenes/iconos/add-pedido.png"/></button></td>
    </tr>
 </table>
</div>
