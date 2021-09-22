parent.location.hash = '';
function verificar_propietario(accion)
{
	$.post("vistas/parametrizacion/inventario/propietarios/datos_propietarios.php",
	{
		id_propietario: $("#id_propietario").val(), 
		des_propietario: $("#des_propietario").val(),
		sta_propietario: $("input[name='sta_propietario']:checked").val(), 
		propietario_op: accion
	},
	
	function(data)
	{
		$("#propietarios").html(data);
		if ($("#id_propietario").val()!="")
		{
			$("#des_propietario").focus();
		}
		else
		{
			$("#id_propietario").focus();
		}
	});
	
}
	
function guardar_propietario()
{
	if (($("#id_propietario").val()=="") || ($("#des_propietario").val()=="" )  || ($("#sta_propietario").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/propietarios/datos_propietarios.php",
	{
		id_propietario: $("#id_propietario").val(), 
		des_propietario: $("#des_propietario").val(),
		sta_propietario: $("input[name='sta_propietario']:checked").val(), 
		propietario_op: "guardar"
	},
	function(data)
	{
		$("#propietario_guardar_datos").html(data);
		$("#id_propietario").focus();
	})
}
	
function limpiar_propietario()
{
	$("#id_propietario").val("");
	$("#des_propietario").val("");
	$("#id_propietario").focus();
}