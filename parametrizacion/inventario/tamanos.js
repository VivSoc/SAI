parent.location.hash = '';
function verificar_tamano(accion)
{
	$.post("vistas/parametrizacion/inventario/tamanos/datos_tamanos.php",
	{
		id_tamano: $("#id_tamano").val(), 
		des_tamano: $("#des_tamano").val(),
		sta_tamano: $("input[name='sta_tamano']:checked").val(), 
		tamano_op: accion
	},
	
	function(data)
	{
		$("#tamanos").html(data);
		if ($("#id_tamano").val()!="")
		{
			$("#des_tamano").focus();
		}
		else
		{
			$("#id_tamano").focus();
		}
	});
	
}
	
function guardar_tamano()
{
	if (($("#id_tamano").val()=="") || ($("#des_tamano").val()=="" )  || ($("#sta_tamano").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/tamanos/datos_tamanos.php",
	{
		id_tamano: $("#id_tamano").val(), 
		des_tamano: $("#des_tamano").val(),
		sta_tamano: $("input[name='sta_tamano']:checked").val(), 
		tamano_op: "guardar"
	},
	function(data)
	{
		$("#tamano_guardar_datos").html(data);
		$("#id_tamano").focus();
	})
}
	
function limpiar_tamano()
{
	$("#id_tamano").val("");
	$("#des_tamano").val("");
	$("#id_tamano").focus();
}