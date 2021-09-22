parent.location.hash = '';
function verificar_banco(accion)
{
	$.post("vistas/parametrizacion/general/bancos/datos_bancos.php",
	{
		id_banco: $("#id_banco").val(), 
		des_banco: $("#des_banco").val(),
		sta_banco: $("input[name='sta_banco']:checked").val(), 
		banco_op: accion
	},
	
	function(data)
	{
		$("#bancos").html(data);
		if ($("#id_banco").val()!="")
		{
			$("#des_banco").focus();
		}
		else
		{
			$("#id_banco").focus();
		}
	});
	
}
	
function guardar_banco()
{
	if (($("#id_banco").val()=="") || ($("#des_banco").val()=="" )  || ($("#sta_banco").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/general/bancos/datos_bancos.php",
	{
		id_banco: $("#id_banco").val(), 
		des_banco: $("#des_banco").val(),
		sta_banco: $("input[name='sta_banco']:checked").val(), 
		banco_op: "guardar"
	},
	function(data)
	{
		$("#banco_guardar_datos").html(data);
		$("#id_banco").focus();
	})
}
	
function limpiar_banco()
{
	$("#id_banco").val("");
	$("#des_banco").val("");
	$("#id_banco").focus();
}