parent.location.hash = '';
function verificar_provincia(accion)
{
	$.post("vistas/parametrizacion/general/provincias/datos_provincias.php",
	{
		id_provincia: $("#id_provincia").val(), 
		des_provincia: $("#des_provincia").val(),
		sta_provincia: $("input[name='sta_provincia']:checked").val(), 
		provincia_op: accion
	},
	
	function(data)
	{
		$("#provincias").html(data);
		if ($("#id_provincia").val()!="")
		{
			$("#des_provincia").focus();
		}
		else
		{
			$("#id_provincia").focus();
		}
	});
	
}
	
function guardar_provincia()
{
	if (($("#id_provincia").val()=="") || ($("#des_provincia").val()=="" )  || ($("#sta_provincia").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/general/provincias/datos_provincias.php",
	{
		id_provincia: $("#id_provincia").val(), 
		des_provincia: $("#des_provincia").val(),
		sta_provincia: $("input[name='sta_provincia']:checked").val(), 
		provincia_op: "guardar"
	},
	function(data)
	{
		$("#provincia_guardar_datos").html(data);
		$("#id_provincia").focus();
	})
}
	
function limpiar_provincia()
{
	$("#id_provincia").val("");
	$("#des_provincia").val("");
	$("#id_provincia").focus();
}