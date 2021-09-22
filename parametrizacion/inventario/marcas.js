parent.location.hash = '';
function verificar_marca(accion)
{
	$.post("vistas/parametrizacion/inventario/marcas/datos_marcas.php",
	{
		id_marca: $("#id_marca").val(), 
		des_marca: $("#des_marca").val(),
		sta_marca: $("input[name='sta_marca']:checked").val(), 
		marca_op: accion
	},
	
	function(data)
	{
		$("#marcas").html(data);
		if ($("#id_marca").val()!="")
		{
			$("#des_marca").focus();
		}
		else
		{
			$("#id_marca").focus();
		}
	});
	
}
	
function guardar_marca()
{
	if (($("#id_marca").val()=="") || ($("#des_marca").val()=="" )  || ($("#sta_marca").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/marcas/datos_marcas.php",
	{
		id_marca: $("#id_marca").val(), 
		des_marca: $("#des_marca").val(),
		sta_marca: $("input[name='sta_marca']:checked").val(), 
		marca_op: "guardar"
	},
	function(data)
	{
		$("#marca_guardar_datos").html(data);
		$("#id_marca").focus();
	})
}
	
function limpiar_marca()
{
	$("#id_marca").val("");
	$("#des_marca").val("");
	$("#id_marca").focus();
}