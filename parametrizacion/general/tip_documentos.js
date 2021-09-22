parent.location.hash = '';
function verificar_tip_documento(accion)
{
	$.post("vistas/parametrizacion/general/tip_documentos/datos_tip_documentos.php",
	{
		id_tip_documento: $("#id_tip_documento").val(), 
		des_tip_documento: $("#des_tip_documento").val(),
		sta_tip_documento: $("input[name='sta_tip_documento']:checked").val(), 
		tip_documento_op: accion
	},
	
	function(data)
	{
		$("#tip_documentos").html(data);
		if ($("#id_tip_documento").val()!="")
		{
			$("#des_tip_documento").focus();
		}
		else
		{
			$("#id_tip_documento").focus();
		}
	});
	
}
	
function guardar_tip_documento()
{
	if (($("#id_tip_documento").val()=="") || ($("#des_tip_documento").val()=="" )  || ($("#sta_tip_documento").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/general/tip_documentos/datos_tip_documentos.php",
	{
		id_tip_documento: $("#id_tip_documento").val(), 
		des_tip_documento: $("#des_tip_documento").val(),
		sta_tip_documento: $("input[name='sta_tip_documento']:checked").val(), 
		tip_documento_op: "guardar"
	},
	function(data)
	{
		$("#tip_documento_guardar_datos").html(data);
		$("#id_tip_documento").focus();
	})
}
	
function limpiar_tip_documento()
{
	$("#id_tip_documento").val("");
	$("#des_tip_documento").val("");
	$("#id_tip_documento").focus();
}