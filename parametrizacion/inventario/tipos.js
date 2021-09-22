parent.location.hash = '';
function verificar_tipo(accion)
{
	$.post("vistas/parametrizacion/inventario/tipos/datos_tipos.php",
	{
		id_tipo: $("#id_tipo").val(), 
		des_tipo: $("#des_tipo").val(),
		sta_tipo: $("input[name='sta_tipo']:checked").val(), 
		tipo_op: accion
	},
	
	function(data)
	{
		$("#tipos").html(data);
		if ($("#id_tipo").val()!="")
		{
			$("#des_tipo").focus();
		}
		else
		{
			$("#id_tipo").focus();
		}
	});
	
}
	
function guardar_tipo()
{
	if (($("#id_tipo").val()=="") || ($("#des_tipo").val()=="" )  || ($("#sta_tipo").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/tipos/datos_tipos.php",
	{
		id_tipo: $("#id_tipo").val(), 
		des_tipo: $("#des_tipo").val(),
		sta_tipo: $("input[name='sta_tipo']:checked").val(), 
		tipo_op: "guardar"
	},
	function(data)
	{
		$("#tipo_guardar_datos").html(data);
		$("#id_tipo").focus();
	})
}
	
function limpiar_tipo()
{
	$("#id_tipo").val("");
	$("#des_tipo").val("");
	$("#id_tipo").focus();
}