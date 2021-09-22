$(function () 
{
    $("#fechaabono_cxp").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdoc; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });    
}

);


/*Funciones para el modulo de cuentas por pagar*/
function buscar_proveedor_cxp(){	
if(document.getElementById('id_proveedor_cxp').value!='')
	{
		$.post("vistas/compras/cuentaspagar/datos_proveedor_cxp.php",{
			id_proveedor : $("#id_proveedor_cxp").val()
		},
			function(data){
			$("#cuerpo_datos_proveedor_cxp").html(data);
			});
	}
	else
	{
	swal("Ingrese el documento del proveedor...!", "Verifique...", "warning")
	}
}

function buscar_cuentaxpagar(idcompra,saldo){
	$.post("vistas/compras/CuentasPagar/datos_abono_cxp.php",{
			idcompra:idcompra,
			montosaldo:saldo
		},
			function(data){
			$("#cuerpo_detalle_cuentasxpagar").html(data);
			});
}


function guardar_abonos_cxp(){
	
if(parseFloat(document.getElementById('montoabono_cxp').value.replace(/\,/g,''))<=parseFloat(document.getElementById('monabonado').value))
{
	if(document.getElementById('observaciones_cxp').value!='' && parseFloat(document.getElementById('montoabono_cxp').value)>0)
	{	
		swal({
			title: '¿Desea Registrar el Abono?',
			text: 'Verifique que los datos sean correctos',
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
			  idctapagar:$("#idctaxpagar").val(),
			  monabono:$("#montoabono_cxp").val().replace(/\,/g,''),
			  fecabono: $("#fechaabono_cxp").val(),			  			
			  obsabono: $("#observaciones_cxp").val(),
			  accion: "guarda_abono_cxp" 
			  },
			  function(data){
			  $("#guardar_cuentasxpagar").html(data);
			   document.getElementById("cuerpo_datos_proveedor_cxp").innerHTML="";
			   document.getElementById("cuerpo_detalle_cuentasxpagar").innerHTML="";
		   		document.getElementById("id_proveedor_cxp").focus();
			  });
			}
		  });	
	}
	else
	{
		swal("Falta ingresar datos para el abono", "Por favor verifique", "warning")
	}
}else
	{
		swal("El monto abonado es mayor al saldo de la cuenta", "Por favor verifique", "warning")
	}
}

function limpiar_abonos_cxp(){
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
		{		document.getElementById("cuerpo_datos_proveedor_cxp").innerHTML="";
			   document.getElementById("cuerpo_detalle_cuentasxpagar").innerHTML="";
		   		document.getElementById("id_proveedor_cxp").focus();		  
		}
	  });	
	  
}

// Función autocompletar
function autocompletar_cxp() 
{
	var minimo_letras = 1; // minimo letras visibles en el autocompletar
	var palabra = $('#id_proveedor_cxp').val();
	//Contamos el valor del input mediante una condicional
	if (palabra.length >= minimo_letras) {
		$.ajax({
			url: 'controlador.php',
			type: 'POST',
			data: {palabra:palabra,accion:"cxp_auto_comp_proveedor"},
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
	$('#id_proveedor_cxp').val(opciones);
	// ocultar lista de proposiciones
	$('#lista_id').hide();
}