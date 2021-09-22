parent.location.hash = '';
function verificar_modelo(accion)
{
	$.post("vistas/parametrizacion/inventario/modelos/datos_modelos.php",
	{
		id_modelo: $("#id_modelo").val(), 
		des_modelo: $("#des_modelo").val(),
		sta_modelo: $("input[name='sta_modelo']:checked").val(), 
		modelo_op: accion
	},
	
	function(data)
	{
		$("#modelos").html(data);
		if ($("#id_modelo").val()!="")
		{
			$("#des_modelo").focus();
		}
		else
		{
			$("#id_modelo").focus();
		}
	});
	
}
	
function guardar_modelo()
{
	if (($("#id_modelo").val()=="") || ($("#des_modelo").val()=="" )  || ($("#sta_modelo").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/modelos/datos_modelos.php",
	{
		id_modelo: $("#id_modelo").val(), 
		des_modelo: $("#des_modelo").val(),
		sta_modelo: $("input[name='sta_modelo']:checked").val(), 
		modelo_op: "guardar"
	},
	function(data)
	{
		$("#modelo_guardar_datos").html(data);
		$("#id_modelo").focus();
	})
}
	
function limpiar_modelo()
{
	$("#id_modelo").val("");
	$("#des_modelo").val("");
	$("#id_modelo").focus();
}