// JavaScript Document
$(function() 
{
	$.datepicker.setDefaults($.datepicker.regional['']);
	$("#fecha_desde").datepicker($.datepicker.regional['es']);
});

$(document).ready(function() 
{
   	$("#fecha_desde").datepicker(
   	{
		dateFormat: 'dd/mm/yy',
		yearRange: '2005:2015',
		inline: false
	});
	
	$(':checkbox[readonly=readonly]').click(function(){
		return false;
	});
	
});

$(function() 
{
	$.datepicker.setDefaults($.datepicker.regional['']);
	$("#fecha_hasta").datepicker($.datepicker.regional['es']);
});

$(document).ready(function() 
{
   	$("#fecha_hasta").datepicker(
   	{
		dateFormat: 'dd/mm/yy',
		yearRange: '2005:2015',
		inline: false
	});
	
	
});

$(function() 
{
	$.datepicker.setDefaults($.datepicker.regional['']);
	$("#fecha_hasta2").datepicker($.datepicker.regional['es']);
});

$(document).ready(function() 
{
   	$("#fecha_hasta2").datepicker(
   	{
		dateFormat: 'dd/mm/yy',
		yearRange: '2005:2015',
		inline: false
	});
	
	$(':checkbox[readonly=readonly]').click(function(){
		return false;
	});
	
});



function validar_rangos(rango1,rango2,nombre_rango)
{  
	
   if(document.getElementById(rango1).value!="" && 
      document.getElementById(rango2).value=="")
     {
        alert("Debe llenar el rango de "+ nombre_rango +" completamente")
        return 0	
     }

      if(document.getElementById(rango1).value=="" && 
	     document.getElementById(rango2).value!="")
      {
        alert("Debe llenar "+ nombre_rango +" completamente")
        return 0	
      }
	return 1
}

function validar_datos(input1,table,campo_1,campo_2,input2,val_cond2,descripcion)
{               //'ciclo_lectura','lymdefcic','codcic','descic','oficom','oficina','nombre_ciclo_lectura'
                //'ciclo_lectura','paroficom','codofi','nomofi','','','nombre_ciclo_lectura'
				//'fil_emi_ofi','facemisio','codemi','desemi','','','fil_emi_ofi_nom'

valor="#"+input1;
if(val_cond2!="")
condi2="#"+val_cond2;
else
condi2="";

$.post("controlador.php",
       {
       dato: $(valor).val(),
       tabla:table,
       campo:campo_1,
       campo2:campo_2,
       campo_condicion:input2,
       valor_condicion:$(condi2).val(),
       accion:'validar'
       },
       function(data){
           resultado=data.split("#$");
           if(resultado[0]==1)
           { document.getElementById(descripcion).value=resultado[1];  }
            else
             {
				 
             //document.getElementById(input1).value="";
             document.getElementById(descripcion).value=resultado[1];
             }  
         }
      );

}


$(function() 
{
	$.datepicker.setDefaults($.datepicker.regional['']);
	$("#fecha_fiscal").datepicker($.datepicker.regional['es']);
});

$(document).ready(function() 
{
   	$("#fecha_fiscal").datepicker(
   	{
		dateFormat: 'dd/mm/yy',
		yearRange: '2005:2015',
		inline: false
	});
	
	
});
$(function() 
{
	$.datepicker.setDefaults($.datepicker.regional['']);
	$("#fecha_respu").datepicker($.datepicker.regional['es']);
});

$(document).ready(function() 
{
   	$("#fecha_respu").datepicker(
   	{
		dateFormat: 'dd/mm/yy',
		yearRange: '2005:2015',
		inline: false
	});
});
$(function() 
{
	$.datepicker.setDefaults($.datepicker.regional['']);
	$("#fecha_vence").datepicker($.datepicker.regional['es']);
});

$(document).ready(function() 
{
   	$("#fecha_vence").datepicker(
   	{
		dateFormat: 'dd/mm/yy',
		yearRange: '2005:2015',
		inline: false
	});
});


$(function() 
{
	$.datepicker.setDefaults($.datepicker.regional['']);
	$("#fecha003").datepicker($.datepicker.regional['es']);
});

$(document).ready(function() 
{
   	$("#fecha003").datepicker(
   	{
		dateFormat: 'dd/mm/yy',
		yearRange: '2005:2015',
		inline: false
	});
});


