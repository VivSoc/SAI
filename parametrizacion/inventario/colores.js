parent.location.hash = '';
function verificar_color(accion)
{
	$.post("vistas/parametrizacion/inventario/colores/datos_colores.php",
	{
		id_color: $("#id_color").val(), 
		des_color: $("#des_color").val(),
		sta_color: $("input[name='sta_color']:checked").val(), 
		color_op: accion
	},
	
	function(data)
	{
		$("#colores").html(data);
		if ($("#id_color").val()!="")
		{
			$("#des_color").focus();
		}
		else
		{
			$("#id_color").focus();
		}
	});
	
}
	
function guardar_color()
{
	if (($("#id_color").val()=="") || ($("#des_color").val()=="" )  || ($("#sta_color").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/colores/datos_colores.php",
	{
		id_color: $("#id_color").val(), 
		des_color: $("#des_color").val(),
		sta_color: $("input[name='sta_color']:checked").val(), 
		color_op: "guardar"
	},
	function(data)
	{
		$("#color_guardar_datos").html(data);
		$("#id_color").focus();
	})
}
	
function limpiar_color()
{
	$("#id_color").val("");
	$("#des_color").val("");
	$("#id_color").focus();
}