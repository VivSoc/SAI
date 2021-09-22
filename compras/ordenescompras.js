$(function () 
{
    $("#fecdoc_odc").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdoc; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });	
}
);


/*Funciones para el modulo de ordenes de compra*/
function buscar_proveedor_odc(){	
if(document.getElementById('id_proveedor_odc').value!='')
	{
		$.post("vistas/compras/ordencompra/datos_orden.php",{
			id_proveedor_odc : $("#id_proveedor_odc").val()
		},
			function(data){
			$("#datos_proveedor_odc").html(data);
			});
	}
	else
	{
	swal("Ingrese Documento del Proveedor...!", "Verifique...", "warning")
	}
}
function activar_fecha_credito(valor)
{
	if(document.getElementById('tipocompra').value=='Contado')
	{
		document.getElementById('fechaven').disabled=true
		document.getElementById('compdesforpag').disabled=false
		
	}
	else
	{
		document.getElementById('fechaven').disabled=false
		document.getElementById('compdesforpag').disabled=true
		document.getElementById('compidforpag').value='CRED';

	}
}

function detalle_ordenes(){
	$.post("vistas/compras/ordencompra/detalle_ordenes.php",{
		},
			function(data){
			$("#cuerpo_der").html(data);
			});
}
function agregar_producto_odc()
{	
	if(document.getElementById('canpro_odc').value > 0 && document.getElementById('codpro_odc').value!='')
	{
		$.post("vistas/compras/OrdenCompra/detalle_ordenes.php",{
			numdoc  : $("#numdoc_odc").val(),		
			codpro  : $("#codpro_odc").val(),		
			codalt  : $("#codalt_odc").val(),		
			despro  : $("#despro_odc").val(),		
			medpro  : $("#unidadpro_odc").val(),
			canpro  : $("#canpro_odc").val().replace(/\,/g,'')
		},
		function(data){
		$("#cuerpo_der").html(data);
		})
		document.getElementById('codpro_odc').value=""
		document.getElementById('despro_odc').value=""
		document.getElementById('sta_pro_odc').value=""		
		document.getElementById('tippro_odc').value=""
		document.getElementById('dsctomax_odc').value="0.00"
		document.getElementById('minimo_odc').value="0.00"
		document.getElementById('maximo_odc').value="0.00"
		document.getElementById('ivapro_odc').value="0.00"
		document.getElementById('preprodet_odc').value="0.00"
		document.getElementById('prepromay_odc').value="0.00"
		document.getElementById('candispro_odc').value="0.00"
		document.getElementById('unidadpro_odc').value=""
		document.getElementById('canpro_odc').value="0.00"
		document.getElementById('undpronew_odc').value=""
	}else
	{
		swal("Debe Ingresar el Código y Cantidad del Producto a Ordenar...!", "Por Favor, Verifique.", "warning")
	}
}

function eliminar_item_ordenes(cod,tabla,lote)
{
	if(cod.value!='')
	{
		$.post("controlador.php",{
		tabla: tabla,
		codprocom  : cod,
		accion: "elimina_item_orden" 
		},
			function(data){
			$("#elimina_item_odc").html(data);
			});
			
	}
}

function guardar_orden_compra(tabla){

if(document.getElementById('items_orden').value!=0)
{
	swal({
		title: '¿Desea Registrar la Orden?',
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
		  tmp_tabla_odc: tabla, 	  
		  idproveedor_odc  : $("#id_proveedor_odc").val(),
		  numdoc_odc  : $("#numdoc_odc").val(),
		  fecreg_odc  : $("#fecdoc_odc").val(),
		  accion: "guarda_orden_compra" 
		  },
		  function(data){
		  $("#guardar_ordencompra").html(data);
		   document.getElementById("datos_proveedor_odc").innerHTML="";
		   document.getElementById("cuerpo_der").innerHTML="";
		   document.getElementById("id_proveedor_odc").value="";
		   document.getElementById("id_proveedor_odc").focus();
		  });
		}
	  });	
}
else
{
	swal("No puede Guardar una Orden de Compra con datos en blanco", "Verifique...", "warning")
}
}
function buscar_precio_orden(key)
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
	  if(document.getElementById('codpro_odc').value!='')
	  {
		  $.post("controlador.php",{
		  codpro  : $("#codpro_odc").val(),		
		  accion: "busca_precio_odc" 
		  },
			  function(data){
			  $("#precio_producto_odc").html(data);
			  });
			  
	  }	
	}
}
function buscar_precio_orden2()
{
  if(document.getElementById('codpro_odc').value!='')
  {
	  $.post("controlador.php",{
	  codpro  : $("#codpro_odc").val(),		
	  accion: "busca_precio_odc" 
	  },
		  function(data){
		  $("#precio_producto_odc").html(data);
		  }); 
	  }	
}

function imprimir_orden_compra(id_orden)
{
	if(document.getElementById('items_orden').value!=0)
	{		pagina="reportes/ordenes_compras/rep_ordenes_compras.php";
			pagina+="?id_orden="+id_orden;
			window.open(pagina,'orden_compra')
	}else
	{
		swal("No puede Imprimir una Orden de Compra con datos en blanco", "Verifique...", "warning")
	}
}


function limpiar_orden_compra(tabla)
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
			accion: "elimina_temp_odc" 
		},
			function(data)
			{
			   document.getElementById("datos_proveedor_odc").innerHTML="";
			   document.getElementById("cuerpo_der").innerHTML="";
			   document.getElementById("id_proveedor_odc").value="";
				document.getElementById("id_proveedor_odc").focus();		  
			});

		}
	  });	
	  
}

// Función autocompletar
function autocompletar_odc() 
{
//	alert($('#codpro_odc').val())
	var minimo_letras = 1; // minimo letras visibles en el autocompletar
	var palabra = $('#codpro_odc').val();
	//Contamos el valor del input mediante una condicional
	if (palabra.length >= minimo_letras) {
		$.ajax({
			url: 'controlador.php',
			type: 'POST',
			data: {palabra:palabra,accion:"auto_producto_odc"},
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
function set_item_odc(opciones) {
	// Cambiar el valor del formulario input
	$('#codpro_odc').val(opciones);
	// ocultar lista de proposiciones
	$('#lista_id').hide();
	buscar_precio_orden2();	
	document.getElementById("canpro_odc").focus();		  
}