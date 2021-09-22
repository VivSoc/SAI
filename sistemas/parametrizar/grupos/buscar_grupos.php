<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
$grupo=$_REQUEST['id_grupo'];
$sql="select * from grupos where grupo = '".@$grupo."'";
$result10=pg_query($bd_conexion,$sql);
$datos=pg_fetch_assoc($result10);
?>

<tr>
			<td width="80">Descripci&oacute;n</td>
			<td>
				<input type="text" id="id_descripcion" name="id_descripcion" maxlength="100" style="width:550px;" onkeypress="enter2tab(event,'encargado',0);"  value="<?php echo $datos['descrip'] ?>"/>
			</td>
		</tr>
        
        <tr>
			<td width="80">Encargado:</td>
			<td>
				<input type="text" id="encargado" name="encargado" maxlength="100" style="width:550px;" onkeypress="enter2tab(event,'cargo',0);" value="<?php echo $datos['encargado'] ?>" />
			</td>
		</tr>
        
        <tr>
			<td width="80">Cargo:</td>
			<td>
				<input type="text" id="cargo" name="cargo" maxlength="100" style="width:550px;" onkeypress="enter2tab(event,'id_guardar',0);" value="<?php echo $datos['cargo'] ?>" />
			</td>
		</tr>

