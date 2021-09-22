parent.location.hash = '';
function verificar_parroquia(accion)
{
	$.post("vistas/parametrizacion/general/parroquias/datos_parroquias.php",
	{
		id_parroquia_p: $("#id_parroquia_p").val(), 
		id_provincia_p: $("#id_provincia_p").val(), 
		id_canton_p: $("#id_canton_p").val(), 
		des_parroquia_p: $("#des_parroquia_p").val(),
		sta_parroquia_p: $("input[name='sta_parroquia_p']:checked").val(), 
		parroquia_op: accion
	},
	
	function(data)
	{
		$("#parroquias").html(data);
		if ($("#id_parroquia_p").val()!="")
		{
			$("#des_parroquia_p").focus();
		}
		else
		{
			$("#id_parroquia_p").focus();
		}
	});
	
}
	
function busca_cantones()
{
	$.post("vistas/parametrizacion/general/parroquias/busca_cantones.php",
	{
		id_provincia_p: $("#id_provincia_p").val(), 
		id_canton_p: $("#id_canton_p").val(), 
		id_parroquia_p: $("#id_parroquia_p").val(), 
		des_parroquia_p: $("#des_parroquia_p").val(), 
		sta_parroquia_p: $("input[name='sta_parroquia_p']:checked").val(), 
		parroquia_op: "buscar"
	},
	
	function(data)
	{
		$("#cantones").html(data);
	});
}
	
function guardar_parroquia()
{
	if (($("#id_provincia_p").val()=="") || ($("#id_canton_p").val()=="") || ($("#id_parroquia_p").val()=="") || ($("#des_parroquia_p").val()=="") || ($("#input[name='sta_parroquia_p']:checked").val()=="")){
		swal('Error al guardar', 'Por favor verifique los campos', 'error')
		return;
	}
	
	$.post("vistas/parametrizacion/general/parroquias/datos_parroquias.php",
	{
		id_provincia_p: $("#id_provincia_p").val(), 
		id_canton_p: $("#id_canton_p").val(), 
		id_parroquia_p: $("#id_parroquia_p").val(), 
		des_parroquia_p: $("#des_parroquia_p").val(), 
		sta_parroquia_p: $("input[name='sta_parroquia_p']:checked").val(), 
		parroquia_op: "guardar"
	},

	function(data)
	{
		$("#parroquia_guardar_datos").html(data);
		$("#id_provincia_p").focus();
	});
}
	
function limpiar_parroquia()
{	
	$("#id_provincia_p").val("");
	$("#id_canton_p").val("");
	$("#id_parroquia_p").val("");
	$("#des_parroquia_p").val("");
	$("#sta_parroquia_p").val("");		
	$("#id_provincia_p").focus();
	
	$.post("vistas/parametrizacion/general/parroquias/busca_cantones.php",
	{
		id_provincia_p: "", 
		id_canton_p: "" 
	},
	
	function(data)
	{
		$("#cantones").html(data);
	});
}