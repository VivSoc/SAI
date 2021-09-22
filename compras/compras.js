$(function () 
{
    $("#fecdoc").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdoc; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });
    $("#fechaven").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdoc; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });
	$("#compfeclote").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdoc; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });
	
}

);


/*Funciones para el modulo de compra*/
function buscar_proveedor(){	
if(document.getElementById('id_proveedor').value!='')
	{
		$.post("vistas/compras/registrocompras/datos_compras.php",{
			id_proveedor : $("#id_proveedor").val()
		},
			function(data){
			$("#cuerpo_datos_proveedor").html(data);
			});
	}
	else
	{
	swal("Ingrese Cédula o Rif del Proveedor...!", "Verifique...", "warning")
	}
}
function activar_fecha_credito(valor)
{
	if(document.getElementById('tipocompra').value=='Contado')
	{
		document.getElementById('fechaven').disabled=true
		document.getElementById('compdesforpag').disabled=false
		document.getElementById('compdesforpag').value=""
		
		
	}
	else
	{
		document.getElementById('fechaven').disabled=false
		document.getElementById('compdesforpag').disabled=true
		document.getElementById('compdesforpag').value=""
		document.getElementById("cuerpo_datos_pagos").innerHTML="";
		document.getElementById('compidforpag').value='CRED';
	}
}

function detalle_compras(){
	$.post("vistas/compras/registrocompras/detalle_compras.php",{
		},
			function(data){
			$("#cuerpo_der").html(data);
			});
}
function agregar_producto_compra()
{	
	if(document.getElementById('compnumlote').value=='' && (document.getElementById('tippro').value=='PRODUCTO ELABORADO PERECEDERO' || document.getElementById('tippro').value=='MATERIA PRIMA PERECEDERA'))
	swal("Debe Ingresar el número de lote, y verificar la fecha de caducidad", "Por Favor, Verifique.", "warning")
	else if(document.getElementById('canprocompra').value > 0 && document.getElementById('codprocompra').value!='' && document.getElementById('preprocompra').value>0)
	{
		$.post("vistas/compras/registrocompras/detalle_compras.php",{
			numdoc  : $("#numdoc").val(),		
			codpro  : $("#codprocompra").val(),		
			despro  : $("#desprocompra").val(),		
			prepro  : $("#preprocompra").val().replace(/\,/g,''),		
			medpro  : $("#unidadproact").val(),
			numlot  : $("#compnumlote").val(),
			feclot  : $("#compfeclote").val(),
			canpro  : $("#canprocompra").val().replace(/\,/g,''),
			prevendet  : $("#preprovendet").val().replace(/\,/g,''),
			prevenmay  : $("#preprovenmay").val().replace(/\,/g,''),
			ivapro  : $("#iva").val().replace(/\,/g,'')
		},
		function(data){
		$("#cuerpo_der").html(data);
		})
		document.getElementById('codprocompra').value=""
		document.getElementById('desprocompra').value=""
		document.getElementById('tippro').value=""		
		document.getElementById('dsctomax').value="0.00"
		document.getElementById('minimo').value="0.00"
		document.getElementById('maximo').value="0.00"
		document.getElementById('iva').value="0.00"
		document.getElementById('preprocompra').value="0.00"
		document.getElementById('prepromay').value="0.00"
		document.getElementById('canprocompra').value="0"
		document.getElementById('preproducto').value="0.00"
		document.getElementById('candisproducto').value="0"
		document.getElementById('unidadproact').value=""
		document.getElementById('compnumlote').value=""
//		document.getElementById('compfeclote').value=""
		document.getElementById('preprovendet').value="0.00"
		document.getElementById('preprovenmay').value="0.00"
		document.getElementById('unidadpronew').value=""		
	}else
	{
		swal("Debe Ingresar el Código, Precio y Cantidad del Producto a Registrar...!", "Por Favor, Verifique.", "warning")
	}
}

function eliminar_item_compras(cod,tabla,lote)
{
	if(cod!='')
	{
		$.post("controlador.php",{
		tabla: tabla,
		codprocom  : cod,
		lote: lote,		
		accion: "elimina_item_compra" 
		},
			function(data){
			$("#elimina_item_compra").html(data);
			});
			
	}
}

function guardar_compra(tabla){

if(document.getElementById('comptipdoc').value!='' && document.getElementById('numdoc').value!='' && document.getElementById('tot_compra').value>0 && document.getElementById('compidforpag').value!='')
{
	var idpago=new Array();
	var bancos=new Array();
	var montos=new Array();
	var numero=new Array();
	var can_pagos=document.getElementById("pagos").value!=null?document.getElementById("pagos").value:0;



	for(var i=1;i<=can_pagos;i++)
  	{
		if(document.getElementById("monto_pago"+i).value>0)
		{
		   idpago[i] = document.getElementById("id_pago"+i).value;
		   montos[i] = document.getElementById("monto_pago"+i).value;
		   bancos[i] = document.getElementById("id_banco"+i).value;
		   numero[i] = document.getElementById("num_pago"+i).value;  
		}				
   }
	swal({
		title: '¿Desea Registrar la Compra?',
		text: 'Verifique que los datos sean Correctos',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Si, Seguro!',
		cancelButtonText: 'No!',
		closeOnConfirm: true,
		closeOnCancel: true
	  },
	  function(isConfirm){
		if (isConfirm) {
		  $.post("controlador.php",{
		  tmp_tabla: tabla, 	  
		  idforpago:$("#compidforpag").val(),
		  idpago:idpago,
		  monpago:montos,
		  idbanco:bancos,
		  numref:numero,
		  pagos:$("#pagos").val(),
		  idproveedor  : $("#id_proveedor").val(),
		  iddoc  : $("#comptipdoc").val(),
		  numdoc  : $("#numdoc").val(),
		  fecregcom  : $("#fecregcom").val(),
		  fecdoc  : $("#fecdoc").val(),
		  tipcompra  : $("#tipocompra").val(),
		  fecvencom  : $("#fechaven").val(),
		  totcompra  : $("#tot_compra").val(),
		  accion: "guarda_compras" 
		  },
		  function(data){
		  $("#guardar_compra").html(data);
		   document.getElementById("cuerpo_datos_proveedor").innerHTML="";
		   document.getElementById("cuerpo_der").innerHTML="";
		   document.getElementById("id_proveedor").value="";
		   document.getElementById("id_proveedor").focus();
		  });
		}
	  });	
}
else
{
	swal("No puede Guardar una Compra con datos en blanco", "Verifique...", "warning")
}
}
function buscar_precio_compra(key)
{
	var unicode
    if (key.charCode)
    {
		unicode=key.charCode;
	}
    else
    {
		unicode=key.keyCode;
	}
    if (unicode == 13 || unicode == 9)
	{
	  if(document.getElementById('codprocompra').value!='')
	  {
		  $.post("controlador.php",{
		  codpro  : $("#codprocompra").val(),		
		  accion: "busca_precio_compra" 
		  },
			  function(data){
			  $("#precio_producto_compra").html(data);
			  });
			  
	  }	
	}
}
function buscar_precio_compra2()
{
  if(document.getElementById('codprocompra').value!='')
  {
	  $.post("controlador.php",{
	  codpro  : $("#codprocompra").val(),		
	  accion: "busca_precio_compra" 
	  },
		  function(data){
		  $("#precio_producto_compra").html(data);
		  }); 
	  }	
}

function limpiar_compras(tabla)
{
	swal({
		title: '¿Desea limpiar los datos?',
		text: 'Verifique antes de aceptar',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Si, Seguro!',
		cancelButtonText: 'No!',
		closeOnConfirm: true,
		closeOnCancel: true
	  },
	  function(isConfirm)
	  {
		if (isConfirm) 
		{
			$.post("controlador.php",{
			tabla:tabla,	
			accion: "elimina_temp" 
		},
			function(data)
			{
			   document.getElementById("cuerpo_datos_proveedor").innerHTML="";
			   document.getElementById("cuerpo_der").innerHTML="";
			   document.getElementById("id_proveedor").value="";
		   		document.getElementById("id_proveedor").focus();		  
			});

		}
	  });	
	  
}

// Función autocompletar
function autocompletar() 
{
	var minimo_letras = 1; // minimo letras visibles en el autocompletar
	var palabra = $('#codprocompra').val();
	//Contamos el valor del input mediante una condicional
	if (palabra.length >= minimo_letras) {
		$.ajax({
			url: 'controlador.php',
			type: 'POST',
			data: {palabra:palabra,accion:"auto_comp_producto"},
			success:function(data){
				$('#lista_id').show();
				$('#lista_id').html(data);
			}
		});
	} else {
		//ocultamos la lista
		$('#lista_id').hide();
	}
}

// Funcion Mostrar valores
function set_item(opciones) {
	// Cambiar el valor del formulario input
	$('#codprocompra').val(opciones);
	// ocultar lista de proposiciones
	//$('#preprocompra').focus();
	$('#lista_id').hide();
	buscar_precio_compra2();
}

function mostrar_forpagos()
{
	


	var x = document.getElementById("cuerpo_datos_pagos");
//    if (x.style.display === "none") 
	if(document.getElementById("compidforpag").value!='xxxxx')
	{
		document.getElementById("cuerpo_datos_compra").style.width = '100%';
		document.getElementById("cuerpo_datos_compra").style.float = 'left';
        x.style.display = "block";
    } else {
        x.style.display = "none";
		document.getElementById("cuerpo_datos_compra").style.width = '100%';
		document.getElementById("cuerpo_datos_compra").style.float = 'left';
    }
$(document).ready(function()
{
       var parametros = {
            "codigo" : $("#compidforpag").val()
      }
      $.ajax({
              data : parametros,
              url : "vistas/compras/registrocompras/formas_pago_compras.php",
              type : "post",
              success:function(data) {  

                     $('#cuerpo_datos_pagos').html(data);

                 }  
       })
});
}
function validar_forpagos(tabla)
{
	if(document.getElementById("tipocompra").value=='Contado')
	{
		var ban=0
		var monto=0
		var monto_total=0
		var banpagos=0
	var can_pagos=document.getElementById("pagos").value!=null?document.getElementById("pagos").value:0;
	
		for(var i=1;i<=can_pagos;i++)
			{	   
			
				monto=parseFloat(document.getElementById("monto_pago"+i).value.replace(/\,/g,''));
				
				monto_total = monto_total + multi(monto);	
				monto_total2 = divi(monto_total);	
				function multi(a)
				{
					return (a)*1000;
				}	
				function divi(a)
				{
					return (a)/1000;
				}					
		   }
		   if(monto_total2==parseFloat(document.getElementById("tot_compra").value).toFixed(2))
		   {
			   
				for(var j=1;j<=can_pagos;j++)
				{
					if(document.getElementById("monto_pago"+j).value>0 && document.getElementById("id_pago"+j).value!='0001')
					{
						ban=ban+1
						if( document.getElementById("id_banco"+j).value!='' && document.getElementById("num_pago"+j).value!='')
						{
							banpagos=banpagos+2
							
						}
					}
					//y si es = a 0001 que pasa ?
				}  			
				bantotal=ban+banpagos
				banx=ban*3
				
				if(bantotal==banx)
					guardar_compra(tabla)
				else
					swal("Falta ingresar datos en la forma de pago", "Por favor verifique", "warning")
		   }
		else
			{
			swal("No coincide el total de la compra con los montos ingresados en las formas de pago", "Por favor verifique", "warning")
			}
	}
	else
	guardar_compra(tabla)
}