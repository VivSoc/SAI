parent.location.hash = '';
function verificar_canton(accion)
{
	$.post("vistas/parametrizacion/general/cantones/datos_cantones.php",
	{
		id_provincia_c: $("#id_provincia_c").val(), 
		id_canton_c: $("#id_canton_c").val(), 
		des_canton_c: $("#des_canton_c").val(),
		sta_canton_c: $("input[name='sta_canton_c']:checked").val(), 
		canton_op: accion
	},
	
	function(data)
	{
		$("#cantones").html(data);
		if ($("#id_canton_c").val()!="")
		{
			$("#des_canton_c").focus();
		}
		else
		{
			$("#id_canton_c").focus();
		}
	});
	
}
	
function guardar_canton()
{
	if (($("#id_canton_c").val()=="") || ($("#des_canton_c").val()=="" )  || ($("#sta_canton_c").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/general/cantones/datos_cantones.php",
	{
		id_provincia_c: $("#id_provincia_c").val(), 
		id_canton_c: $("#id_canton_c").val(), 
		des_canton_c: $("#des_canton_c").val(),
		sta_canton_c: $("input[name='sta_canton_c']:checked").val(), 
		canton_op: "guardar"
	},
	function(data)
	{
		$("#canton_guardar_datos").html(data);
		$("#id_canton_c").focus();
	})
}
	
function limpiar_canton()
{
	$("#id_provincia_c").val("");
	$("#id_canton_c").val("");
	$("#des_canton_c").val("");
	$("#des_provincia_c").val("");
	$("#id_canton_c").focus();
}