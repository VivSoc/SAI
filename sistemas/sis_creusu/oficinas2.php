<?php 
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");

$page = @$_GET['page']; // para recuperar la página solicitada
$limit = @$_GET['rows']; // obtiene el número de filas que queremos tener en la grilla
$sidx = @$_GET['sidx']; // indica la columna por la cual se va a ordenar la grilla
$sord = @$_GET['sord']; // devuelve la forma de ordenar (asc o desc)

$sql = "SELECT
			codintusu
		FROM
			pardefusu
		WHERE
			cedusu = '".$_SESSION["scu_cedusu"]."'";
$result=pg_query($bd_conexion,$sql);

if (pg_num_rows($result)>0)
{
	$codintusu = pg_result($result,0,"codintusu");
}
else 
{
	$codintusu = "";
}
if(!$sidx)
{
	$sidx =1; 
}
	
if($limit == 0)
{
	$limit = 10;
}

$sql = "SELECT
			A.codofi,
			A.nomofi,
			CASE WHEN 
				B.codintusu <> '' THEN '1'
				ELSE '0'
			END as condicion
		FROM
			paroficom A
		LEFT JOIN
			segusuofi B
		ON 
			A.codofi = B.codofi AND
			B.codintusu = '".$codintusu."'
		ORDER BY
			A.codofi";
			var_dump($sql);
$result = pg_query($bd_conexion,$sql); 

$count = pg_num_rows($result);
	
if( $count >0 ) 
{ 
	$total_pages = ceil($count/$limit); 
} 
else 
{ 
	$total_pages = 0; 
} 
	
if ($page > $total_pages)
{
	$page=$total_pages; 
}
	
$start = $limit*$page - $limit;
	
if (@$_REQUEST["_search"] == "true")
{
	switch (@$_REQUEST["searchOper"])
	{
		case "eq": 
		{  
			$texto = @$_REQUEST["searchField"]." = '".@$_REQUEST["searchString"]."' ";  
			break;
		}
		case "ne": 
		{  
			$texto = @$_REQUEST["searchField"]." <> '".@$_REQUEST["searchString"]."' ";  
			break;
		}
		case "lt": 
		{  
			$texto = @$_REQUEST["searchField"]." < '".@$_REQUEST["searchString"]."' ";  
			break;
		}
		case "le": 
		{  
			$texto = @$_REQUEST["searchField"]." <= '".@$_REQUEST["searchString"]."' ";  
			break;
		}
		case "gt": 
		{  
			$texto = @$_REQUEST["searchField"]." > '".@$_REQUEST["searchString"]."' ";  
			break;
		}
		case "ge": 
		{  
			$texto = @$_REQUEST["searchField"]." >= '".@$_REQUEST["searchString"]."' ";  
			break;
		}
		case "in": 
		{  
			$texto = @$_REQUEST["searchField"]." in ('".@$_REQUEST["searchString"]."') ";  
			break;
		}
		case "ni": 
		{  
			$texto = @$_REQUEST["searchField"]." not in ('".@$_REQUEST["searchString"]."') ";  
			break;
		}
		case "bw": 
		{  
			$texto = @$_REQUEST["searchField"]." ilike '".@$_REQUEST["searchString"]."%' ";  
			break;
		}
		case "bn": 
		{  
			$texto = @$_REQUEST["searchField"]." not ilike '".@$_REQUEST["searchString"]."%' ";  
			break;
		}
		case "ew": 
		{  
			$texto = @$_REQUEST["searchField"]." ilike '%".@$_REQUEST["searchString"]."' ";  
			break;
		}
		case "en": 
		{  
			$texto = @$_REQUEST["searchField"]." not ilike '%".@$_REQUEST["searchString"]."' ";  
			break;
		}
		case "cn": 
		{  
			$texto = @$_REQUEST["searchField"]." ilike '%".@$_REQUEST["searchString"]."%' ";  
			break;
		}
		case "nc": 
		{  
			$texto = @$_REQUEST["searchField"]." ilike '%".@$_REQUEST["searchString"]."%' ";  
			break;
		}
	}

	$sql = "SELECT
				A.codofi,
				A.nomofi,
				CASE WHEN 
					B.codintusu <> '' THEN '1'
					ELSE '0'
				END as condicion
			FROM
				paroficom A
			LEFT JOIN
				segusuofi B
			ON 
				A.codofi = B.codofi AND
				B.codintusu = '".$codintusu."'
			WHERE 
				$texto 
			ORDER BY 
				$sidx $sord 
			LIMIT 
				$limit 
			OFFSET 
				$start";
				var_dump($texto);
	$result = pg_query($bd_conexion,$sql); 
}
else
{
	$sql= "SELECT
				A.codofi,
				A.nomofi,
				CASE WHEN 
					B.codintusu <> '' THEN '1'
					ELSE '0'
				END as condicion
			FROM
				paroficom A
			LEFT JOIN
				segusuofi B
			ON 
				A.codofi = B.codofi AND
				B.codintusu = '".$codintusu."'
			ORDER BY 
				$sidx $sord 
			LIMIT 
				$limit 
			OFFSET 
				$start";
	$result = pg_query($bd_conexion,$sql); 
}
$responce->page = $page; 
$responce->total = $total_pages; 
$responce->records = $count; 
$i=0; 
	

while($row = pg_fetch_assoc($result)) 
{ 
	$responce->rows[$i]['id']=$row["codofi"];
	$responce->rows[$i]['cell']=array($row["codofi"],$row["nomofi"],$row["condicion"]); 
	$i++; 
} 
		
echo json_encode($responce); 
?>
