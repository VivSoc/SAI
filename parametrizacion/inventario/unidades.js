parent.location.hash = '';
function verificar_unidad(accion)
{
	$.post("vistas/parametrizacion/inventario/unidades/datos_unidades.php",
	{
		id_unidad: $("#id_unidad").val(), 
		des_unidad: $("#des_unidad").val(),
		sta_unidad: $("input[name='sta_unidad']:checked").val(), 
		unidad_op: accion
	},
	
	function(data)
	{
		$("#unidades").html(data);
		if ($("#id_unidad").val()!="")
		{
			$("#des_unidad").focus();
		}
		else
		{
			$("#id_unidad").focus();
		}
	});
	
}
	
function guardar_unidad()
{
	if (($("#id_unidad").val()=="") || ($("#des_unidad").val()=="" )  || ($("#sta_unidad").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/unidades/datos_unidades.php",
	{
		id_unidad: $("#id_unidad").val(), 
		des_unidad: $("#des_unidad").val(),
		sta_unidad: $("input[name='sta_unidad']:checked").val(), 
		unidad_op: "guardar"
	},
	function(data)
	{
		$("#unidad_guardar_datos").html(data);
		$("#id_unidad").focus();
	})
}
	
function limpiar_unidad()
{
	$("#id_unidad").val("");
	$("#des_unidad").val("");
	$("#id_unidad").focus();
}