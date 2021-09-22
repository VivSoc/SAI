function abertura_caja(){
	$.post("vistas/ventas/cajas/abre_caja/datos_abre_caja.php",{
		},
			function(data){
			$("#cuerpo_abertura_caja").html(data);
			});
}
function detalle_apertura_caja(){
	$.post("ventas/apertura_caja/detalle_apertura_caja.php",{
		},
			function(data){
			$("#cuerpo_der").html(data);
			});
}
function buscar_abertura_caja(){	
	if(document.getElementById('aper_caja_cod_caja').value!='')
	{
		$.post("controlador.php",{
		codcaja  : $("#aper_caja_cod_caja").val(),
		accion: "busca_aper_caja" 
		},
			function(data){
			$("#cuerpo_abertura_caja").html(data);
			});
	}
	else
	{
		swal('Error al consultar', 'Debe ingresar la caja que va a abrir', 'error')
	}
}

function abrir_caja(){

	if(document.getElementById('fondo_caja_usd').value=='')
		document.getElementById('fondo_caja_usd').value='0.00'
	
	
	if(document.getElementById('aper_caja_cod_caja').value=='')
	{
		swal('Error al consultar', 'Debe ingresar la caja que va a abrir', 'error')
	}
	else
	{
		if(document.getElementById('fondo_caja_usd').value=='0.00')
		{
			swal({
			  title: "¿Está seguro de abrir la caja con fondo en cero?",
			  text: "¿Abrir caja?",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Si, Seguro!",
			  cancelButtonText: "No, debo corregir!",
			  closeOnConfirm: false,
			  closeOnCancel: true
			},
			function(isConfirm){
				if (isConfirm)
				 {
					$.post("controlador.php",{	
					fecaper: $("#fec_aper_caja").val(),
					cedusu : $("#ced_usuario").val(),	
					codcaja: $("#aper_caja_cod_caja").val(),
					montousd: $("#fondo_caja_usd").val().replace(/\,/g,''),
					accion: "abre_caja" 
					},
						function(data){
						$("#cuerpo_abertura_caja").html(data);
						});
					detalle_apertura_caja()
			  	 }
			});
					
		}
		else
		{
			$.post("controlador.php",{	
					fecaper: $("#fec_aper_caja").val(),
					cedusu : $("#cedusu").val(),	
					codcaja: $("#aper_caja_cod_caja").val(),
					montousd: $("#fondo_caja_usd").val().replace(/\,/g,''),
					accion: "abre_caja" 
			},
				function(data){
				$("#cuerpo_abertura_caja").html(data);
			});
		}
	}


}	
	
function limpiar_aper_caja()
{
	document.getElementById('aper_caja_cod_caja').value='';
	document.getElementById('fondo_caja_cop').value='';
	document.getElementById('fondo_caja_usd').value='';
	document.getElementById('fondo_caja_bs').value='';
	document.getElementById("cuerpo_apertura_caja").innerHTML="";
}

function ordenar_tbl_cajas_abiertas(order){
	$.post("ventas/apertura_caja/detalle_apertura_caja.php",{
	orden: order		
	},
		function(data){
		$("#cuerpo_der").html(data);	
		});

}
function validar_caja_usuario(){
	$.post("../controlador.php",{	
	accion: "valida_caja_usu" 
		},
			function(data){
			$("#cuerpo_ventas_cliente").html(data);
		});

}
