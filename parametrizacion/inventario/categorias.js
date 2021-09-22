parent.location.hash = '';
function verificar_categoria(accion)
{
	$.post("vistas/parametrizacion/inventario/categorias/datos_categorias.php",
	{
		id_categoria: $("#id_categoria").val(), 
		des_categoria: $("#des_categoria").val(),
		pre_categoria: $("#pre_categoria").val(),
		sta_categoria: $("input[name='sta_categoria']:checked").val(), 
		categoria_op: accion
	},
	
	function(data)
	{
		$("#categorias").html(data);
		if ($("#id_categoria").val()!="")
		{
			$("#pre_categoria").focus();
		}
		else
		{
			$("#id_categoria").focus();
		}
	});
	
}
	
function guardar_categoria()
{
	if (($("#id_categoria").val()=="") || ($("#des_categoria").val()=="" )  || ($("#sta_categoria").val()=="" )  || ($("#pre_categoria").val()=="" )){
		swal('Error al guardar:', 'Por favor verifique los campos', 'error');
		return;
	}
	$.post("vistas/parametrizacion/inventario/categorias/datos_categorias.php",
	{
		
		id_categoria: $("#id_categoria").val(), 
		des_categoria: $("#des_categoria").val(),
		pre_categoria: $("#pre_categoria").val(),
		sta_categoria: $("input[name='sta_categoria']:checked").val(), 
		categoria_op: "guardar"
	},
	function(data)
	{
		$("#categoria_guardar_datos").html(data);
		$("#id_categoria").focus();
	})
}
function valida_prefijo_categoria(){
	if(document.getElementById('pre_categoria').value!='')
	{
		$.post("controlador.php",{
		pre_categoria: $("#pre_categoria").val(),
		accion: "validar_pre_categoria"
			},
			function(data){
			$("#prefijo").html(data);
			});	
	}
}
	
function limpiar_categoria()
{
	$("#id_categoria").val("");
	$("#des_categoria").val("");
	$("#pre_categoria").val("");	
	$("#id_categoria").focus();
}