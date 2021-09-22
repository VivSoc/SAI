<?php 
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../clases/utilidades.class.php");
require("../../../sesion.php");
$codigo=$_SESSION['codofi'];
?>
<script type="text/javascript" src="javascript/general/general.js"> </script>
<script type="text/javascript" src="javascript/recaudacion/cortes.js"> </script>
<script type"text/javascript" src="javascript/utilidades.js"> </script>


<h3>Reporte de clientes con correo electr&oacute;nico cuenta y telefono por oficina</h3>
<table class="tbldatos1" width="700" align="center">
   
 
 
   <tr>
		<td>Oficina Comercial: 
    </td>
    <td><input type="text" name="correo_oficina" id="correo_oficina" maxlength="3" size="3" onkeyup="CodigoToSelect(document.getElementById('correo_oficina').value,document.getElementById('nombre_correo_oficina'))" onkeypress="enter2tab(event,'libro_a',0);" />
<?php   
$accion="onchange=document.getElementById('correo_oficina').value=document.getElementById('nombre_correo_oficina').options[document.getElementById('nombre_correo_oficina').selectedIndex].value;cambiar_rutas_correo(1);";

      $objUtilidades=new utilidades;
      $objUtilidades->seleccionarCombo("select codofi, nomofi from paroficom order by codofi ","nombre_correo_oficina",$accion,'',$readonly='',$retornar=0);?>
	</td>
            
         
	</tr>
  
    <tr>
   <td>Ruta Desde:</td>
   <td>
		<input type="text" name="ruta_desde_correo" id="ruta_desde_correo" maxlength="9" size="9"  onblur="CodigoToSelect(document.getElementById('ruta_desde_correo').value,document.getElementById('nombre_ruta_desde_correo'))" onkeypress="enter2tab(event,'ruta_hasta_correo',0);">
	<div id="div_desde_correo" style="display:inline;"></div>  
	</td>
</tr>
<tr>
   <td>Ruta Hasta:</td>
   <td>
		<input type="text" name="ruta_hasta_correo" id="ruta_hasta_correo" maxlength="9" size="9"  onblur="CodigoToSelect(document.getElementById('ruta_hasta_correo').value,document.getElementById('nombre_ruta_hasta_correo'))" onkeypress="enter2tab(event,'mens_fac1',0);">
		<div id="div_hasta_correo" style="display:inline;"></div>  
 </td>
 </tr>
     
    <tr>
    	 <td width="100">Estatus de Celular:</td>
          <TD width="400"  align="left">
          		<input type="checkbox" name="concelu" id="concelu"> Con Celular <input type="checkbox" name="sincelu" id="sincelu"> Sin Celular 
          </TD>

        </tr>
   <tr>

    	 <td width="100">Estatus de Correo:</td>
          <TD width="400"  align="left">
          		<input type="checkbox" name="concorreo" id="concorreo"> Con Correo <input type="checkbox" name="sincorreo" id="sincorreo"> Sin Correo
          </TD>

        </tr>

  </table>
<table class="tbldatos1" width="700" align="center">
    <tr>
    	<td colspan="2" align="center">
        	<button type="button" id="lis_correo" name="lis_correo" onclick="listado_correo_telefono();" style="width:30px; height:25px;"><img src="css/imagenes/imprimir.png"></button>
        </td>
    </tr>
</table>
</div>