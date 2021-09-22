<?php
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/utilidades.class.php");
require("../../../libs/fpdf/fpdf.php");
require("../../../sesion.php");

$objUtilidades=new utilidades;



class PDF extends FPDF
{
	function Header()
	{
		GLOBAL $bd_conexion;
		
		$sql="Select nomofi from paroficom where codofi='".@$_GET["oficina_desde"]."'";
		$result_ofi=pg_query($bd_conexion,$sql);
		$oficina_desde= pg_result($result_ofi,0,"nomofi");
		
		$sql="Select nomofi from paroficom where codofi='".@$_GET["oficina_hasta"]."'";
		$oficina_hasta=pg_query($bd_conexion,$sql);
		$oficina_hasta= pg_result($oficina_hasta,0,"nomofi");
		
    	$this->SetFont('Arial','B',10);
		$this->Cell(300,10,'HIDROSUROESTE',0,0,'L');
	
		$this->SetFont('Arial','',8);
		$this->Cell(300,5,'Fecha: '.date("d/m/Y"),0,0,'L');
	
		$this->Ln();
		
	    $this->SetFont('Arial','B',10);
		$this->Cell(300,10,'COMERCIALES',0,0,'L');
	
		$this->SetFont('Arial','',8);
		$this->Cell(300,5,'Hora: '.date("h:i:s A"),0,0,'L');
	
		$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(300,10,utf8_decode('GENERAL'),0,0,'L');
	
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'L');
		$this->Ln(10);
	
		$this->SetFont('Arial','B',12);
		
		$this->Cell(405,10,'LISTADO DE MOVIMIENTOS POR PARAMETROS ',0,0,'C');
		$this->Ln(10);
	
		$this->SetFont('Arial','B',9);
		
		$this->Cell(410,10,'DESDE OFICINA :'.$oficina_desde.'   '.'HASTA OFICINA :'.$oficina_hasta,0,0,'C');
		
		
		$this->Ln(10);
		$sql="Select desmov from parhismov where codmov='".@$_GET["tipo_desde"]."'";
		$result_movdesde=pg_query($bd_conexion,$sql);
		//$mov_desde=$objUtilidades->buscar_datos($sql);
		$sql="Select desmov from parhismov where codmov='".@$_GET["tipo_hasta"]."'";
		//$mov_hasta=$objUtilidades->buscar_datos($sql);
		$result_movhasta=pg_query($bd_conexion,$sql);

		$this->SetFont('Arial','B',9);
		$this->Cell(30,5,'',0,0,'L');
		$this->Cell(20,5,'FECHA: ',0,0,'L');
		$this->Cell(60,5,@$_GET["fecha_desde"],0,0,'L');
		$this->Cell(20,5,'HASTA: ',0,0,'L');
		$this->Cell(60,5,@$_GET["fecha_hasta"],0,0,'L');
		$this->Cell(30,5,'',0,0,'L');
		$this->Cell(20,5,'TIPO DESDE:',0,0,'L');
		$this->Cell(65,5,@pg_result($result_movdesde,0,"desmov"),0,0,'L');
		$this->Cell(20,5,'TIPO HASTA: ',0,0,'L');
		$this->Cell(65,5,@pg_result($result_movhasta,0,"desmov"),0,0,'L');
		$this->Ln();
	
		$this->Ln(7);
		$this->Line(6,56,410,56);
		
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','B',8);
		$this->SetWidths(array(20,10,20,22,50,60,20,50,10,25,10,10,20,20,10,50));
		$this->SetAligns(array('C','C','L','C','C','L','C','C','C','C','C','C','C','C','C'));
		$this->Row(array("Fecha","   ","Tipo","Cuenta","Nombre","Dirección","CI/RIF Fiscal","Nombre Fis.","Apto","Uso","Dotación","Promedio","Estatus","Empleado","Ofic.Mod","Domicilio Fiscal"),4,0);
		
		
		$this->Line(6,70,410,70);
		$this->Ln(7);
		
	}
	
	function Footer()
	{
    	$this->SetY(-15);
    	$this->SetFont('Arial','I',8);
    	$this->Cell(0,10,'reporte_movimiento_cuenta',0,0,'L');
	}
}

$pdf=new PDF($orientacion='L',$unit='mm',$format='a3');
$pdf->AliasNbPages();
$pdf->AddPage();


// las variables de los input 
$tabla="";

$oficina_desde=@$_GET["oficina_desde"];
$oficina_hasta=@$_GET["oficina_hasta"];


$fecha_desde=@$_GET["fecha_desde"];
$cuenta=@$_GET['cuenta'];

$fed=explode("/",$fecha_desde);
$fecha_desde=$fed[0]."/".$fed[1]."/".$fed[2];

$fecha_hasta=@$_GET["fecha_hasta"];
$feh=explode("/",$fecha_hasta);
$fecha_hasta=$feh[0]."/".$feh[1]."/".$feh[2];

$tipo_desde=@$_GET["tipo_desde"];

$tipo_hasta=@$_GET["tipo_hasta"];



$monto=0;
	
	$sql="select * from cathismov where fecmov>='".$fecha_desde."' and fecmov<='".$fecha_hasta."' and 
	      codofi_cli>='".$oficina_desde."' and codofi_cli<='".$oficina_hasta."' and 
		  tipcam>='".$tipo_desde."' and tipcam<='".$tipo_hasta."' order by refmov,correl";
	//echo"asas".$sql;
	$result = pg_query($bd_conexion,$sql);
	
				
	$total=0; 	$sum01=0; 	$sum02=0; 	$sum03=0; 	$sum04=0; 	$sum05=0; 	$sum06=0; 	$sum07=0;
	$sum08=0; 	$sum09=0; 	$sum10=0; 	$sum11=0; 	$sum12=0; 	$sum13=0; 	$sum14=0; 
	while(($datos=pg_fetch_assoc($result))>0)
	{
		if	($datos['correl']=='1')
			$total=$total+1;
		$feh=explode("-",$datos['fecmov']);
		$fecha_mov=$feh[2]."/".$feh[1]."/".$feh[0];
		
		$sql="select desuso from catusotar where coduso='".$datos['codusotar']."' ";
 		$uso=$objUtilidades->buscar_datos($sql);
		
		$sql="select nomusu from pardefusu where codintusu='".$datos['codintusu']."' ";
 		$empleado=$objUtilidades->buscar_datos($sql);
		
		
		
		switch ($datos['esttom'])
		{
			case 1:
				$esttom="ACTIVO";
				break;
			case 2:
				$esttom="INACTIVO";
				break;
			case 3:
				$esttom="CORTADO";
				break;
			case 4:
				$esttom="RETIRADO";
				break;
			case 5:
				$esttom="RETIRADO";
				break;
			case 9:
				$esttom="ELIMINADO";
				break;
			
		}
		if ($datos['correl']=='1')
		{
			switch ($datos['tipcam'])
			{
				
				case '01':
					$sum01=$sum01+1;
					break;
				case '02':
					$sum02=$sum02+1;
					break;
				case '03':
					$sum03=$sum03+1;
					break;
				case '04':
					$sum04=$sum04+1;
					break;
				case '05':
					$sum05=$sum05+1;
					break;
				case '06':
					$sum06=$sum06+1;
					break;
				case '07':
					$sum07=$sum07+1;
					break;
				case '08':
					$sum08=$sum08+1;
					break;
				case '09':
					$sum09=$sum09+1;
					break;
				case '10':
					$sum10=$sum10+1;
					break;
				case '11':
					$sum11=$sum11+1;
					break;
				case '12':
					$sum12=$sum12+1;
					break;
				case '13':
					$sum13=$sum13+1;
					break;
				case '14':
					$sum14=$sum14+1;
					break;
				
			}
		}
		
		$pdf->SetWidths(array(20,10,20,22,50,60,20,50,10,25,10,10,20,20,10,50));
		$pdf->SetAligns(array('L','C','L','L','L','L','L','L','C','L','L','L','L','L','L','L'));
		$dottom=number_format($datos['dottom'],0);
		$protom=number_format($datos['protom'],0);
		if ($datos['correl']=='1')
			$correl="ACT";
		else
			$correl="MOD";
		$pdf->SetFont('Arial','',8);
		$pdf->Row(array($fecha_mov,$correl,$datos['observ'],$datos['numcta'],$datos['nomper'],$datos['dirper'],$datos['cedinq'],$datos['nominq'],$datos['nroapt'],$uso['desuso'],$dottom,$protom,$esttom,substr($empleado['nomusu'],0,20),$datos['codofi'],$datos['domfis']),4,0);	
		
	
	}
	//echo "datos".$sum09;

	$pdf->ln(7);
		
	$pdf->SetWidths(array(40,20));
	$pdf->SetAligns(array('L','C'));
	$pdf->Row(array("Tipo Movimiento","Cantidad"),4,0);
	$pdf->cell(60,0,'','B');
	$pdf->ln(2);
	$pdf->SetAligns(array('L','C'));
	$pdf->Row(array("Nuevo Inmueble:",$sum01),4,0);
	$pdf->Row(array("Nro. Aptos:",$sum02),4,0);
	$pdf->Row(array("Dirección:",$sum03),4,0);
	$pdf->Row(array("Uso:",$sum04),4,0);
	$pdf->Row(array("Estatus:",$sum05),4,0);
	$pdf->Row(array("Promedio:",$sum06),4,0);
	$pdf->Row(array("Dotación:",$sum07),4,0);
	$pdf->Row(array("Nro.Cuenta:",$sum08),4,0);
	$pdf->Row(array("Nueva Cuenta: ",$sum09),4,0);
	$pdf->Row(array("Nombre:",$sum10),4,0);
	$pdf->Row(array("Cambio Persona:",$sum11),4,0);
	$pdf->Row(array("CI/RIF Fiscal:",$sum12),4,0);
	$pdf->Row(array("Nombre Fiscal:",$sum13),4,0);
	$pdf->Row(array("Domicilio Fiscal:",$sum14),4,0);
	$pdf->cell(60,0,'','B');
	$pdf->ln(2);
	$pdf->SetAligns(array('L','C'));
	
	$pdf->Row(array("TOTAL:",$total),4,0);
	$pdf->cell(60,0,'','B');
	
$pdf->Output('Movimiento_por_parametros.pdf','I');

?>