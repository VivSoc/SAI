parent.location.hash = '';
function verificar_peso(accion)
{
	$.post("vistas/parametrizacion/inventario/pesos/datos_pesos.php",
	{
		id_peso: $("#id_peso").val(), 
		des_peso: $("#des_peso").val(),
		sta_peso: $("input[name='sta_peso']:checked").val(), 
		peso_op: accion
	},
	
	function(data)
	{
		$("#pesos").html(data);
		if ($("#id_peso").val()!="")
		{
			$("#des_peso").focus();
		}
		else
		{
			$("#id_peso").focus();
		}
	});
	
}
	
function guardar_peso()
{
	if (($("#id_peso").val()=="") || ($("#des_peso").val()=="" )  || ($("#sta_peso").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/inventario/pesos/datos_pesos.php",
	{
		id_peso: $("#id_peso").val(), 
		des_peso: $("#des_peso").val(),
		sta_peso: $("input[name='sta_peso']:checked").val(), 
		peso_op: "guardar"
	},
	function(data)
	{
		$("#peso_guardar_datos").html(data);
		$("#id_peso").focus();
	})
}
	
function limpiar_peso()
{
	$("#id_peso").val("");
	$("#des_peso").val("");
	$("#id_peso").focus();
}