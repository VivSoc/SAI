<?php

require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require("../../clases/utilidades.class.php");
require("../../sesion.php");
?>
<script type="text/javascript" src="javascript/usuarios/javascript.js"> </script>
<div id="usuarios_creacion"> <!-- DIV 1 -->



<table width="95%" align="center" class="tbldatos1">
    <tr height="30px">
      <td  align="center" colspan="4" class="fondo_fila_amarilla" >REPORTE  PERMISOLOG&Iacute;A DE USUARIOS</td>
   </tr>
   
  
    
 <tr>

    <TD width="20%">Cedula Usuario:</TD>
         <TD  colspan="3"><input type="text" name="nom_usu" id="nom_usu" maxlength="15" size="15" onblur="CodigoToSelect(document.getElementById('nom_usu').value,document.getElementById('nombre_usuario'))" onkeypress="enter2tab(event,'boton',0);" />
         <?php   


$accion="onchange=document.getElementById('nom_usu').value=document.getElementById('nombre_usuario').options[document.getElementById('nombre_usuario').selectedIndex].value;";

      $objUtilidades=new utilidades;
      $objUtilidades->seleccionarCombo("select cedusu,nomusu from pardefusu order by nomusu ","nombre_usuario",$accion,'',$readonly='',$retornar=0);


?>	
</tr>	
</td>

<table width="95%" align="center"  class="tbldatos1" >
	<tr>
		<td  colspan="4" align="left" >   
    <input type="checkbox" id="todas" name="todas" ><b>Todos Los Usuarios</b>
		</td> 
        
                
	</tr>


<tr height="30px">
      <td colspan="4" align="center" class="fondo_fila_amarilla"><input type="button" onclick="reporte_permisos_usuarios()" name="boton" id="boton" value="Imprimir"></td>
   </tr>
</table>



</div> <!-- FIN DIV liquidar -->
