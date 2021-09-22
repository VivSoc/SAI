parent.location.hash = '';
function verificar_parroquia(accion)
{
	$.post("vistas/parametrizacion/general/parroquias/datos_parroquias.php",
	{
		id_parroquia: $("#id_parroquia").val(), 
		des_parroquia: $("#des_parroquia").val(),
		sta_parroquia: $("input[name='sta_parroquia']:checked").val(), 
		parroquia_op: accion
	},
	
	function(data)
	{
		$("#parroquias").html(data);
		if ($("#id_parroquia").val()!="")
		{
			$("#des_parroquia").focus();
		}
		else
		{
			$("#id_parroquia").focus();
		}
	});
	
}
	
function busca_cantones()
{
	$.post("vistas/parametrizacion/general/select_cantones.php",
	{
		id_provincia: $("#id_provincia").val(), 
		id_canton: $("#id_canton").val(), 
		id_parroquia: $("#id_parroquia").val(), 
		des_parroquia: $("#des_parroquia").val(), 
		sta_parroquia: $("input[name='sta_parroquia']:checked").val(), 
		parroquia_op: "buscar"
	},
	
	function(data)
	{
		$("#cantones").html(data);
	});
}
function guardar_parroquia()
{
	if (($("#id_parroquia").val()=="") || ($("#des_parroquia").val()=="" )  || ($("#sta_parroquia").val()=="" )){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	$.post("vistas/parametrizacion/general/parroquias/datos_parroquias.php",
	{
		id_parroquia: $("#id_parroquia").val(), 
		des_parroquia: $("#des_parroquia").val(),
		sta_parroquia: $("input[name='sta_parroquia']:checked").val(), 
		parroquia_op: "guardar"
	},
	function(data)
	{
		$("#parroquia_guardar_datos").html(data);
		$("#id_parroquia").focus();
	})
}
	
function limpiar_parroquia()
{
	$("#id_parroquia").val("");
	$("#des_parroquia").val("");
	$("#id_parroquia").focus();
}