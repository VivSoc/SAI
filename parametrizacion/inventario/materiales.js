parent.location.hash = '';
function verificar_material(accion)
{
	$.post("vistas/parametrizacion/inventario/materiales/datos_materiales.php",
	{
		id_material: $("#id_material").val(), 
		des_material: $("#des_material").val(),
		sta_material: $("input[name='sta_material']:checked").val(), 
		material_op: accion
	},
	
	function(data)
	{
		$("#materiales").html(data);
		if ($("#id_material").val()!="")
		{
			$("#des_material").focus();
		}
		else
		{
			$("#id_material").focus();
		}
	});
	
}
	
function guardar_material()
{
	if (($("#id_material").val()=="") || ($("#des_material").val()=="" )  || ($("#sta_material").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/materiales/datos_materiales.php",
	{
		id_material: $("#id_material").val(), 
		des_material: $("#des_material").val(),
		sta_material: $("input[name='sta_material']:checked").val(), 
		material_op: "guardar"
	},
	function(data)
	{
		$("#material_guardar_datos").html(data);
		$("#id_material").focus();
	})
}
	
function limpiar_material()
{
	$("#id_material").val("");
	$("#des_material").val("");
	$("#id_material").focus();
}