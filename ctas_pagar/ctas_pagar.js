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
function buscar_proveedor_cxp(){	
if(document.getElementById('id_proveedor_rep_cxp').value!='')
	{
		$.post("reportes/cuentas_pagar/datos_cuentas_pagar.php",{
			id_proveedor_cxp : $("#id_proveedor_rep_cxp").val()
		},
			function(data){
			$("#datos_proveedor_cxp").html(data);
			});
	}
	else
	{
	swal("Ingrese Documento del Proveedor...!", "Verifique...", "warning")
	}
}

function buscar_abonos_cxp(cuenta,compra,saldo,abonado)
{
	$.post("reportes/cuentas_pagar/abonos_cuentas_pagar.php",{
	id_cuenta_cxp : cuenta,
	id_compra_cxp : compra,
	saldo_cxp : saldo,
	abonado_cxp : abonado
	},
	function(data){
	$("#datos_abonos_cxp").html(data);
	});

}
function cerrar_abonos_cxp()
{	
   document.getElementById("datos_abonos_cxp").innerHTML="";
}

function imprimir_ctas_pagar(id_orden)
{
	if(document.getElementById('id_proveedor_rep_cxp').value!='')
	{		pagina="reportes/cuentas_pagar/rep_cuentas_pagar_provee.php";
			pagina+="?id_provee="+$('#id_proveedor_rep_cxp').val();
			window.open(pagina,'ctas_pagar_proveedor')
	}else
	{
		swal("No puede Imprimir una Orden de Compra con datos en blanco", "Verifique...", "warning")
	}
}


function limpiar_orden(tabla)
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
function autocompletar_rep_cxp() 
{
	var minimo_letras = 1; // minimo letras visibles en el autocompletar
	var palabra = $('#id_proveedor_rep_cxp').val();
	//Contamos el valor del input mediante una condicional
	if (palabra.length >= minimo_letras) {
		$.ajax({
			url: 'controlador.php',
			type: 'POST',
			data: {palabra:palabra,accion:"auto_provee_rep_cxp"},
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
function set_item_cxp(opciones) {
	// Cambiar el valor del formulario input
	$('#id_proveedor_rep_cxp').val(opciones);
	// ocultar lista de proposiciones
	$('#lista_id').hide();
}