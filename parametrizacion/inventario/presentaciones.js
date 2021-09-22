parent.location.hash = '';
function verificar_presentacion(accion)
{
	$.post("vistas/parametrizacion/inventario/presentaciones/datos_presentaciones.php",
	{
		id_presentacion: $("#id_presentacion").val(), 
		des_presentacion: $("#des_presentacion").val(),
		sta_presentacion: $("input[name='sta_presentacion']:checked").val(), 
		presentacion_op: accion
	},
	
	function(data)
	{
		$("#presentaciones").html(data);
		if ($("#id_presentacion").val()!="")
		{
			$("#des_presentacion").focus();
		}
		else
		{
			$("#id_presentacion").focus();
		}
	});
	
}
	
function guardar_presentacion()
{
	if (($("#id_presentacion").val()=="") || ($("#des_presentacion").val()=="" )  || ($("#sta_presentacion").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/presentaciones/datos_presentaciones.php",
	{
		id_presentacion: $("#id_presentacion").val(), 
		des_presentacion: $("#des_presentacion").val(),
		sta_presentacion: $("input[name='sta_presentacion']:checked").val(), 
		presentacion_op: "guardar"
	},
	function(data)
	{
		$("#presentacion_guardar_datos").html(data);
		$("#id_presentacion").focus();
	})
}
	
function limpiar_presentacion()
{
	$("#id_presentacion").val("");
	$("#des_presentacion").val("");
	$("#id_presentacion").focus();
}