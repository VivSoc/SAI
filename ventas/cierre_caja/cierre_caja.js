function cierre_caja(){
	$.post("vistas/ventas/cajas/cierre_caja/datos_cierre_caja.php",{
		},
			function(data){
			$("#cuerpo_cierre_caja").html(data);
			});
}
function detalle_cierre_caja(){
	$.post("ventas/cierre_caja/detalle_cierre_caja.php",{
		},
			function(data){
			$("#cuerpo_der").html(data);
			});
	
}
function buscar_cierre_caja(){
	if(document.getElementById('cie_caja_cod_caja').value!='')
	{
		$.post("controlador.php",{
		codcaja  : $("#cie_caja_cod_caja").val(),
		accion: "busca_cie_caja" 
		},
			function(data){
			$("#cuerpo_cierre_caja").html(data);
			});
	}
	else
	{
	swal("Debe ingresar el código de la caja","","warning");l
	}
}

function cerrar_caja(){
	var montos=new Array();
	var idpago=new Array();
	var can_pagos=document.getElementById("cie_caj_pagos").value
	if(document.getElementById('cie_caja_cod_caja').value=='')
	{
		swal("Debe ingresar el código de la caja a cerrar","","warning");
	}
	else 
	{
		for(var i=1;i<=can_pagos;i++)
  	{
		if(document.getElementById("monto_pago"+i).value>0)
		{
		   idpago[i] = document.getElementById("cierre_caja_id_pago"+i).value;
		   montos[i] = document.getElementById("cierre_caja_monto_pago"+i).value;
		}				
   }
	swal({
		title: '¿Desea cerrar caja?',
		text: 'Verifique que los datos sean Correctos',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Si, Seguro!',
		cancelButtonText: 'No!',
		closeOnConfirm: true,
		closeOnCancel: true
	  },
	  function(isConfirm){
		if (isConfirm) {
		  $.post("controlador.php",{	  
		  idpago:idpago,
		  monpago:montos,
		  pagos:$("#cie_caj_pagos").val(),
		  feccie: $("#fec_cie_caja").val(),
		  cedusuario : $("#cie_caja_ced_usuario").val(),	
		  codcaja: $("#cie_caja_cod_caja").val(),
		
		accion: "cierra_caja" 
		  },
		  function(data){
		  $("#cuerpo_cierre_caja").html(data);
//aqui mando a llamar al reporte del cierre de caja
		  });
		}
	  });	
	}

}
function imprimir_cierre(codcie)
{
	pagina="../reportes/cierre_caja/cierre_caja.php";
	pagina+="?codcie="+codcie;
	window.open(pagina,'cierre_caja')
	limpiar_cie_caja()
	
}

function limpiar_cie_caja()
{
	document.getElementById('cie_caja_cod_caja').value='';
	document.getElementById('cie_caja_cod_caja').focus();
	document.getElementById("cuerpo_cierre_caja").innerHTML="";
}

function ordenar_tbl_cajas_cerradas(order){
	$.post("ventas/cierre_caja/detalle_cierre_caja.php",{
	orden: order		
	},
		function(data){
		$("#cuerpo_der").html(data);	
		});

}