// JavaScript Document

function par_buscar_proveedor(){	
	if(document.getElementById('par_id_proveedor').value!='')
	{
		$.post("vistas/compras/proveedores/datos_proveedores.php",{
			par_id_proveedor : $("#par_id_proveedor").val()
		},
			function(data){
			$("#par_cuerpo_datos_proveedores").html(data);
			});			
	}
	else
	{
	swal("Ingrese el número del documento de proveedor", "Por Favor verifique", "warning")
	}
}

function par_prov_guardar(){
	
	if(document.getElementById('par_id_proveedor').value!='' && document.getElementById('par_nomproveedor').value!='' && document.getElementById('par_id_provincia').value!='' && document.getElementById('par_id_canton').value!='' && document.getElementById('par_id_parroquia').value!='' && document.getElementById('par_dirproveedor').value!='' && document.getElementById('par_celproveedor').value!='' && document.getElementById('par_id_tip_contribuyente').value!='')
	{
		$.post("controlador.php",{	
		par_id_proveedor  : $("#par_id_proveedor").val(),
		par_nomproveedor: $("#par_nomproveedor").val(),
		par_provincia: $("#par_id_provincia").val(),
		par_canton: $("#par_id_canton").val(),
		par_parroquia: $("#par_id_parroquia").val(),		
		par_dirproveedor  : $("#par_dirproveedor").val(),
		par_celproveedor  : $("#par_celproveedor").val(),
		par_emailproveedor : $("#par_emailproveedor").val(),
		par_contacto : $("#par_contacto").val(),
		par_per_contacto : $("#par_per_contacto").val(),
		par_tip_contribuyente : $("#par_id_tip_contribuyente").val(),
		par_dias_credito  : $("#par_dias_credito").val().replace(/\,/g,''),
		par_lim_credito  : $("#par_lim_credito").val().replace(/\,/g,''),
		par_estaproveedor : $("input[name='par_estaproveedor']:checked").val(),
		accion: "par_guardar_proveedores" 
		},
			function(data){
			$("#par_guardar_proveedor").html(data);
			});
			
	}
	else
	{
	swal("Faltan datos por ingresar", "Por favor verifique los campos obligatorios", "warning")
	}
}
function par_busca_cantones_p()
{
	$.post("vistas/compras/proveedores/busca_cantones_p.php",{
	par_id_provincia : $("#par_id_provincia").val()
		},
		function(data){
			$("#par_busca_cantones_div").html(data);
		});			
}
function par_busca_parroquias_p()
{
		$.post("vistas/compras/proveedores/busca_parroquias_p.php",{
			par_id_provincia : $("#par_id_provincia").val(),
			par_id_canton : $("#par_id_canton").val()
		},
			function(data){
			$("#par_busca_parroquias_div").html(data);
			});			
}

function par_prov_limpiar()
{
	document.getElementById('par_id_proveedor').value=""
	document.getElementById('par_id_proveedor').focus()		
	document.getElementById("par_cuerpo_datos_proveedores").innerHTML="";
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


