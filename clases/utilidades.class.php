<?php
class utilidades
{

function existe_tabla($nombreTabla)
{
$sql="select relname as tabla from pg_stat_user_tables where relname='$nombreTabla'";
$resultado=pg_query($sql);
$tabla=pg_fetch_assoc($resultado);
if($tabla['tabla'])
 return 1;
 else
  return 0;
}

function borrar_tabla($nombre_tabla,$codigo_oficina)
{
   $sql="drop table $nombre_tabla";
   pg_query($sql);

}

///////////////////////////////////////////////////////////////
function seleccionarCombo($sql,$nombre,$accion,$valor_buscado,$readonly,$retornar)
{
$resultado=pg_query($sql);
$combo= "<select name='$nombre' id='$nombre' $accion $readonly style='width:100%'>";
$combo.= "<option value=''>Seleccione...</option>";
while(($datos=pg_fetch_row($resultado))>0)
{
if($valor_buscado==$datos[0])
{
 $seleccionada='selected=selected';
 $des=$datos[1];
}
 else
 $seleccionada='';

$combo.= "<option value='$datos[0]' $seleccionada> $datos[0] - $datos[1] </option>";
}
$combo.= "</select>";

if($retornar==1)
	return $combo;
else
	echo $combo;
}
function seleccionarCombo_original($sql,$nombre,$accion,$valor_buscado,$readonly,$retornar)
{
$resultado=pg_query($sql);
$combo= "<select name='$nombre' id='$nombre' $accion $readonly style='width:100%'>";
$combo.= "<option value=''>Seleccione...</option>";
while(($datos=pg_fetch_row($resultado))>0)
{
if($valor_buscado==$datos[0])
 $seleccionada='selected=selected';
 else
 $seleccionada='';

$combo.= "<option value='$datos[0]' $seleccionada> $datos[0] - $datos[1] </option>";
}
$combo.= "</select>";

if($retornar==1)
	return $combo;
else
	echo $combo;
}

function seleccionarComboMultiple($sql,$nombre,$accion,$valor_buscado,$readonly,$retornar)
{
$resultado=pg_query($sql);
$combo= "<select name='$nombre' id='$nombre' $accion $readonly size='18' multiple='multiple'>";
while(($datos=pg_fetch_row($resultado))>0)
{
if($valor_buscado==$datos[0])
 $seleccionada='selected=selected';
 else
 $seleccionada='';

$combo.= "<option value='$datos[0]' $seleccionada> $datos[0] - $datos[1] </option>";
}
$combo.= "</select>";

if($retornar==1)
	return $combo;
else
	echo $combo;
}

/* combo recargado
*/
function seleccionarComboRecargado($sql,$nombre,$accion,$valor_buscado,$readonly,$retornar)
{
$resultado=pg_query($sql);

$combo= "<select name='$nombre' id='$nombre' $accion $readonly style='width:100%'> ";
$combo.= "<option value=''>Seleccione...</option>";
while(($datos=pg_fetch_row($resultado))>0)
{
if($valor_buscado==$datos[0])
 $seleccionada='selected=selected';
 else
 $seleccionada='';

$combo.= "<option value='$datos[0]--$datos[1]' $seleccionada> $datos[0] - $datos[1] </option>";
}
$combo.= "</select>";

if($retornar==1)
	return $combo;
else
	echo $combo;
}

/////////////////////////////////////////////////////////////////
function validarDato($dato,$tabla,$campo,$campo2,$campo_condicion,$valor_condicion)
{
/*
accion:"validar",   
dato:             Es el valor que quiero buscar en el select
tabla:            Es la tabla a la cual quiero buscar
campo:            Es el la columna de la BD que será comparada con dato 
campo2:           Si queremos obtener un segundo valor del select usamos este campo         
campo_condicion:  Es la segunda columna de la BD que queremos buscar
valor_condicion:  Es el valor de la segunda columna que estamos buscando
*/

if($campo2!="")
$campo2=",".$campo2;

if($valor_condicion!="")
$condicion=" and $campo_condicion='$valor_condicion'";

$truco=@explode(" and ",$campo);//para ver si tiene una inyeccion sql 
if(empty($truco[1]))
$campox=$campo;
else
$campox=$truco[1];


$sql="select $campox $campo2 from $tabla where $campo='$dato' $condicion";
$resultado=pg_query($sql);
$datos=pg_fetch_row($resultado);
if($datos[0]=="" || $datos[0]=="undefined")
echo "0#$ NO EXISTE EL DATO";
else
echo "1#$ ".$datos[1];

}
/////////////////////////////////////////////////////////////////

function descripcion_toma($codigo)
{
 switch($codigo)
 {
 case '1': return "ACTIVO"; break;
 case '2': return "INACTIVO"; break;
 case '3': return "CORTADO"; break;
 case '4': return "RETIRADO"; break;
 case '5': return "RETIRO VOLUNTARIO"; break;
 case '9': return "ELIMINADO"; break;
 }

}
////////////////////////////////////////////////////////////////
function restar_fechas($ano1,$mes1,$dia1,$ano2,$mes2,$dia2)
{

//calculo timestam de las dos fechas
$timestamp1 = @ mktime(0,0,0,$mes1,$dia1,$ano1);
$timestamp2 = @ mktime(4,12,0,$mes2,$dia2,$ano2);

//resto a una fecha la otra
$segundos_diferencia = $timestamp1 - $timestamp2;
//echo $segundos_diferencia;

//convierto segundos en días
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

//obtengo el valor absoulto de los días (quito el posible signo negativo)
$dias_diferencia = abs($dias_diferencia);

//quito los decimales a los días de diferencia
$dias_diferencia = floor($dias_diferencia);

return $dias_diferencia+1;
}

function codigo_usuario($login)
{
 $sql="select codintusu from pardefusu where trim(logemp)='".strtoupper($login)."'";
 $resultado=pg_query($sql);
 $datos=pg_fetch_assoc($resultado);
 return $datos['codintusu'];
}

///////////////////////////////////////////////////////////////

function restarMeses($fecha,$restar){

$mes=explode("-",$fecha);
$year=$mes[2];
$resta=$mes[1]-6;
if ($resta==0)
{
	$year=$year-1;
	$m='12';
	$dia='01';
}
if ($resta>=1)
{
	$year=$year;
        $me=(int)$mes[1];
	$m=$me-6;
	$dia='01';
}
if ($resta<0)
{
	$year=$year-1;
	$m=12+$resta;
	$dia='01';
}


return $year."-".$m."-".$dia;

}

function buscar_datos($sentencia)
{
	$resultado=pg_query($sentencia);
	$datos=pg_fetch_assoc($resultado);
	//echo $sentencia;
 	return $datos;
}

function restar_dias($fecha,$dias){
return date("Y-m-d", strtotime("$fecha -$dias day")); 
}

function resta_fechas($dFecIni, $dFecFin)
{
    $dFecIni = str_replace("-","",$dFecIni);
    $dFecIni = str_replace("/","",$dFecIni);
    $dFecFin = str_replace("-","",$dFecFin);
    $dFecFin = str_replace("/","",$dFecFin);

    @ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
    @ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

    $date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
    $date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);

    return round(($date2 - $date1) / (60 * 60 * 24));
}

function des_uso($desuso)
{
$largo=strlen(trim($desuso));
$uso=substr($desuso,0,3)."-".trim(substr(trim($desuso),$largo-2,2));
return($uso);
}


//////////////////////////////////////////////////////////////
function voltear_fecha($fecha)
{
  $f=explode("-",$fecha);
  $fecha=$f[2]."-".$f[1]."-".$f[0];
  return $fecha;	
}

////////////////////////////////////
function rellenar_espacios($cadena, $longitud_relleno, $caracter_de_relleno, $modo_de_relleno)
{
   $espacios="";
   for($i=0;$i<$longitud_relleno;$i++)
   {
	  $espacios.=$caracter_de_relleno;
   } 
   if($modo_de_relleno=="izquierda")
     $cadena=$espacios.$cadena;
	   else   
	   if($modo_de_relleno=="derecha")
     	$cadena=$cadena.$espacios; 
		else
		  echo "El modo de relleno es incorrecto!!!"; 
		
  
   return $cadena;
}


}
?>