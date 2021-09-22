<?php
session_start();
require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require('../../libs/fpdf/fpdf.php');
require('../../clases/funciones.php');
require("../../clases/utilidades.class.php");

$ancho=195;
$num_orden=$_REQUEST['id_orden'];
$objUtilidades=new utilidades;

class PDF extends FPDF
{
	function Header()
	{
		global $num_orden;
		global $sis_titulo;
		global $logo_empresa; 
		$this->SetFont('Arial','B',12);
		$this->Image($logo_empresa,8,6,11);
		$this->Cell(14,7);
		$this->Cell($ancho,17,$sis_titulo,0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->Ln(4);
		$this->Cell(195,7,'Fecha Emitido: '.date("d/m/Y").' - '.date('h:i:s A'),0,0,'R');
		$this->Ln(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(195,7,'Orden de Compra',0,0,'C');
		$this->Ln(5);
	}
	
	function Footer()
	{ 
		$this->SetTextColor(0,0,0);
    	$this->SetY(-15);
    	$this->SetFont('Helvetica','I',8);
		$this->Cell(200,10,'VivSoc - Soluciones Digitales',0,0,'R');
	}
}

$pdf = new PDF();
$pdf->SetMargins(5, 5, 5);
$pdf->AddPage();
$pdf->Ln(3);
$sql = "select * from ordenes_compra where id_orden='".$num_orden."'";
$result_compras=pg_query($bd_conexion,$sql);	
$pdf->SetFont('Arial','',8);
$total=0;
while ($datos = pg_fetch_assoc($result_compras))
{
	
	$idorden=$datos['id_orden'];	
	$codprovee=$datos['id_cli_pro'];
	$fecord=$datos['fec_reg_orden'];
	$objUtilidades=new utilidades;
	$proveedor=$objUtilidades->buscar_datos($sql="select * from clientes_proveedores where id_cli_pro='".$codprovee."'");
	$pdf->Ln(6);
	$pdf->SetFillColor(230,242,255);
	$pdf->cell(195,7,"Fecha: ".formato_fecha($fecord),'0','','L',TRUE);
	$pdf->Ln(10);
	$pdf->cell(40,7,latin1("N°: ".$num_orden),'0','','L',TRUE);
	$pdf->cell(155,7,latin1("Proveedor: ".$proveedor['nombre']),'0','','L',TRUE);
	$pdf->Ln(10);
	$sql2="select a.*, b.des_corta, b.id_alterno from ordenes_compras_detalle a, productos b where id_orden='".$num_orden."' and b.id_producto=a.id_producto";
//	var_dump($sql2);
	$compras=pg_query($bd_conexion,$sql2);	
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(230,242,255);	
		$pdf->Cell(10,7,latin1('Item'),0,0,'C',TRUE);
		$pdf->Cell(30,7,latin1('Código'),0,0,'C',TRUE);
		$pdf->Cell(145,7,latin1('Descripción'),0,0,'C',TRUE);
		$pdf->Cell(10,7,'Cant.',0,0,'C',TRUE);		
		$pdf->Ln(6);
	while ($datos2 = pg_fetch_assoc($compras))
	{
		$total+=1;
	$pdf->SetFont('Arial','',7);	
	$codpro=$datos2['id_alterno'];	
	$despro=$datos2['des_corta'];
	$cantidad=$datos2['can_pro_com'];
    $pdf->Cell(10,7,$total,0,0,'R');
	$pdf->cell(30,7,$codpro,'0','','L');
	$pdf->cell(145,7,latin1($despro),'0','','L');
	$pdf->cell(10,7,$cantidad,'0','','R');
	$pdf->Ln(6);	
	}
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(25,7,'','0','','L',TRUE);
	$pdf->cell(150,7,'Total de Items: '.$total,'0','','L',TRUE);
	$pdf->cell(20,7,'','0','','R',TRUE);
	
}
$pdf->Output();
?>