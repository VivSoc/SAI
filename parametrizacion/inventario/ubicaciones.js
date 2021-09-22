parent.location.hash = '';
function verificar_ubicacion(accion)
{
	$.post("vistas/parametrizacion/inventario/ubicaciones/datos_ubicaciones.php",
	{
		id_ubicacion: $("#id_ubicacion").val(), 
		des_ubicacion: $("#des_ubicacion").val(),
		sta_ubicacion: $("input[name='sta_ubicacion']:checked").val(), 
		ubicacion_op: accion
	},
	
	function(data)
	{
		$("#ubicaciones").html(data);
		if ($("#id_ubicacion").val()!="")
		{
			$("#des_ubicacion").focus();
		}
		else
		{
			$("#id_ubicacion").focus();
		}
	});
	
}
	
function guardar_ubicacion()
{
	if (($("#id_ubicacion").val()=="") || ($("#des_ubicacion").val()=="" )  || ($("#sta_ubicacion").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/ubicaciones/datos_ubicaciones.php",
	{
		id_ubicacion: $("#id_ubicacion").val(), 
		des_ubicacion: $("#des_ubicacion").val(),
		sta_ubicacion: $("input[name='sta_ubicacion']:checked").val(), 
		ubicacion_op: "guardar"
	},
	function(data)
	{
		$("#ubicacion_guardar_datos").html(data);
		$("#id_ubicacion").focus();
	})
}
	
function limpiar_ubicacion()
{
	$("#id_ubicacion").val("");
	$("#des_ubicacion").val("");
	$("#id_ubicacion").focus();
}