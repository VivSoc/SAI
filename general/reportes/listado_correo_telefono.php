<?php
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/utilidades.class.php");
require("../../../libs/fpdf/fpdf.php");
require("../../../sesion.php");

$objUtilidades=new utilidades;

$oficina=@$_REQUEST['oficina'];

$ccelu=@$_GET['concelu'];
$scelu=@$_GET['sincelu'];
$ccorreo=@$_GET['concorreo'];
$scorreo=@$_GET['sincorreo'];
$rcorreodesde=@$_GET['ruta_desde'];
$rcorreohasta=@$_GET['ruta_hasta'];


//echo '    '.$rcorreodesde.'  '.$rcorreohasta;
class PDF extends FPDF
{
	function Header()
	{
		GLOBAL $bd_conexion;
			
		
		
		$sql="Select nomofi from paroficom where codofi='".@$_REQUEST['oficina']."'";
		$result_ofi=pg_query($bd_conexion,$sql);
		
    	$this->SetFont('Arial','B',10);
		$this->Cell(220,10,'HIDROSUROESTE',0,0,'L');
	
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,'Fecha: '.date("d/m/Y"),0,0,'L');
	
		$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(220,10,'OFICINA: '.@pg_result($result_ofi,0,"nomofi"),0,0,'L');
	
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,'Hora: '.date("h:i:s A"),0,0,'L');
	
		$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(220,10,utf8_decode('GENERAL'),0,0,'L');
	
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'L');
		$this->Ln(10);
	
		$this->SetFont('Arial','B',12);
		
		$this->Cell(245,10,'LISTADO CLIENTES CON CORREO ELECTRONICO O TELEFONO O CELULAR',0,0,'C');

		$this->Ln();
		
		$this->SetFont('Arial','',12);
		$this->Cell(160,10,'Ruta Desde :'.@$_GET['ruta_desde'],0,0,'C');
		
		$this->SetFont('Arial','',12);
		$this->Cell(1,10,'Ruta Hasta :'.@$_GET['ruta_hasta'],0,0,'C');
		

		
		$this->Ln(5);
	
		$this->Ln();
	
	
		$this->Line(6,50,275,50);
		
		$this->SetFillColor(255,255,255,255,255,255,255);
		$this->SetFont('Arial','B',8);
		$this->SetWidths(array(22,60,70,20,22,20,48));
		$this->SetAligns(array('C','C','C','C','C','C','C'));
		$this->Row(array("Cuenta","Nombre","Dirección","CI/RIF","Telefono","Celular","Correo"),5,0);
		$this->Line(6,60,275,60);
		$this->Ln(7);
		$this->SetAligns(array('L','L','L','C','L','L','L'));
	}
	
	//function Footer()
//	{
//    	$this->SetY(-15);
//    	$this->SetFont('Arial','I',8);
//    	$this->Cell(0,10,'reporte_movimiento_cuenta',0,0,'L');
//	}
}
$pdf=new PDF($orientacion='L',$unit='mm',$format=array(215,279));
$pdf->AliasNbPages();
$pdf->AddPage();
$codigo="";
$conta=0;
if($ccelu=="true" and $scelu=="true")
{
}
else
{
	if ($ccelu=="true")
	{
	$codigo=" and  (celper<>'' and celper<>'null') ";
	}
	
	if ($scelu=="true")
	{
	$codigo=" and  (celper='' or celper is null) ";
	}
}
	
$codigo2=" ";
if($ccorreo=="true" and $scorreo=="true")
{
}
else
{
	if ($ccorreo=="true")
	{
	$codigo2=" and  (emaper<>'' and emaper<>'null') ";
	}
	
	if ($scorreo=="true")
	{
	$codigo2=" and  (emaper='' or emaper is null) ";
	}
}

	
	$sql2="select a.numcta,a.codinttom,a.codintinm ,b.nomper,b.cedrif,b.telper,b.celper,b.emaper
	from maeregtom a, maeregper b
	where a.codcic='".$oficina."' and (a.esttom='1' or a.esttom='3') and a.codintper=b.codintper ".$codigo." ".$codigo2." and a.rutmed >='".$rcorreodesde."' and a.rutmed <='".$rcorreohasta."' order by a.numcta";	
	$dato=pg_query($bd_conexion,$sql2);
//$cuenta=pg_fetch_assoc($dato);
//	echo $sql2;
//	break;
	while ($cuenta=pg_fetch_assoc($dato))
	{
	$total=$conta++;
	$sql3="select dirinm from maereginm where codintinm='".$cuenta['codintinm']."'";	
	$inm=pg_query($bd_conexion,$sql3);
	$direc=pg_fetch_assoc($inm);
	
	
	$pdf->SetWidths(array(22,60,70,20,22,20,48));
	$pdf->SetAligns(array('L','L','L','C','L','L','L'));
	$pdf->Row(array($cuenta['numcta'],$cuenta['nomper'],$direc['dirinm'],$cuenta['cedrif'],$cuenta['telper'],$cuenta['celper'],$cuenta['emaper']),4,0);

	}

	
	$pdf->Ln(7);
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(220,10,'TOTAL DE REGISTROS....'.' '.'('.$total.')',0,0,'L');

	
	
	
	
	
$pdf->Output('reporte_datos_cliente.pdf','I');

?>