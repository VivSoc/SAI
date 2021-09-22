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
		
		$sql="Select nomofi from paroficom where codofi='".$_SESSION['codofi']."'";
		$result_ofi=pg_query($bd_conexion,$sql);
		
    	$this->SetFont('Arial','B',10);
		$this->Cell(150,10,'HIDROSUROESTE',0,0,'L');
	
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,'Fecha: '.date("d/m/Y"),0,0,'L');
	
		$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(150,10,'OFICINA: '.@pg_result($result_ofi,0,"nomofi"),0,0,'L');
	
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,'Hora: '.date("h:i:s A"),0,0,'L');
	
		$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(150,10,utf8_decode('GENERAL'),0,0,'L');
	
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'L');
		$this->Ln(10);
	
		$this->SetFont('Arial','B',12);
		
		$this->Cell(405,10,'LISTADO DE MOVIMIENTOS POR CUENTA',0,0,'C');
		
		$this->Ln(10);
		
		$this->SetFont('Arial','B',9);
		$this->Cell(30,5,'',0,0,'L');
		$this->Cell(20,5,'FECHA: ',0,0,'L');
		$this->Cell(60,5,@$_GET["fecha_desde"],0,0,'L');
		$this->Cell(20,5,'HASTA: ',0,0,'L');
		$this->Cell(60,5,@$_GET["fecha_hasta"],0,0,'L');
		$this->Cell(30,5,'',0,0,'L');
		$this->Cell(20,5,'CUENTA: ',0,0,'L');
		$this->Cell(60,5,@$_GET['cuenta'],0,0,'L');
		$this->Ln();
	
		$this->Ln(7);
		$this->Line(6,50,410,50);
		
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','B',8);
		
		$this->SetWidths(array(20,10,20,22,50,60,20,50,10,25,10,10,20,20,10,50));
		$this->SetAligns(array('C','C','L','C','C','L','C','C','C','C','C','C','C','C','C'));
		$this->Row(array("Fecha","   ","Tipo","Cuenta","Nombre","Dirección","CI/RIF Fiscal","Nombre Fis.","Apto","Uso","Dotación","Promedio","Estatus","Empleado","Ofic.Mod","Domicilio Fiscal"),4,0);
		
		
		$this->Line(6,60,410,60);
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

$oficina=$_SESSION['nomofi'];

$fecha_desde=@$_GET["fecha_desde"];
$cuenta=@$_GET['cuenta'];

$fed=explode("/",$fecha_desde);
$fecha_desde=$fed[0]."/".$fed[1]."/".$fed[2];

$fecha_hasta=@$_GET["fecha_hasta"];
$feh=explode("/",$fecha_hasta);
$fecha_hasta=$feh[0]."/".$feh[1]."/".$feh[2];


$monto=0;

$sql="select * from maeregtom where trim(numcta)='".$cuenta."'";
$result = pg_query($bd_conexion,$sql);
if (pg_num_rows($result)>0)
{
	$sql="select * from cathismov where trim(numcta)='".$cuenta."' and fecmov>='".$fecha_desde."' and fecmov<='".$fecha_hasta."' order by fecmov,refmov";
	$result = pg_query($bd_conexion,$sql);

	while(($datos=pg_fetch_assoc($result))>0)
	{
		
		$feh=explode("-",$datos['fecmov']);
		$fecha_mov=$feh[2]."/".$feh[1]."/".$feh[0];
		
		$sql="select substr(desuso,1,16) as desuso from catusotar where coduso='".$datos['codusotar']."' ";
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
			$correl="ACT";
		else
			$correl="MOD";
			
		$pdf->SetFont('Arial','',8);
		$pdf->SetWidths(array(20,10,20,22,50,60,20,50,10,25,10,10,20,20,10,50));
		$pdf->SetAligns(array('L','C','L','L','L','L','L','L','L','C','L','L','L','L','L','L','L'));
		$dottom=number_format($datos['dottom'],0);
		$protom=number_format($datos['protom'],0);
		$pdf->Row(array($fecha_mov,$correl,$datos['observ'],$datos['numcta'],$datos['nomper'],$datos['dirper'],$datos['cedinq'],$datos['nominq'],$datos['nroapt'],$uso['desuso'],$dottom,$protom,$esttom,substr($empleado['nomusu'],0,20),$datos['codofi'],$datos['domfis']),4,0);	
		
	
	}

}

$pdf->Output('Movimiento_por_Cuenta.pdf','I');

?>