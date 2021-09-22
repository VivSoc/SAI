/*Funciones para el modulo de
 productos*/
 $('input').focus(function() {
    // the select() function on the DOM element will do what you want
    this.select();
});
$('input').click(function() {
    // the select() function on the DOM element will do what you want
    this.select();
});

$(function () 
{
    $("#fec_caducidad").datepicker({
        dateFormat: 'dd/mm/yy',//Puedes poner el formato que deseas(dd.mmm.yy | mm/dd/yy | dd-mm-yy ETC)
        onSelect: function (dateText, inst) {
            finicio = fecdoc; //Ésta variable la puedes enviar a tu controlador siempre con el valor actual.
        }
    });	
}

);

function buscar_producto()
{	
	if(document.getElementById('parcodpro').value!='')
	{
		var codpro=document.getElementById('parcodpro').value
	}
	else
	{
		document.getElementById('parcodpro').value='NUEVO'
		document.getElementById('parcodpro').disabled=true;		
		var codpro="NUEVO"
	}
	$.post("vistas/parametrizacion/inventario/productos/datos_productos.php",{
		parcodpro : codpro
		},
		function(data){
		$("#cuerpo_datos_productos").html(data);
		});
}
function detalle_productos(){
	$.post("productos/detalle_productos.php",{
		},
			function(data){
			$("#cuerpo_der").html(data);
			});
}

function par_productos_guardar()
{var datos_vacios=0

var datos=	document.getElementsByTagName("input")
for(var i=0;i<datos.length;i++)
{
	if(datos[i].lang=='s')
	{
		if (datos[i].value=="" || datos[i].value=="0.00")
		{
			var mensaje="Por favor verifique el siguiente campo: "+datos[i].name
			swal(mensaje,"","warning")
			datos_vacios=1
		}
	}
}
if(datos_vacios==0)
{
	if (document.getElementById("parprodscto").checked)
		val_check="S"
	else
		val_check="N"
		
  $.post("controlador.php",{
		  parcodpro: $("#parcodpro").val(),
	  	  partippro: $("input[name='partippro']:checked").val(),
		  parcodcat: $("#parcodcat").val(),
		  parcodmarca: $("#parcodmarca").val(),
		  parcodmodelo: $("#parcodmodelo").val(),
		  parcodtamano: $("#parcodtamano").val(),
		  parcodforma: $("#parcodforma").val(),
		  parcodmaterial: $("#parcodmaterial").val(),
		  parcodcolor: $("#parcodcolor").val(),
		  parcodpresenta: $("#parcodpresenta").val(),
		  parcodorigen: $("#parcodorigen").val(),
		  parcodpropieta: $("#parcodpropieta").val(),
		  parcodubica: $("#parcodubica").val(),
		  parpeso: $("#parpeso").val().replace(/\,/g,''),
		  parcodpes: $("#parcodpes").val(),		  
		  pardesproc: $("#pardesproc").val(),
		  pardesprol: $("#pardesprol").val(),
		  parprecompra: $("#parprecompra").val().replace(/\,/g,''),
		  parprevendet: $("#parprevendet").val().replace(/\,/g,''),
		  parprevenmay: $("#parprevenmay").val().replace(/\,/g,''),
		  parmoniva: $("#parmoniva").val(),
		  parssctomax: $("#parssctomax").val().replace(/\,/g,''), 
		  parcanpro: $("#parcanpro").val().replace(/\,/g,''),
		  parcodunidad: $("#parcodunidad").val(),
		  parcanmin: $("#parcanmin").val().replace(/\,/g,''),
		  parcanmax: $("#parcanmax").val().replace(/\,/g,''),
		  parstapro: $("input[name='Estatus']:checked").val(),
		  num_lote: $("#num_lote").val(),
		  can_lote: $("#can_lote").val(),
		  id_alterno: $("#id_alterno").val(),
		  fec_caducidad: $("#fec_caducidad").val(),
		  parfotopro: $("#foto").val(),
		  permite_descuento: val_check,
		  
		  accion: "par_guarda_producto" 
		  },
		  function(data){
		  $("#par_guardar_producto").html(data);
		  });
}
}

function enabled_price()
{
	tipo=$("input[name='partippro']:checked").val()
	if(tipo=='P')
	{
		document.getElementById('parprepro').disabled=false;
	}
	else
	{
		document.getElementById('parprepro').value='0.00';
		document.getElementById('parprepro').disabled=true;
	}
}

function par_productos_limpiar()
{
	document.getElementById('parcodpro').value='';
	document.getElementById('parcodpro').disabled=false;
	document.getElementById('parcodpro').focus();
	document.getElementById('parpeso').value='';
	document.getElementById('parcodpes').value='';
	document.getElementById('pardesproc').value='';
	document.getElementById('parprecompra').value='';
	document.getElementById('parprevendet').value='';
	document.getElementById('parprevenmay').value='';
	document.getElementById('parmoniva').value='';
	document.getElementById('parprodscto').value='';
	document.getElementById('parssctomax').value='';
	document.getElementById('parcanpro').value='';
	document.getElementById('parcodunidad').value='';
	document.getElementById('parcanmin').value='';
	document.getElementById('parcanmax').value='';
	document.getElementById('parstapro').value='';
	document.getElementById('parstapro').value='';
	document.getElementById('foto').value='';
	
	document.getElementById("cuerpo_datos_productos").innerHTML="";

//	detalle_compras();
}
function porcentaje_dscto()
{
	var chequeo=document.getElementById("parprodscto").checked;
	if (chequeo==true)
	{
		document.getElementById('parssctomax').disabled=false
		document.getElementById('parssctomax').focus()
	}	
	else
	{
		document.getElementById('parssctomax').disabled=true
		document.getElementById('parssctomax').value=0.00		
	}

}


function ordenar_tbl_productos(order){
	$.post("productos/detalle_productos.php",{
	orden: order		
	},
		function(data){
		$("#cuerpo_der").html(data);	
		});
}
// Función autocompletar
function autocompletar() {
	var minimo_letras = 1; // minimo letras visibles en el autocompletar
	var palabra = $('#parcodpro').val();
	//Contamos el valor del input mediante una condicional
	if (palabra.length >= minimo_letras) {
		$.ajax({
			url: 'controlador.php',
			type: 'POST',
			data: {palabra:palabra,accion:"auto_comp_producto"},
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
function set_item(opciones) {
	// Cambiar el valor del formulario input
	$('#parcodpro').val(opciones);
	// ocultar lista de proposiciones
	$('#lista_id').hide();
	buscar_producto()
	//document.getElementById('busca_producto').focus()
	
}

function des_larga(id) 
{

//document.getElementById('pardesprol').value=document.getElementById('parcodcat').value.substr(6)+' - '+document.getElementById('parcodmarca').value.substr(6)+' - '+document.getElementById('parcodmodelo').value.substr(6)+' - '+document.getElementById('parcodtamano').value.substr(6)+' - '+document.getElementById('parcodforma').value.substr(6)+' - '+document.getElementById('parcodmaterial').value.substr(6)+' - '+document.getElementById('parcodcolor').value.substr(6)+' - '+document.getElementById('parcodpresenta').value.substr(6)+' - '+document.getElementById('parcodorigen').value.substr(6)
	
}
function busca_datos_lote()
{
	$.post("controlador.php",{	
	num_lote: $("#num_lote").val(),
	id_producto: $("#parcodpro").val(),
	accion: "buscar_datos_lote" 
		  },
		  function(data){
		  $("#par_guardar_producto").html(data);
		  });
	
}

function MASK(e,form, n, mask, format) 
{
tecla = (document.all) ? e.keyCode : e.which;
if (tecla==13)
{
  if (format == "undefined") format = false;
  if (format || NUM(n)) 
  {
    dec = 0, point = 0;
    x = mask.indexOf(".")+1;
    if (x) { dec = mask.length - x; }

    if (dec) 
	{
      n = NUM(n, dec)+"";
      x = n.indexOf(".")+1;
      if (x) { point = n.length - x; } else { n += "."; }
    }else 
	{
      n = NUM(n, 0)+"";
    } 
    for (var x = point; x < dec ; x++) 
	{
      n += "0";
    }
    x = n.length, y = mask.length, XMASK = "";
    while ( x || y ) 
	{
      if ( x ) 
	  {
        while ( y && "#0.".indexOf(mask.charAt(y-1)) == -1 ) 
		{
          if ( n.charAt(x-1) != "-")
            XMASK = mask.charAt(y-1) + XMASK;
          y--;
        }
        XMASK = n.charAt(x-1) + XMASK, x--;
      }else if ( y && "0".indexOf(mask.charAt(y-1))+1 ) 
	  {
        XMASK = mask.charAt(y-1) + XMASK;
      }
      if ( y ) { y-- }
    }
  }else
  {
     XMASK="";
  }
  if (form) 
  { 
    form.value = XMASK;
    if (NUM(n)<0) 
	{
      form.style.color="#FF0000";
    } else {
      form.style.color="#000000";
    }
  }
  return XMASK;
  }
}



function NUM(s, dec) 
{
  for (var s = s+"", num = "", x = 0 ; x < s.length ; x++) 
  {
    c = s.charAt(x);
    if (".-+/*".indexOf(c)+1 || c != " " && !isNaN(c)) { num+=c; }
  }
  if (isNaN(num)) { num = eval(num); }
  if (num == "")  { num=0; } else { num = parseFloat(num); }
  if (dec != undefined) 
  {
    r=.5; if (num<0) r=-r;
    e=Math.pow(10, (dec>0) ? dec : 0 );
    return parseInt(num*e+r) / e;
  }else 
  {
    return num;
  }
}
function previewFile() {
//  var preview = document.querySelector('img');
  var preview = document.getElementById('logo')
  var file    = document.querySelector('input[type=file]').files[0];
  var reader  = new FileReader();

  reader.onloadend = function () {
    preview.src = reader.result;
  }

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
}
