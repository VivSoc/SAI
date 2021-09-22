<script src="js/ui/jquery.ui.tabs.js" type="text/javascript"></script>
 
<script type="text/javascript">
	$(function() {
		$('#sol_container-4').tabs({ fxFade: false, fxSpeed: 'fast' });
    });
</script>

<link rel="stylesheet" href="css/jquery.tabs.css" type="text/css" media="print, projection, screen">

<div id="sol_container-4" style="width:850px;">
	<ul>
		<li><a href="#sol_datos_solicitud"><span>Datos de la Solicitud</span></a></li> 
		<li><a href="#sol_datos_presupuesto"><span>Datos del Presupuesto</span></a></li> 
	    <li><a href="#sol_ordenes"><span>Generar Ordenes de Trabajo</span></a></li>
        <li><a href="#sol_suscriptor"><span>Cliente/Suscriptor</span></a></li> 		
		<li><a href="#sol_inmueble"><span>Inmueble</span></a></li>       	
       	<li><a href="#sol_toma"><span>Toma</span></a></li>
		<li><a href="#sol_historial"><span>Historial de Servicios</span></a></li>
	</ul>	
	<div id="sol_datos_solicitud">
   		<?php require("../../../vistas/atencion_cliente/solicitud_de_servicios/datos_solicitud.php"); ?>
		<div id="sol_respuesta_solicitud"></div> 
	</div>   
	<div id="sol_datos_presupuesto">
   		<?php require("../../../vistas/atencion_cliente/solicitud_de_servicios/datos_presupuesto.php"); ?>
	</div>   
    <div id="sol_ordenes">
		<?php require("../../../vistas/atencion_cliente/solicitud_de_servicios/datos_orden.php"); ?>    
        	<div id="sol_respuesta_orden_otr"></div>   
    </div>		
	<div id="sol_suscriptor">
		<?php require("../../../modulos/general/gen_infcli/persona.php"); ?>      
    </div>		
	<div id="sol_inmueble">
		<?php require("../../../modulos/general/gen_infcli/inmueble.php"); ?>
	</div>	
	<div id="sol_toma">
		<?php require("../../../modulos/general/gen_infcli/toma.php"); ?>
	</div>            
   	<div id="sol_historial"> 
   		<?php require("../../../vistas/atencion_cliente/solicitud_de_servicios/historial_servicios.php"); ?>
	</div>						
</div>
