$(function() 
{
	$.datepicker.setDefaults($.datepicker.regional['']);
	$("#gen_fecha_desde_fmc").datepicker($.datepicker.regional['es']);
	$("#gen_fecha_hasta_fmc").datepicker($.datepicker.regional['es']);
	$("#gen_fecha_desde_fmp").datepicker($.datepicker.regional['es']);
	$("#gen_fecha_hasta_fmp").datepicker($.datepicker.regional['es']);
});

function reporte_movimiento_cuenta()
{
var pagina;
pagina="vistas/general/reportes/reporte_movimiento_cuenta.php";
pagina+="?fecha_desde="+$("#gen_fecha_desde_fmc").val();
pagina+= "&fecha_hasta=" + $("#gen_fecha_hasta_fmc").val();
pagina+="&cuenta="+$("#gen_numcta_fmc").val();
window.open(pagina);
}

function reporte_movimiento_tipo()
{
var pagina;
pagina="vistas/general/reportes/reporte_movimiento_parametros.php";
pagina+="?fecha_desde="+$("#gen_fecha_desde_fmp").val();
pagina+= "&fecha_hasta=" + $("#gen_fecha_hasta_fmp").val();
pagina+="&tipo_desde="+$("#gen_tipodes").val();
pagina+="&tipo_hasta="+$("#gen_tipohas").val();
pagina+="&oficina_desde="+$("#gen_codofi_desde").val();
pagina+="&nombreof_desde="+$("#gen_oficina_desde").val();
pagina+="&oficina_hasta="+$("#gen_codofi_hasta").val();
window.open(pagina);
}

function recarga_chekofi()
{
	if (document.getElementById('genchekofi').checked)
		document.getElementById('cedcta_oficina').disabled='disabled' 
	else
		document.getElementById('cedcta_oficina').disabled='' 
		
}

function listado_ctaced()
{
var pagina;
	
	if(document.getElementById("act_ced").checked==true)
	  activos=1
	else
	  activos=0
		
	if(document.getElementById("ina_ced").checked==true)
	  inactivos=1
	else
	  inactivos=0	
		
	if(document.getElementById("cor_ced").checked==true)
	  cortados=1
	else
	  cortados=0			

    if(document.getElementById("ret_ced").checked==true)
	  retirados=1
	else
	  retirados=0	
	
	
	if (document.getElementById('genchekofi').checked)
	{
		ofic="todas";
		pagina="vistas/general/reportes/reporte_cedula_cuenta.php";
		pagina+="?&oficina=" + ofic;
		pagina+="&activos="+activos;
		pagina+="&inactivos="+inactivos;
		pagina+="&cortados="+cortados;
		pagina+="&retirados="+retirados;	
	}
	else
	{
		
		ofic=document.getElementById('cedcta_oficina').value;
		pagina="vistas/general/reportes/reporte_cedula_cuenta.php";
		pagina+="?&oficina=" + ofic;
		pagina+="&activos="+activos;
		pagina+="&inactivos="+inactivos;
		pagina+="&cortados="+cortados;
		pagina+="&retirados="+retirados;	
		//alert ("este "+pagina);
	}
window.open(pagina);
}


function listado_correo_telefono()
{
	
var pagina;

concelu=document.getElementById("concelu").checked;
sincelu=document.getElementById("sincelu").checked;
concorreo=document.getElementById("concorreo").checked;
sincorreo=document.getElementById("sincorreo").checked;
pagina="vistas/general/reportes/listado_correo_telefono.php";
pagina+="?oficina="+$("#correo_oficina").val();
pagina+="&ruta_desde="+$("#ruta_desde_correo").val();
pagina+="&ruta_hasta="+$("#ruta_hasta_correo").val();     
pagina+="&concelu=" + concelu;
pagina+="&sincelu=" + sincelu;
pagina+="&concorreo=" + concorreo;
pagina+="&sincorreo=" + sincorreo;

window.open(pagina);
}

function cambiar_rutas_correo(accion)
{
	//alert("llerga aqio "+accion);
	switch(accion)
	{
	  case 1:
	  	document.getElementById("ruta_desde_correo").value="";
	  	document.getElementById("ruta_hasta_correo").value="";
	    respuesta='#div_desde_correo'
	    nombre_combo='nombre_ruta_desde_correo'
	    oficina=document.getElementById("correo_oficina").value	
	  break;	
		
	 case 2:
	  respuesta='#div_hasta_correo'
	  nombre_combo='nombre_ruta_hasta_correo'
	  oficina=document.getElementById("correo_oficina").value	  
	 break;
	}
		//alert("llerga aqio "+accion + " " +respuesta +" "+ nombre_combo+" "+oficina);
       $.post("vistas/general/reportes/combo_rutas_correo.php",
       {
       oficina: oficina,
	   nombre_combo:nombre_combo,
	   acc:accion
       },
       function(data){
	     $(respuesta).html(data);
		    if(accion==1)
		      cambiar_rutas_correo(2) 
         }
      );
}

function listado_cderradas()
{
	
var pagina;
	pagina="vistas/general/reportes/listado_cedula_errada.php";
	pagina+="?oficina="+$("#cede_codofi").val()+
	"&fcpf_personas="+document.getElementById('cede_reporte1').checked+
	"&fcpf_inquilinos="+document.getElementById('cede_reporte2').checked;
	window.open(pagina);
}
