parent.location.hash = '';
function verificar_formas_pago(accion)
{
	$.post("vistas/parametrizacion/general/formas_pago/datos_formas_pago.php",
	{
		id_formas_pago: $("#id_formas_pago").val(), 
		des_formas_pago: $("#des_formas_pago").val(),
		sta_formas_pago: $("input[name='sta_formas_pago']:checked").val(), 
		formas_pago_op: accion
	},
	
	function(data)
	{
		$("#formas_pago").html(data);
		if ($("#id_formas_pago").val()!="")
		{
			$("#des_formas_pago").focus();
		}
		else
		{
			$("#id_formas_pago").focus();
		}
	});
	
}
	
function guardar_formas_pago()
{
	if (($("#id_formas_pago").val()=="") || ($("#des_formas_pago").val()=="" )  || ($("#sta_formas_pago").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/general/formas_pago/datos_formas_pago.php",
	{
		id_formas_pago: $("#id_formas_pago").val(), 
		des_formas_pago: $("#des_formas_pago").val(),
		sta_formas_pago: $("input[name='sta_formas_pago']:checked").val(), 
		formas_pago_op: "guardar"
	},
	function(data)
	{
		$("#formas_pago_guardar_datos").html(data);
		$("#id_formas_pago").focus();
	})
}
	
function limpiar_formas_pago()
{
	$("#id_formas_pago").val("");
	$("#des_formas_pago").val("");
	$("#id_formas_pago").focus();
}