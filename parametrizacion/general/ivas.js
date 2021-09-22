parent.location.hash = '';
function verificar_iva(accion)
{
	$.post("vistas/parametrizacion/general/ivas/datos_ivas.php",
	{
		id_iva: $("#id_iva").val(), 
		des_iva: $("#des_iva").val(),
		mon_iva: $("#mon_iva").val(),
		let_iva: $("#let_iva").val(),
		ley_iva: $("#ley_iva").val(),
		sta_iva: $("input[name='sta_iva']:checked").val(), 
		iva_op: accion
	},
	
	function(data)
	{
		$("#ivas").html(data);
		if ($("#id_iva").val()!="")
		{
			$("#des_iva").focus();
		}
		else
		{
			$("#id_iva").focus();
		}
	});
	
}
	
function guardar_iva()
{
	if (($("#id_iva").val()=="") || ($("#des_iva").val()=="" ) || ($("#sta_iva").val()=="" ) || ($("#mon_iva").val()=="" ) || ($("#let_iva").val()=="" ) || ($("#ley_iva").val()=="" )){
		swal('Error al guardar:', 'Por favor verifique los campos', 'error');
		return;
	}
	$.post("vistas/parametrizacion/general/ivas/datos_ivas.php",
	{
		
		id_iva: $("#id_iva").val(), 
		des_iva: $("#des_iva").val(),
		mon_iva: $("#mon_iva").val(),
		let_iva: $("#let_iva").val(),
		ley_iva: $("#ley_iva").val(),
		sta_iva: $("input[name='sta_iva']:checked").val(), 
		iva_op: "guardar"
	},
	function(data)
	{
		$("#iva_guardar_datos").html(data);
		$("#id_iva").focus();
	})
}
function valida_monto_iva(){
	if(document.getElementById('mon_iva').value!='')
	{
		$.post("controlador.php",{
		mon_iva: $("#mon_iva").val(),
		accion: "validar_mon_iva"
			},
			function(data){
			$("#monto").html(data);
			});	
	}
}
function valida_letra_iva(){
	if(document.getElementById('let_iva').value!='')
	{
		$.post("controlador.php",{
		let_iva: $("#let_iva").val(),
		accion: "validar_let_iva"
			},
			function(data){
			$("#letra").html(data);
			});	
	}
}
	
function limpiar_iva()
{
	$("#id_iva").val("");
	$("#des_iva").val("");
	$("#mon_iva").val("");
	$("#let_iva").val("");
	$("#ley_iva").val("");	
	$("#id_iva").focus();
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


