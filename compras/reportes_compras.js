
$(function () {
    $("#rep_comp_fecdes").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdes; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });
    $("#rep_comp_fechas").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdes; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });
	$("#repcomp_fecdes").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdes; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });
    $("#repcomp_fechas").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdes; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });

});

function imprimir_rep_compras() // general
{	
	texto='reportes/compras/rep_compras.php'+
	"?repcompfecdes="+document.getElementById('repcomp_fecdes').value+
	"&repcompfechas="+document.getElementById('repcomp_fechas').value;			
		window.open(texto);
	
}	
function imprimir_rep_det_compras() // detalladdo
{	
	texto='reportes/compras/detalle_compras.php'+
	"?repcomp_fecdes="+document.getElementById('rep_comp_fecdes').value+
	"&repcomp_fechas="+document.getElementById('rep_comp_fechas').value+
	"&rep_comp_idproveedor="+document.getElementById('rep_comp_id_proveedor').value;			
		window.open(texto);
	
}	

// Función autocompletar
function auto_rep_det_comp() {
	var minimo_letras = 1; // minimo letras visibles en el autocompletar
	var palabra = $('#rep_comp_id_proveedor').val();
	//Contamos el valor del input mediante una condicional
	if (palabra.length >= minimo_letras) {
		$.ajax({
			url: 'controlador.php',
			type: 'POST',
			data: {palabra:palabra,accion:"rep_det_compra"},
			success:function(data){
				$('#lista_id').show();
				$('#lista_id').html(data);
			}
		});
	} else {
		//ocultamos la lista
		$('#lista_id').hide();
	}
}

// Funcion Mostrar valores
function set_item_rep_comp(opciones) {
	// Cambiar el valor del formulario input
	$('#rep_comp_id_proveedor').val(opciones);
	// ocultar lista de proposiciones
	$('#lista_id').hide();
	buscar_producto()
	//document.getElementById('busca_producto').focus()
	
}

