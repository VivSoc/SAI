parent.location.hash = '';
function verificar_caja(accion)
{
	$.post("vistas/parametrizacion/general/cajas/datos_cajas.php",
	{
		id_caja: $("#id_caja").val(), 
		des_caja: $("#des_caja").val(),
		sta_caja: $("input[name='sta_caja']:checked").val(), 
		caja_op: accion
	},
	
	function(data)
	{
		$("#cajas").html(data);
		if ($("#id_caja").val()!="")
		{
			$("#des_caja").focus();
		}
		else
		{
			$("#id_caja").focus();
		}
	});
	
}
	
function guardar_caja()
{
	if (($("#id_caja").val()=="") || ($("#des_caja").val()=="" )  || ($("#sta_caja").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/general/cajas/datos_cajas.php",
	{
		id_caja: $("#id_caja").val(), 
		des_caja: $("#des_caja").val(),
		sta_caja: $("input[name='sta_caja']:checked").val(), 
		caja_op: "guardar"
	},
	function(data)
	{
		$("#caja_guardar_datos").html(data);
		$("#id_caja").focus();
	})
}
	
function limpiar_caja()
{
	$("#id_caja").val("");
	$("#des_caja").val("");
	$("#id_caja").focus();
}