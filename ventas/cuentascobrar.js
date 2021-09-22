$(function () 
{
    $("#fechaabono_cxc").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdoc; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });    
}

);


/*Funciones para el modulo de cuentas por cobrar*/
function buscar_cliente_cxc(){	
if(document.getElementById('id_cliente_cxc').value!='')
	{
		$.post("vistas/ventas/cuentascobrar/datos_cliente_cxc.php",{
			id_cliente : $("#id_cliente_cxc").val()
		},
			function(data){
			$("#cuerpo_datos_cliente_cxc").html(data);
			});
	}
	else
	{
	swal("Ingrese el documento del cliente...!", "Verifique...", "warning")
	}
}

function buscar_cuentaxcobrar(idventa,saldo){
	$.post("vistas/ventas/Cuentascobrar/datos_abono_cxc.php",{
			idventa:idventa,
			montosaldo:saldo
		},
			function(data){
			$("#cuerpo_detalle_cuentasxcobrar").html(data);
			});
}


function guardar_abonos_cxc(){
if(parseFloat(document.getElementById('montoabono_cxc').value.replace(/\,/g,''))<=parseFloat(document.getElementById('monabonado').value))
{
	if(document.getElementById('observaciones_cxc').value!='' && parseFloat(document.getElementById('montoabono_cxc').value)>0)
	{	
		swal({
			title: '¿Desea Registrar el Abono?',
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
			  idctacobrar:$("#idctaxcobrar").val(),
			  monabono:$("#montoabono_cxc").val().replace(/\,/g,''),
			  fecabono: $("#fechaabono_cxc").val(),			  			
			  obsabono: $("#observaciones_cxc").val(),
			  accion: "guarda_abono_cxc" 
			  },
			  function(data){
			  $("#guardar_cuentasxcobrar").html(data);
			   document.getElementById("cuerpo_datos_cliente_cxc").innerHTML="";
			   document.getElementById("cuerpo_detalle_cuentasxcobrar").innerHTML="";
		   		document.getElementById("id_cliente_cxc").focus();
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

function limpiar_abonos_cxc(){
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
		{		document.getElementById("cuerpo_datos_cliente_cxc").innerHTML="";
			   document.getElementById("cuerpo_detalle_cuentasxcobrar").innerHTML="";
		   		document.getElementById("id_cliente_cxc").focus();		  
		}
	  });	
	  
}

// Función autocompletar
function autocompletar_cxc() 
{
	var minimo_letras = 1; // minimo letras visibles en el autocompletar
	var palabra = $('#id_cliente_cxc').val();
	//Contamos el valor del input mediante una condicional
	if (palabra.length >= minimo_letras) {
		$.ajax({
			url: 'controlador.php',
			type: 'POST',
			data: {palabra:palabra,accion:"cxc_auto_comp_cliente"},
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
	$('#id_cliente_cxc').val(opciones);
	// ocultar lista de proposiciones
	$('#lista_id').hide();
}