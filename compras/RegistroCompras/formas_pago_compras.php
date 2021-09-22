<link rel="stylesheet" href="<?php echo $sis_estilo; ?>" type="text/css">

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.1.custom.min.js"></script>
		<script type="text/javascript" src="js/javascript.js"></script>
        <script type="text/javascript" src="javascript/compras/compras.js"></script>
		<script type="text/javascript" src="javascript/sweetalert.min.js"></script>
<?php 
session_start();
require_once("../../../configuracion/config.php");
require_once("../../../configuracion/conexion.php");
require_once("../../../clases/utilidades.class.php");
require_once("../../../clases/funciones.php");
$objUtilidades=new utilidades;
?>
<table  width="100%" align="center" class='tbldatos1'> 
	<tr>
		<td width="30%" align="center" class="fondo_fila_amarilla">Formas de Pago</td>
		<td width="20%" align="center" class="fondo_fila_amarilla">Monto del Pago</td>
		<td width="30%" align="center" class="fondo_fila_amarilla">Banco</td>
		<td width="20%" align="center" class="fondo_fila_amarilla">Nº Operación</td>
   </tr>   
<?php 
$idpago=@$_REQUEST['codigo'];
if($idpago!='9999')
	$tmp="select * from formas_pago where sta_for_pago='A' and id_for_pago='".$idpago."' and id_for_pago<>'9999' order by id_for_pago";
else	
	$tmp="select * from formas_pago where sta_for_pago='A' and id_for_pago<>'9999' order by id_for_pago";
$result=pg_query($tmp);
$fila=0;
$objUtilidades=new utilidades;
$pagos=pg_num_rows($result);

echo "<script>document.getElementById('pagos').value='".$pagos."';</script>";
while(($datos=pg_fetch_assoc($result))>0)
//escapar comillas: &#39
{
	$fila+=1;
	echo "<tr> <input type='hidden' id='id_pago".$fila."' value='".$datos['id_for_pago']."'>
			<td width='30%' align='left' >".$datos['des_for_pago']."</td>
			<td width='20%' align='right' ><input type='txt' id='monto_pago".$fila."' size='15' value=0.00  style='text-align:right; font-size:20;' onkeypress='enter2tab(event,&#39;num_pago".$fila."&#39;,0);MASK(event,this,this.value,&#39-###,###,##0.00&#39,1);return solo_dinero(event);'</td>
			
		<td width='30%' align='left'><input type='hidden' id='id_banco".$fila."' onblur='CodigoToSelect(document.getElementById(&#39;id_banco$fila&#39;).value,document.getElementById(&#39;desbanco&#39;));'>";
			$accion="onchange=document.getElementById('id_banco".$fila."').value=document.getElementById('desbanco".$fila."').options[document.getElementById('desbanco".$fila."').selectedIndex].value;"; 
		$objUtilidades->seleccionarCombo("Select id_banco,des_banco From bancos where sta_banco='A' and id_banco<>'9999'","desbanco$fila",$accion,$desbanco,$readonly='',$retornar=0); 
	 echo "</td><td width='20%' align='center' ><input type='txt' id='num_pago".$fila."' size='15'></td>
</tr>";
	
	
}?>
</table>

<?php
	
