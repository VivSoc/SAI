<?php
session_start();
require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require('../../libs/fpdf/fpdf.php');
require('../../clases/funciones.php');
require("../../clases/utilidades.class.php");

$id_provee=$_REQUEST['id_provee'];
$objUtilidades=new utilidades;

class PDF extends FPDF
{
	function Header()
	{
		global $id_provee;
		global $sis_titulo;
		global $logo_empresa; 
		$this->SetFont('Arial','B',12);
		$this->Image($logo_empresa,8,6,11);
		$this->Cell(14,7);
		$this->Cell($ancho,17,$sis_titulo,0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->Ln(4);
		$this->Cell(290,7,'Fecha Emitido: '.date("d/m/Y").' - '.date('h:i:s A'),0,0,'R');
		$this->Ln(10);
		$this->SetFont('Arial','B',16);
		$this->Cell(290,7,'Cuentas por Pagar',0,0,'C');
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
/************* Buscar Datos el Cliente**********************************/

$proveedor=$objUtilidades->buscar_datos($sql="select * from clientes_proveedores where id_cli_pro='".$id_provee."'");

$pdf = new PDF('L');
$pdf->SetMargins(5, 5, 5);
$pdf->AddPage();
$pdf->Ln(3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,7,latin1('Documento: '.$proveedor['id_cli_pro']),0,0,'C');
$pdf->Cell(150,7,latin1('Nombre: '.$proveedor['nombre']),0,0,'C');
$pdf->Ln(5);
$pdf->Cell(182,7,latin1('Dirección: '.$proveedor['direccion']),0,0,'C');
$pdf->Ln(10);

$pdf->SetFillColor(230,242,255);	
$pdf->Cell(30,7,latin1('Nº Compra'),0,0,'C',TRUE);
$pdf->Cell(33,7,latin1('Nº Cta. por Pagar'),0,0,'C',TRUE);
$pdf->Cell(33,7,latin1('Tipo Documento'),0,0,'C',TRUE);
$pdf->Cell(33,7,latin1('Nº Documento'),0,0,'C',TRUE);
$pdf->Cell(32,7,latin1('F. Compra'),0,0,'C',TRUE);
$pdf->Cell(33,7,latin1('F. Vencimiento'),0,0,'C',TRUE);
$pdf->Cell(33,7,latin1('Monto Compra'),0,0,'C',TRUE);
$pdf->Cell(33,7,latin1('Monto Abonado'),0,0,'C',TRUE);
$pdf->Cell(30,7,'Saldo',0,0,'C',TRUE);		
$pdf->Ln(6);

	
$pdf->SetFont('Arial','',9);
$total=0;
$sql = "SELECT a.*,b.num_documento,c.des_tip_documento FROM cuentas_pagar a,compras b,tipos_documentos c where a.id_cli_pro = '".$id_provee."' and b.id_compra=a.id_compra and c.id_tip_documento=b.id_tipo_doc_com order by a.fec_reg_compra";

$result = pg_query($bd_conexion,$sql);
while ($datos = pg_fetch_assoc($result))
{
	$cxp=$objUtilidades->buscar_datos($sql="select sum(mon_abono) abonado from detalle_cuentas_pagar where id_cue_pagar='".$datos['id_cue_pagar']."'");
	$saldo=$datos['mon_debito']-$cxp['abonado'];
	$idcompra=$datos['id_compra'];
	$idcxp=$datos['id_cue_pagar'];
	$abonado=($cxp['abonado']!=0?$cxp['abonado']:0);
	if($saldo>0)
	{
		$total_cta+=$datos['mon_debito'];
		$total_abonado+=$abonado;
		$total_saldo+=$saldo;
		$pdf->Cell(30,7,$datos['id_compra'],0,0,'C');
		$pdf->Cell(33,7,$datos['id_cue_pagar'],0,0,'C');
		$pdf->Cell(33,7,$datos['des_tip_documento'],0,0,'C');
		$pdf->Cell(33,7,$datos['num_documento'],0,0,'C');
		$pdf->Cell(32,7,$datos['fec_reg_compra'],0,0,'C');
		$pdf->Cell(33,7,$datos['fec_vencimiento'],0,0,'C');
		$pdf->Cell(33,7,number_format($datos['mon_debito'],2),0,0,'R');
		$pdf->Cell(33,7,number_format($abonado,2),0,0,'R');
		$pdf->Cell(30,7,number_format($saldo,2),0,0,'R');	
		$pdf->Ln(6);	
	}			
}
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,7,'',0,0,'C',TRUE);
$pdf->Cell(33,7,'',0,0,'C',TRUE);
$pdf->Cell(33,7,'',0,0,'C',TRUE);
$pdf->Cell(33,7,'',0,0,'C',TRUE);
$pdf->Cell(32,7,'',0,0,'C',TRUE);
$pdf->Cell(33,7,'Totales',0,0,'C',TRUE);
$pdf->Cell(33,7,number_format($total_cta,2),0,0,'R',TRUE);
$pdf->Cell(33,7,number_format($total_abonado,2),0,0,'R',TRUE);
$pdf->Cell(30,7,number_format($total_saldo,2),0,0,'R',TRUE);	

$pdf->Output();
?>