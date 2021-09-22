<?php
session_start();
require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require('../../libs/fpdf/fpdf.php');
require('../../clases/funciones.php');
require("../../clases/utilidades.class.php");

$ancho=290;
$fecdes=$_REQUEST['repcomp_fecdes'];
$fechas=$_REQUEST['repcomp_fechas'];
$idprov=$_REQUEST['rep_comp_idproveedor'];

$objUtilidades=new utilidades;

class PDF extends FPDF
{
	function Header()
	{
		global $fecdes;
		global $fechas;
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
		$this->Cell($ancho,7,'Detalle de Compras',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','B',10);
		$this->Cell($ancho,7,'Desde: '.$fecdes.'   Hasta: '.$fechas,0,0,'C');
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
$condi=$idprov!=''?" and id_cli_pro='".$idprov."'":"";
$sql = "select * from compras where fec_doc_compra between '".$fecdes."' and '".$fechas."'".$condi." order by fec_doc_compra";
$result_compras=pg_query($bd_conexion,$sql);	
$pdf->SetFont('Arial','',10);
		$total=0;
		$total2=0;
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
	
	$objUtilidades=new utilidades;
	$proveedor=$objUtilidades->buscar_datos($sql="select * from clientes_proveedores where id_cli_pro='".$codprovee."'");
	$pdf->Ln(6);
	$pdf->SetFillColor(230,242,255);
	$pdf->cell($ancho,7,"Fecha: ".formato_fecha($fecdoccompra),'0','','L',TRUE);
	$pdf->Ln(10);
	$tip_doc=$objUtilidades->buscar_datos($sql="select * from tipos_documentos where id_tip_documento='".$tipdoc."'");
	$pdf->cell(40,7,latin1($tip_doc['des_tip_documento']),'0','','L',TRUE);
	$pdf->cell(45,7,latin1("N°: ".$numdoc),'0','','L',TRUE);
	$pdf->cell(45,7,latin1($tipcompra),'0','','L',TRUE);
	$pdf->cell(160,7,latin1("Proveedor: ".$proveedor['nombre']),'0','','L',TRUE);
	$pdf->Ln(10);
	$sql2="select a.*, b.* from compras_detalle a, productos b where id_compra='".$idcompra."' and b.id_producto=a.id_producto";
	$compras=pg_query($bd_conexion,$sql2);	
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(230,242,255);	
		$pdf->Cell(20,7,latin1('Código'),0,0,'C',TRUE);
		$pdf->Cell(150,7,latin1('Descripción'),0,0,'C',TRUE);
		$pdf->Cell(15,7,'Cant.',0,0,'C',TRUE);
		$pdf->Cell(20,7,'P. Compra',0,0,'C',TRUE);
		$pdf->Cell(20,7,'PVP Mayor',0,0,'C',TRUE);
		$pdf->Cell(20,7,'PVP Detal',0,0,'C',TRUE);
		$pdf->Cell(15,7,'I.V.A.',0,0,'C',TRUE);
		$pdf->Cell(30,7,latin1('Cód. Alt.'),0,0,'C',TRUE);
		$pdf->Ln(6);
		$subtotal=0;
		
	while ($datos2 = pg_fetch_assoc($compras))
	{
	$pdf->SetFont('Arial','',8);
	$codpro=$datos2['id_producto'];	
	$despro=substr($datos2['des_corta'],0,90);
	$cantidad=$datos2['can_pro_com'];
	$precom=$datos2['pre_pro_com'];
	$moniva=$datos2['mon_iva'];
	$prevendet=$datos2['pre_venta_detal'];
	$prevenmay=$datos2['pre_venta_mayor'];
	$codalt=$datos2['id_alterno'];
	$pdf->cell(20,8,$codpro,'0','','L');
	$pdf->Cell(150,8,latin1($despro),'0','','L');
	$pdf->cell(15,8,$cantidad,'0','','R');
	$pdf->cell(20,8,number_format($precom,2,'.',','),'0','','R');
	$pdf->cell(20,8,number_format($prevendet,2,'.',','),'0','','R');
	$pdf->cell(20,8,number_format($prevenmay,2,'.',','),'0','','R');
	$pdf->cell(15,8,number_format($moniva,2,'.',','),'0','','R');
	$pdf->cell(30,8,$codalt,'0','','L');
	$pdf->Ln(6);	
	$subtotal+=$precom*$cantidad;
	}
	$pdf->SetFont('Arial','B',8);
	$pdf->cell(25,8,'','0','','L');
	$pdf->cell(65,8,'','0','','L');
	$pdf->cell(25,8,'Subtotal Compra USD:','0','','R');
	$pdf->cell(15,8,number_format($subtotal,2,'.',','),'0','','R');
	$pdf->cell(25,8,'','0','','L');
	$pdf->cell(25,8,'Total Compra USD:','0','','R');
	$pdf->cell(15,8,number_format($totcompra,2,'.',','),'0','','R');
	$pdf->cell(30,8,'','0','','R');
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(10);
	$total+=$subtotal;
	$total2+=$totcompra;
}

	$pdf->Ln(10);
	$pdf->SetFillColor(230,242,255);
	$pdf->SetFont('Arial','B',12);
	$pdf->cell(30,8,'','0','','L',TRUE);
	$pdf->cell(70,8,'Total General sin IVA:','0','','R',TRUE);
	$pdf->cell(25,8,number_format($total,2,'.',','),'0','','R',TRUE);
	$pdf->cell(70,8,'Total General con IVA:','0','','R',TRUE);
	$pdf->cell(25,8,number_format($total2,2,'.',','),'0','','R',TRUE);
	$pdf->cell(70,8,'','0','','R',TRUE);
	$pdf->SetFont('Arial','',10);

$pdf->Output();
?>