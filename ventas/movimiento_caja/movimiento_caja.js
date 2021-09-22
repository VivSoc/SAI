function abre_datos_mov_caja(){
	if(document.getElementById('mov_caja_cod_caja').value=='')
	{
		swal('Acceso denegado', 'Debe abrir una caja para acceder a este módulo', 'error')
	}
	else
	{
	$.post("vistas/ventas/cajas/movimientos_caja/datos_mov_caja.php",{
		},
			function(data){
			$("#cuerpo_mov_caja").html(data);
			});
	}
}
function detalle_mov_caja(){
	$.post("ventas/movimientos_caja/detalle_mov_caja.php",{
		},
			function(data){
			$("#cuerpo_der").html(data);
			});
}

function guarda_mov_caja(){ 
	
	if (document.getElementById('mov_caja_usd').value=='')
		document.getElementById('mov_caja_usd').value='0.00'
	
	if(document.getElementById('mov_caja_usd').value=='0.00')
	{
		swal('Debe indicar el monto de la operación', 'no puede hacer movimientos en cero', 'warning')
	}
	else if(document.getElementById('mot_mov_caja').value=='')
	{
		swal('Debe indicar el motivo de la operación', 'El por qué está realizando la operación', 'warning')
	}
	else
	{
		$.post("controlador.php",{
		operacion  : $("input[name='ope_mov_caja']:checked").val(),	
		fecmov: $("#fec_mov_caja").val(),
		cedusuario : $("#mov_caja_ced_usuario").val(),	
		codcaja: $("#mov_caja_cod_caja").val(),
		montousd: $("#mov_caja_usd").val().replace(/\,/g,''),
		motivo:$("#mot_mov_caja").val(),	
		accion: "guarda_mov_caja" 
		},
			function(data){
			$("#cuerpo_mov_caja").html(data);
		});
	}
}	
	
function limpiar_mov_caja()
{
	document.getElementById("cuerpo_mov_caja").innerHTML="";
}

function ordenar_tbl_mov_caja(order){
	$.post("ventas/movimientos_caja/detalle_mov_caja.php",{
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
