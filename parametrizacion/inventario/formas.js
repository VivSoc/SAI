parent.location.hash = '';
function verificar_forma(accion)
{
	$.post("vistas/parametrizacion/inventario/formas/datos_formas.php",
	{
		id_forma: $("#id_forma").val(), 
		des_forma: $("#des_forma").val(),
		sta_forma: $("input[name='sta_forma']:checked").val(), 
		forma_op: accion
	},
	
	function(data)
	{
		$("#formas").html(data);
		if ($("#id_forma").val()!="")
		{
			$("#des_forma").focus();
		}
		else
		{
			$("#id_forma").focus();
		}
	});
	
}
	
function guardar_forma()
{
	if (($("#id_forma").val()=="") || ($("#des_forma").val()=="" )  || ($("#sta_forma").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/formas/datos_formas.php",
	{
		id_forma: $("#id_forma").val(), 
		des_forma: $("#des_forma").val(),
		sta_forma: $("input[name='sta_forma']:checked").val(), 
		forma_op: "guardar"
	},
	function(data)
	{
		$("#forma_guardar_datos").html(data);
		$("#id_forma").focus();
	})
}
	
function limpiar_forma()
{
	$("#id_forma").val("");
	$("#des_forma").val("");
	$("#id_forma").focus();
}