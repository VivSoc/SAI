<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
		<script type="text/javascript" src="js/modulos/sistemas/sis_creusu/sis_creusu.js"></script>
    </head>
<h3>Registro de Usuario</h3>
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="100">Documento del Usuario</td>
			<td>
				<input type="text" id="scu_cedusu" name="scu_cedusu" maxlength="15" size="20" onKeyup="document.getElementById('scu_cedusu').value=document.getElementById('scu_cedusu').value.toUpperCase();"  onKeypress="enter2tab(event,'scu_buscar',0);"   />
				<i>( Formato A12345678 )</i>
			</td>
			
			<td colspan="2" align="right">
				<button type="button" id="scu_buscar" name="scu_buscar" onclick="scu_cargarresponsable();" style="width:30px; height:25px;"><img src="css/imagenes/buscar.png"></button>
			</td>
		</tr>
	</table>

<br/>
<div id="cuerpo_sis_creusu"></div>
<div id="mensaje"></div>
</html>