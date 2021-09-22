<?php
session_start();
require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require('../../libs/fpdf/fpdf.php');
require('../../clases/funciones.php');
require("../../clases/utilidades.class.php");

$ancho=290;
$repfecdes=$_REQUEST['repcompfecdes'];
$repfechas=$_REQUEST['repcompfechas'];

$objUtilidades=new utilidades;

class PDF extends FPDF
{
	function Header()
	{
		global $repfecdes;
		global $repfechas;
		global $sis_titulo;
		global $logo_empresa; 
		$this->SetFont('Arial','B',12);
		$this->Image($logo_empresa,8,6,11);
		$this->Cell(14,7);
		$this->Cell($ancho,17,$sis_titulo,0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->Ln(4);
		$this->Cell($ancho,7,'Fecha Emitido: '.date("d/m/Y").' - '.date('h:i:s A'),0,0,'R');
		$this->Ln(10);
		$this->SetFont('Arial','B',14);
		$this->Cell($ancho,7,'Resumen de Compras',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','B',10);
		$this->Cell($ancho,7,'Desde: '.$repfecdes.'   Hasta: '.$repfechas,0,0,'C');
		$this->Ln(10);
	}
	
	function Footer()
	{ 
		$this->SetTextColor(0,0,0);
    	$this->SetY(-15);
    	$this->SetFont('Helvetica','I',8);
		$this->Cell(290,10,'VivSoc - Soluciones Digitales',0,0,'R');
	}
}

$pdf = new PDF('L');
$pdf->SetMargins(5, 5, 5);
$pdf->AddPage('L');
$pdf->Ln(3);

$sql = "select * from compras where fec_doc_compra between '".$repfecdes."' and '".$repfechas."'	 order by fec_doc_compra";
$result_compras=pg_query($bd_conexion,$sql);	
$pdf->SetFont('Arial','',10);
		$total=0;
		$total2=0;
		$parche=0;
		
while ($datos = pg_fetch_assoc($result_compras))
{
	
	$idcompra=$datos['id_compra'];	
	$codprovee=$datos['id_cli_pro'];
	$tipdoc=$datos['id_tipo_doc_com'];	
	$numdoc=$datos['num_documento'];
	$fecregcom=$datos['fec_reg_compra'];
	$tipcompra=$datos['tipo_compra'];
	$idforpag=$datos['id_for_pago'];
	$totcompra=$datos['total_compra'];
	$idusuario=$datos['id_usuario'];
	$fecdoccompra=$datos['fec_doc_compra'];	
	if($parche==0)
	{
		$fecactual=$datos['fec_doc_compra'];
		$parche=1;
	$pdf->Ln(6);
	$pdf->SetFillColor(230,242,255);
	$pdf->cell($ancho,7,"Fecha: ".formato_fecha($fecdoccompra),'0','','L',TRUE);
	$pdf->Ln(6);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(40,7,latin1("Documento"),'0','','L',TRUE);
	$pdf->cell(45,7,latin1("Número"),'0','','L',TRUE);
	$pdf->cell(45,7,latin1("Condición"),'0','','L',TRUE);
	$pdf->cell(135,7,latin1("Proveedor"),'0','','L',TRUE);
	$pdf->cell(25,7,latin1("Total"),'0','','L',TRUE);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(6);
	}
	$objUtilidades=new utilidades;
	$proveedor=$objUtilidades->buscar_datos($sql="select * from clientes_proveedores where id_cli_pro='".$codprovee."'");
	if($fecactual==$datos['fec_doc_compra'])
	{	

	$tip_doc=$objUtilidades->buscar_datos($sql="select * from tipos_documentos where id_tip_documento='".$tipdoc."'");
	$pdf->cell(40,7,latin1($tip_doc['des_tip_documento']),'0','','L');
	$pdf->cell(45,7,latin1($numdoc),'0','','L');
	$pdf->cell(45,7,latin1($tipcompra),'0','','L');
	$pdf->cell(135,7,latin1($proveedor['nombre']),'0','','L');
	$pdf->cell(25,7,number_format($totcompra,2,'.',','),'0','','R');
	$pdf->Ln(5);
	$fecactual=$datos['fec_doc_compra'];
	$total+=$subtotal;
	$total2+=$totcompra;
	}else
	{
		$tip_doc=$objUtilidades->buscar_datos($sql="select * from tipos_documentos where id_tip_documento='".$tipdoc."'");
	$pdf->cell(40,7,latin1($tip_doc['des_tip_documento']),'0','','L');
	$pdf->cell(45,7,latin1($numdoc),'0','','L');
	$pdf->cell(45,7,latin1($tipcompra),'0','','L');
	$pdf->cell(135,7,latin1($proveedor['nombre']),'0','','L');
	$pdf->cell(25,7,number_format($totcompra,2,'.',','),'0','','R');
	$pdf->Ln(5);
	$fecactual=$datos['fec_doc_compra'];
		$fecactual=$datos['fec_doc_compra'];
		$pdf->Ln(6);
		$pdf->SetFillColor(230,242,255);
		$pdf->cell($ancho,7,"Fecha: ".formato_fecha($fecdoccompra),'0','','L',TRUE);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','B',10);
		$pdf->cell(40,7,latin1("Documento"),'0','','L',TRUE);
		$pdf->cell(45,7,latin1("Número"),'0','','L',TRUE);
		$pdf->cell(45,7,latin1("Condición"),'0','','L',TRUE);
		$pdf->cell(135,7,latin1("Proveedor"),'0','','L',TRUE);
		$pdf->cell(25,7,latin1("Total"),'0','','L',TRUE);
		$pdf->SetFont('Arial','',10);
		$pdf->Ln(6);
		$total+=$subtotal;
		$total2+=$totcompra;
	}
}

	$pdf->Ln(10);
	$pdf->SetFillColor(230,242,255);
	$pdf->SetFont('Arial','B',12);
	$pdf->cell(70,8,'','0','','L',TRUE);
	$pdf->cell(75,8,'Total General con IVA:','0','','R',TRUE);
	$pdf->cell(75,8,number_format($total2,2,'.',','),'0','','R',TRUE);
	$pdf->cell(70,8,'','0','','R',TRUE);
	$pdf->SetFont('Arial','',10);

$pdf->Output();
?>