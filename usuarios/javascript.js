// JavaScript Document
function submit_creacion_usuarios()
{
  if($("#mod_usu_cedula").val()=="" || $("#mod_usu_sistema").val()=="")
  {
	 alert("Debe Ingresar la Cedula y Oficina Comercial")
	 return  
  }	 
	
       $.post("vistas/usuarios/cargar_permisologia.php",
       {
       mod_usu_cedula: $("#mod_usu_cedula").val(),
	   mod_usu_sistema: $("#mod_usu_sistema").val()
       },
       function(data){
	     $("#usuarios_creacion").html(data); 
         }
      );	
}

function guardar_permisos_usuario()
{
	var total=document.getElementsByTagName("input").length
	var input=document.getElementsByTagName("input")
	var codacc=new Array();
	var aplicacion=new Array();
	var j=0
	for(var i=0;i<total;i++)
	{ 
		
  	  	if(input[i].type=="checkbox")
		{  
		  if(input[i].checked==true)
		    codacc[j]=1
			 else
			   codacc[j]=0
			   
			   
		  aplicacion[j]=input[i].id
		  j++
	    }
		
	}
	
	$.post("vistas/usuarios/guardar_permisologia.php",
       {
       mod_usu_cedula: $("#mod_usu_cedula").val(),
	   mod_log_usu: $("#mod_log_usu").val(),
	   aplicacion:aplicacion,
	   codacc:codacc	   
       },
       function(data){
	     $("#usuarios_creacion").html(data); 
         }
      );	
}
function asignar_permisos(input,accion)
{

 vector=document.getElementById(input).value	
 vector2=vector.split("#")
 tamano=vector2.length-1

 for(var i=0;i<tamano;i++)
 {
	if(document.getElementById(vector2[i]).checked==true && accion==false)
	  document.getElementById(vector2[i]).checked=false
	   else
	   if(document.getElementById(vector2[i]).checked==false && accion==true)
	     document.getElementById(vector2[i]).checked=true		 
 }
	
}



function reporte_permisos_usuarios()
{	
var pagina;
todas=document.getElementById("todas").checked;
pagina="vistas/usuarios/reporte_permisos_usuarios.php";
pagina+="?cedula="+$("#nom_usu").val();
pagina+="&todas="+ todas;


window.open(pagina);

}
