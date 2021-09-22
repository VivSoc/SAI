// JavaScript Document

function buscar_cliente(){	
	if(document.getElementById('id_cliente').value!='')
	{
		$.post("vistas/ventas/clientes/datos_clientes.php",{
			id_cliente : $("#id_cliente").val()
		},
			function(data){
			$("#cuerpo_datos_clientes").html(data);
			});			
	}
	else
	{
	swal("Ingrese el número del documento de cliente", "Por Favor verifique", "warning")
	}
}
function detalle_clientes(){
	$.post("clientes/detalle_clientes.php",{
		},
			function(data){
			$("#guardar_cliente").html(data);
			});
}
function par_cli_guardar(){
	
	if(document.getElementById('id_cliente').value!='' && document.getElementById('nomcliente').value!='' && document.getElementById('id_provincia').value!='' && document.getElementById('id_canton').value!='' && document.getElementById('id_parroquia').value!='' && document.getElementById('dircliente').value!='' && document.getElementById('celcliente').value!='' && document.getElementById('id_tip_contribuyente').value!='')
	{
		$.post("controlador.php",{	
		id_cliente  : $("#id_cliente").val(),
		nomcliente: $("#nomcliente").val(),
		provincia: $("#id_provincia").val(),
		canton: $("#id_canton").val(),
		parroquia: $("#id_parroquia").val(),		
		dircliente  : $("#dircliente").val(),
		celcliente  : $("#celcliente").val(),
		emailcliente : $("#emailcliente").val(),
		tip_contribuyente : $("#id_tip_contribuyente").val(),
		dias_credito  : $("#dias_credito").val().replace(/\,/g,''),
		lim_credito  : $("#lim_credito").val().replace(/\,/g,''),
		estacliente : $("input[name='estacliente']:checked").val(),
		accion: "guardar_clientes" 
		},
			function(data){
			$("#guardar_cliente").html(data);
			});
			
	}
	else
	{
	swal("Faltan datos por ingresar", "Por favor verifique los campos obligatorios", "warning")
	}
}
function busca_cantones()
{
	$.post("vistas/ventas/clientes/busca_cantones.php",{
	id_provincia : $("#id_provincia").val()
		},
		function(data){
			$("#busca_cantones_div").html(data);
		});			
}
function busca_parroquias()
{
		$.post("vistas/ventas/clientes/busca_parroquias.php",{
			id_provincia : $("#id_provincia").val(),
			id_canton : $("#id_canton").val()
		},
			function(data){
			$("#busca_parroquias_div").html(data);
			});			
}

function par_cli_limpiar()
{
	document.getElementById('id_cliente').value=""
	document.getElementById('id_cliente').focus()		
	document.getElementById("cuerpo_datos_clientes").innerHTML="";
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
$('input').focus(function() {
    // the select() function on the DOM element will do what you want
    this.select();
});
$('input').click(function() {
    // the select() function on the DOM element will do what you want
    this.select();
});


