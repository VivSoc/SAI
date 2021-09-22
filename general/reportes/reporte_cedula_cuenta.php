<?php
@session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/utilidades.class.php");
require("../../../clases/funciones.php");
require("../../../libs/fpdf/fpdf.php");

$objUtilidades=new utilidades;

$oficina=$_GET['oficina'];
$activos=@$_GET['activos'];
$inactivos=@$_GET['inactivos'];
$cortados=@$_GET['cortados'];
$retirados=@$_GET['retirados'];


class PDF extends FPDF
{
	function Header()
	{
		GLOBAL $bd_conexion;

		$this->SetFont('Arial','B',10);
		$this->Cell(150,10,'HIDROSUROESTE',0,0,'L');
		$this->SetX(300);
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,'Fecha: '.date("d/m/Y"),0,0,'L');
	
		$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(150,10,'GERENCIA COMERCIAL',0,0,'L');
	
		$this->SetFont('Arial','',8);
		$this->SetX(300);
		$this->Cell(40,5,'Hora: '.date("h:i:s A"),0,0,'L');
	//$this->Ln();
		$this->SetFont('Arial','',8);
		//$this->SetX(300);
		$this->Cell(40,5,latin1('Página ').$this->PageNo().' de {nb}',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','B',12);
		$this->Cell(250,15,'LISTADO DE CUENTAS Y CEDULAS IGUALES',0,0,'C');

		
		$this->Ln(15);
		$this->SetFont('Arial','B',8);
		$this->SetFillColor(255,255,255);
		$this->SetAligns(array('C','C','C','C','C','C'));		
		$this->SetWidths(array(22,45,30,65,28,60));
		$this->Row(array("CUENTA","NOMBRE SUS.","CEDULA SUS.","NOMBRE FIS","RIF FIS","DOMICILIO FISCAL"),5);
		$this->Ln(5);
	//	$this->Row(array("N","EMISION","LEC.ACTUAL","FEC.LEC.ACT.","LEC.ANTER.","FEC.LEC.ANT.","CONS.LEIDO","CONS.FACT.","SERIAL"),5);
		$this->SetAligns(array('L','L','L','L','L','L'));
		
	}
	
	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'reporte_cedula_cuenta',0,0,'L');
	}
}


$pdf=new PDF($orientacion='L',$unit='mm',$format='letter');
$pdf->AliasNbPages();
$pdf->AddPage("");


if($activos==1)
$est1=" a.esttom='1' ";
else
 $est1='';

if($inactivos==1 && $activos==1)
$est2=" or a.esttom='2' ";
else
if($inactivos==1 && $activos==0)
$est2=" a.esttom='2' ";

if($cortados==1 && ($activos==1 || $inactivos==1))
$est3=" or a.esttom='3' ";
else
if($cortados==1 && ($activos==0 && $inactivos==0))
$est3=" a.esttom='3' ";

if($retirados==1 && ($cortados==1 || $activos==1 || $inactivos==1))
$est4=" or a.esttom='5'";
else
if($retirados==1 && ($cortados==0 && $activos==0 && $inactivos==0))
$est4=" a.esttom='5'";



 if ($oficina=="todas")
 {
	$sql="select a.numcta,b.nomper,b.cedrif,c.nominq,c.cedinq,c.domfis
		from maeregtom a, maeregper b, maereginm c
		where b.codintper=a.codintper and c.codintinm=a.codintinm
		and (substr(numcta,3,20)=substr(cedrif,2,20) or numcta=substr(cedinq,2,20))
		and ($est1 $est2 $est3 $est4) order by a.numcta";
	
}
else
{
	$sql="select a.numcta,b.nomper,b.cedrif,c.nominq,c.cedinq,c.domfis,a.codcic
		from maeregtom a, maeregper b, maereginm c
		where b.codintper=a.codintper and c.codintinm=a.codintinm
		and (substr(numcta,3,20)=substr(cedrif,2,20) or numcta=substr(cedinq,2,20))
		and ($est1 $est2 $est3 $est4) and a.codcic='$oficina' order by a.codcic,a.numcta";
}
//echo $sql;

$ctaced=pg_query($sql); 

	while(($cuentas=pg_fetch_assoc($ctaced))>0)
		{
			
			$pdf->SetFont('Arial','',7);
		//	$pdf->SetFillColor(255,255,255);
			$pdf->SetAligns(array('L','L','L','L','L','L'));		
			$pdf->SetWidths(array(22,45,30,65,28,60));
			$pdf->Row(array($cuentas['numcta'],$cuentas['nomper'],$cuentas['cedrif'],$cuentas['nominq'],$cuentas['cedinq'],$cuentas['domfis']),2,0);
			//$pdf->Ln(1);
					
//					@pg_result($result_mot,0,"desmot")
	//$pdf->SetAligns(array('C','C','C','C','C','R','R','R','R','R'));
			
		}
			
		/*	$pdf->ln(4);
			$pdf->SetFont('Arial','',9);
			$pdf->SetFillColor(255,255,255);
			$pdf->SetAligns(array('R','C','C','C','C'));		
			$pdf->SetWidths(array(270,20,20,20,65));
			$pdf->Row(array('TOTALES:   ',$sum_moncon,$sum_deuda,$sum_vencida,''),5,5);
					
			*/
	
//echo $tabla;

$pdf->Output('cuentas_cedulas_iguales.pdf','I');
?>