parent.location.hash = '';
function verificar_canton(accion)
{
	$.post("vistas/parametrizacion/general/cantones/datos_cantones.php",
	{
		id_canton: $("#id_canton").val(), 
		des_canton: $("#des_canton").val(),
		sta_canton: $("input[name='sta_canton']:checked").val(), 
		canton_op: accion
	},
	
	function(data)
	{
		$("#cantones").html(data);
		if ($("#id_canton").val()!="")
		{
			$("#des_canton").focus();
		}
		else
		{
			$("#id_canton").focus();
		}
	});
	
}
	
function guardar_canton()
{
	if (($("#id_canton").val()=="") || ($("#des_canton").val()=="" )  || ($("#sta_canton").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/general/cantones/datos_cantones.php",
	{
		id_canton: $("#id_canton").val(), 
		des_canton: $("#des_canton").val(),
		sta_canton: $("input[name='sta_canton']:checked").val(), 
		canton_op: "guardar"
	},
	function(data)
	{
		$("#canton_guardar_datos").html(data);
		$("#id_canton").focus();
	})
}
	
function limpiar_canton()
{
	$("#id_canton").val("");
	$("#des_canton").val("");
	$("#id_canton").focus();
}