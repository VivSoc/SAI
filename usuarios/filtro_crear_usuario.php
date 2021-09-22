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
      <td  align="center" colspan="2" class="fondo_fila_amarilla" >CREACI&Oacute;N DE USUARIOS</td>
   </tr>
   
   <TR height="30px" >
         <TD width="25%">Cédula del Usuario:</TD>
         <TD width="75%">  <input type="text" name="mod_usu_cedula" id="mod_usu_cedula" maxlength="15" size="15" onkeypress="enter2tab(event,'boton',0);"/>
           (Formato: A12345678) </TD>
    </TR>      
   
<TR height="30px" hidden="true">
         <TD width="25%">Empresa</TD>
         <TD>  <input type="text" name="mod_usu_sistema" id="mod_usu_sistema" maxlength="3" size="15" value="001">  
           <?php

$accion="onchange=document.getElementById('mod_usu_sistema').value=document.getElementById('mod_usu_nombre_sistema').options[document.getElementById('mod_usu_nombre_sistema').selectedIndex].value;";
      $objUtilidades=new utilidades;
      $objUtilidades->seleccionarCombo("select codofi,nomofi from paroficom order by codofi","mod_usu_nombre_sistema",$accion,'',$readonly='',$retornar=0);

      ?>         </TD>
      </TR>

<tr height="30px">
      <td colspan="2" align="center" class="fondo_fila_amarilla"><input type="button" onclick="submit_creacion_usuarios()" name="boton" id="boton" value="Verificar"></td>
   </tr>
</table>



</div> <!-- FIN DIV liquidar -->
