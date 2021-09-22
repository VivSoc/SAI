parent.location.hash = '';
function verificar_tip_usuario(accion)
{
	$.post("vistas/parametrizacion/general/tip_usuarios/datos_tip_usuarios.php",
	{
		id_tip_usuario: $("#id_tip_usuario").val(), 
		des_tip_usuario: $("#des_tip_usuario").val(),
		sta_tip_usuario: $("input[name='sta_tip_usuario']:checked").val(), 
		tip_usuario_op: accion
	},
	
	function(data)
	{
		$("#tip_usuarios").html(data);
		if ($("#id_tip_usuario").val()!="")
		{
			$("#des_tip_usuario").focus();
		}
		else
		{
			$("#id_tip_usuario").focus();
		}
	});
	
}
	
function guardar_tip_usuario()
{
	if (($("#id_tip_usuario").val()=="") || ($("#des_tip_usuario").val()=="" )  || ($("#sta_tip_usuario").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/general/tip_usuarios/datos_tip_usuarios.php",
	{
		id_tip_usuario: $("#id_tip_usuario").val(), 
		des_tip_usuario: $("#des_tip_usuario").val(),
		sta_tip_usuario: $("input[name='sta_tip_usuario']:checked").val(), 
		tip_usuario_op: "guardar"
	},
	function(data)
	{
		$("#tip_usuario_guardar_datos").html(data);
		$("#id_tip_usuario").focus();
	})
}
	
function limpiar_tip_usuario()
{
	$("#id_tip_usuario").val("");
	$("#des_tip_usuario").val("");
	$("#id_tip_usuario").focus();
}