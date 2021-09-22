parent.location.hash = '';
function verificar_origen(accion)
{
	$.post("vistas/parametrizacion/inventario/origenes/datos_origenes.php",
	{
		id_origen: $("#id_origen").val(), 
		des_origen: $("#des_origen").val(),
		sta_origen: $("input[name='sta_origen']:checked").val(), 
		origen_op: accion
	},
	
	function(data)
	{
		$("#origenes").html(data);
		if ($("#id_origen").val()!="")
		{
			$("#des_origen").focus();
		}
		else
		{
			$("#id_origen").focus();
		}
	});
	
}
	
function guardar_origen()
{
	if (($("#id_origen").val()=="") || ($("#des_origen").val()=="" )  || ($("#sta_origen").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/origenes/datos_origenes.php",
	{
		id_origen: $("#id_origen").val(), 
		des_origen: $("#des_origen").val(),
		sta_origen: $("input[name='sta_origen']:checked").val(), 
		origen_op: "guardar"
	},
	function(data)
	{
		$("#origen_guardar_datos").html(data);
		$("#id_origen").focus();
	})
}
	
function limpiar_origen()
{
	$("#id_origen").val("");
	$("#des_origen").val("");
	$("#id_origen").focus();
}