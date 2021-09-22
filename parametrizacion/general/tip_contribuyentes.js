parent.location.hash = '';
function verificar_tip_contribuyente(accion)
{
	$.post("vistas/parametrizacion/general/tip_contribuyentes/datos_tip_contribuyentes.php",
	{
		id_tip_contribuyente: $("#id_tip_contribuyente").val(), 
		des_tip_contribuyente: $("#des_tip_contribuyente").val(),
		sta_tip_contribuyente: $("input[name='sta_tip_contribuyente']:checked").val(), 
		tip_contribuyente_op: accion
	},
	
	function(data)
	{
		$("#tip_contribuyentes").html(data);
		if ($("#id_tip_contribuyente").val()!="")
		{
			$("#des_tip_contribuyente").focus();
		}
		else
		{
			$("#id_tip_contribuyente").focus();
		}
	});
	
}
	
function guardar_tip_contribuyente()
{
	if (($("#id_tip_contribuyente").val()=="") || ($("#des_tip_contribuyente").val()=="" )  || ($("#sta_tip_contribuyente").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/general/tip_contribuyentes/datos_tip_contribuyentes.php",
	{
		id_tip_contribuyente: $("#id_tip_contribuyente").val(), 
		des_tip_contribuyente: $("#des_tip_contribuyente").val(),
		sta_tip_contribuyente: $("input[name='sta_tip_contribuyente']:checked").val(), 
		tip_contribuyente_op: "guardar"
	},
	function(data)
	{
		$("#tip_contribuyente_guardar_datos").html(data);
		$("#id_tip_contribuyente").focus();
	})
}
	
function limpiar_tip_contribuyente()
{
	$("#id_tip_contribuyente").val("");
	$("#des_tip_contribuyente").val("");
	$("#id_tip_contribuyente").focus();
}