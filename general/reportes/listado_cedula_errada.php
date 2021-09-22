<?php
@session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require('../../../libs/fpdf/fpdf.php');
require('../../../clases/funciones.php');
require("../../../clases/utilidades.class.php");
$objUtilidades=new utilidades;
$oficina=@$_GET['oficina'];

//echo $personas.''.'INQUILINO'.''.$inquilino;

$personas=@$_GET['fcpf_personas'];
$inquilino=@$_GET['fcpf_inquilinos'];
class PDF extends FPDF
{
	function Header()
	{
		GLOBAL $bd_conexion;
		$oficina=@$_GET['oficina'];
		$personas=@$_GET['fcpf_personas'];
		$inquilino=@$_GET['fcpf_inquilinos'];	
	
		if($personas=="true")
		{
			$titulo='LISTADO  DE SUSCRIPTORES CON CEDULAS ERRADAS ';			  
		}

		if($inquilino=="true")
		{
			$titulo='LISTADO DE RECEPTORES CON CEDULAS ERRADAS ';
		}
    	$this->SetFont('Arial','B',10);
		$this->Cell(150,10,'HIDROSUROESTE',0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,'Fecha: '.date("d/m/Y"),0,0,'L');
		$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(150,10,'GERENCIA COMERCIAL',0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,'Hora: '.date("h:i:s"),0,0,'L');
		$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(150,10,'GENERAL',0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'L');
		$this->Ln(5);
		$this->SetFont('Arial','B',10);
		$this->Cell(190,10,utf8_decode($titulo),0,0,'C');
		$this->Ln(5);
		$this->Ln(10);	
		$sql = "select nomofi from paroficom where codofi='".@$_GET['oficina']."'";
		$result_ofi = pg_query($bd_conexion,$sql);
	    $nom_ofi=pg_result($result_ofi,0,"nomofi");
		$this->SetFont('Arial','B',10);
		$this->Cell(20,5,'OFICINA : ',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(110,5,$nom_ofi,0,0,'L');
		$this->Ln(5);
		$this->SetFont('Arial','B',10);
		$this->SetFillColor(255,255,255);
		$this->SetAligns(array('C','C','C'));		
		$this->SetWidths(array(60,60,60));
		$this->Row(array("Cuenta","Cedula/Rif","Estatus"),5);
		$this->SetAligns(array('L','L','L'));	
	}

	function Footer()
	{
		$this->SetY(-15);
    	$this->SetFont('Arial','I',10);
    	$this->Cell(0,10,'Listado_Cedula_Erradas',0,0,'L');
	}
}
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

if(@$_GET['fcpf_personas']=="true")
		{	
			$sql="select a.numcta,c.descripcion	,b.cedrif		
				  from maeregtom a, maeregper b, catesttom c		
				  where a.esttom in ('1','2','3')		
				  and b.codintper=a.codintper	
				  and a.esttom=c.estatus	
				  and (b.cedrif like 'V%%A%' 
				  OR b.cedrif like 'G%%A%'
				  OR b.cedrif like 'V%%B%'
				  OR b.cedrif like 'V%%C%'
				  OR b.cedrif like 'V%%G%'
				  OR b.cedrif like 'V%%F%'
				  OR b.cedrif like 'VB%'
				  OR b.cedrif like 'EJ%'
				  OR b.cedrif like 'JJ%') 
				  and a.oficom='".$oficina."'		
				  order by c.descripcion";
				  
		}

		if(@$_GET['fcpf_inquilinos']=="true")
		{	
			$sql="select a.numcta,c.descripcion,b.cedinq		
				  from maeregtom a, maereginm b, catesttom c				
				  where a.esttom in ('1','2','3')			
				  and b.codintinm=a.codintinm
				  and a.esttom=c.estatus			
				  and (b.cedinq like 'V%%A%' 
				  OR b.cedinq like 'G%%A%'
				  OR b.cedinq like 'V%%B%'
				  OR b.cedinq like 'V%%C%'
				  OR b.cedinq like 'V%%G%'
				  OR b.cedinq like 'V%%F%'
				  OR b.cedinq like 'VB%'
				  OR b.cedinq like 'EJ%'
				  OR b.cedinq like 'JJ%') 
                  and a.oficom='".$oficina."'		
				  order by c.descripcion";
				  
				 // echo $sql;exit;
			
		}
		
$ok=pg_query($sql); 
while(($dato=pg_fetch_assoc($ok))>0)
{
	if(@$_GET['fcpf_personas']=="true")
	{
	   $cedula=$dato['cedrif'];
	}
	if(@$_GET['fcpf_inquilinos']=="true")
	{
		$cedula=$dato['cedinq'];
		}
		$pdf->SetFont('Arial','',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetAligns(array('L','L','L'));			
		$pdf->SetWidths(array(60,60,60));
		$pdf->Row(array($dato['numcta'],$cedula,$dato['descripcion']),5);	
		
$contador=$contador+1;
}		
$pdf->Line(5);
//echo "deuda ".$suma_deuda." emi ".$suma_emi;
$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetAligns(array('C','C','C'));		
		$pdf->SetWidths(array(60,60,60));
		$pdf->Row(array("TOTAL REGISTROS",'',$contador),5,0);	

$pdf->Output('reporte_estatus_toma.pdf','I');

?>