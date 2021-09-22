<?php

require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require("../../clases/utilidades.class.php");
require("../../libs/fpdf/fpdf.php");
require("../../clases/funciones.php");

$objUtilidades=new utilidades;
$cedula=@$_REQUEST['nom_usu'];
$oficina_hasta=@$_REQUEST['oficina_hasta'];
//$estatus=@$_REQUEST['valor'];

class PDF extends FPDF
{
	function Header()
	{		
	$objUtilidades=new utilidades;
		GLOBAL $bd_conexion;
					
	    //............. aqui se obtiene el nombre de la oficina comercial a procesar .......................
	
		/*$sql="select codofi,nomofi from paroficom where codofi='".@$_REQUEST['oficina_desde']."' ";
		$nombre_oficina=pg_query($bd_conexion,$sql);
		$comecial_oficina=pg_result($nombre_oficina,"nomofi");*/

		
		$sql="select codofi,nomofi from paroficom ";
		$nombre_oficina=pg_query($bd_conexion,$sql);
		$comecial_oficina=pg_result($nombre_oficina,"nomofi");
    	$this->SetFont('Arial','',10);
		$this->Cell(240,10,'HIDROSUROESTE',0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,'Fecha: '.date("d/m/Y"),0,0,'L');
		$this->Ln();
		$this->SetFont('Arial','',10);
		$this->Cell(240,10,'GERENCIA COMERCIAL',0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,'Hora: '.date("h:i:s A"),0,0,'L');
		$this->Ln();
		$this->SetFont('Arial','',10);
		$this->Cell(240,10,'FACTURACION',0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,latin1 ("Página").' '.$this->PageNo().'  de {nb}',0,0,'L');
		$this->Ln(5);	
		$this->SetFont('Arial','',10);
		$this->Cell(240,10,$comecial_oficina,0,0,'L');
		$this->SetFont('helvetica','',10);
		$this->SetY(14); $this->SetX(130); 
			
		$this->Cell(25,5,"LISTADO DE PERMISOLOGIA A SISCOM_WEB",0,0,'C');
		$this->SetFont('helvetica','',10);
		
		
		
if (@$_REQUEST['todas']=='true')
{		
$sql="select a.cedusu,a.nomusu,c.nomofi,d.nombre_modulo,d.nombre_pestana,e.descar
from pardefusu a, paraccsyn b, paroficom c,paraccsynnom d, pardefcrg e
where b.codintusu=a.codintusu and a.cedusu<>'' and b.codacc='1'
and c.codofi=b.codofi and d.codapl=b.codapl and e.codcar=a.codcar
group by a.cedusu,a.nomusu,c.nomofi,d.nombre_modulo,d.nombre_pestana,e.descar
order by a.cedusu,nomofi,d.nombre_modulo,d.nombre_pestana";
}

else
{
$sql="select a.cedusu,a.nomusu,c.nomofi,d.nombre_modulo,d.nombre_pestana,e.descar
from pardefusu a, paraccsyn b, paroficom c,paraccsynnom d, pardefcrg e
where  a.cedusu='".@$_REQUEST['cedula']."' and b.codintusu=a.codintusu and b.codacc='1'
and c.codofi=b.codofi and d.codapl=b.codapl and e.codcar=a.codcar
group by a.cedusu,a.nomusu,c.nomofi,d.nombre_modulo,d.nombre_pestana,e.descar
order by a.cedusu,nomofi,d.nombre_modulo,d.nombre_pestana";
}


$nombre=pg_query($bd_conexion,$sql);
$persona=pg_fetch_assoc($nombre);

if (@$_REQUEST['todas']=='false')
{
$this->Ln(12);
		$this->SetY(34);
		$this->SetX(10);
		$this->SetFont('Arial','',7);
	    $this->SetFillColor(255,255,255);
		$this->SetAligns(array('L'));		
		$this->SetWidths(array(100));
		$this->Row(array("NOMBRE  :".' '.$persona['nomusu']),5,0);
		$this->SetAligns(array('L'));

$this->Ln(12);
		$this->SetY(37);
		$this->SetX(10);
		$this->SetFont('Arial','',7);
	    $this->SetFillColor(255,255,255);
		$this->SetAligns(array('L'));		
		$this->SetWidths(array(100));
		$this->Row(array("CUDEULA  :".' '.$persona['cedusu']),5,0);
		$this->SetAligns(array('L'));

$this->Ln(12);
		$this->SetY(40);
		$this->SetX(10);
		$this->SetFont('Arial','',7);
	    $this->SetFillColor(255,255,255);
		$this->SetAligns(array('L'));		
		$this->SetWidths(array(100));
		$this->Row(array("CARGO  :".' '.$persona['descar']),5,0);
		$this->SetAligns(array('L'));
		
$this->Ln(12);
}
if (@$_REQUEST['todas']=='true')
{
		$this->SetY(50);
		$this->SetX(10);
		$this->SetFont('Arial','B',7);
		$this->SetFillColor(255,255,255);
		$this->SetAligns(array('C','C','C'));		
		$this->SetWidths(array(35,55,30,155,40));
		$this->Row(array("OFICINA","NOMBRE","MODULO","PESTAÑA"),5);
		$this->SetAligns(array('L','L','L','L')); 
}
		
else

{	
    	$this->SetY(50);
		$this->SetX(10);
		$this->SetFont('Arial','B',7);
		$this->SetFillColor(255,255,255);
		$this->SetAligns(array('C','C','C'));		
		$this->SetWidths(array(40,30,205));
		$this->Row(array("OFICINA","MODULO","PESTAÑA"),5);
		$this->SetAligns(array('L','L','L')); 
}
				
$this->Ln(5);		
	}	
	function Footer(){
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Vistas/Usuarios/Reporte_permisos_usuarios',0,0,'L');
}	
}
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("L");

if (@$_REQUEST['todas']=='true')
{
$sql="select a.cedusu,a.nomusu,c.nomofi,d.nombre_modulo,d.nombre_pestana,e.descar
from pardefusu a, paraccsyn b, paroficom c,paraccsynnom d, pardefcrg e
where b.codintusu=a.codintusu and b.codacc='1'
and c.codofi=b.codofi and d.codapl=b.codapl and e.codcar=a.codcar
group by a.cedusu,a.nomusu,c.nomofi,d.nombre_modulo,d.nombre_pestana,e.descar
order by a.cedusu,nomofi,d.nombre_modulo,d.nombre_pestana";
}
else
{
$sql="select a.cedusu,a.nomusu,c.nomofi,d.nombre_modulo,d.nombre_pestana,e.descar
from pardefusu a, paraccsyn b, paroficom c,paraccsynnom d, pardefcrg e
where  a.cedusu='".@$_REQUEST['cedula']."' and b.codintusu=a.codintusu and b.codacc='1'
and c.codofi=b.codofi and d.codapl=b.codapl and e.codcar=a.codcar
group by a.cedusu,a.nomusu,c.nomofi,d.nombre_modulo,d.nombre_pestana,e.descar
order by a.cedusu,nomofi,d.nombre_modulo,d.nombre_pestana";
}
$ok=pg_query($sql); 
while(($linea=pg_fetch_assoc($ok))>0)	
{	
if (@$_REQUEST['todas']=='true')
{

$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(255,255,255,255);
$pdf->SetAligns(array('L','L','L','L'));		
$pdf->SetWidths(array(35,55,30,155));
$pdf->Row(array($linea['nomofi'],$linea['nomusu'],$linea['nombre_modulo'],$linea['nombre_pestana']),5,0);
$pdf->SetAligns(array('L','L','L'));		
$pdf->SetWidths(array(40,50,30,155));
}

else
{
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(255,255,255);
$pdf->SetAligns(array('L','L','L'));		
$pdf->SetWidths(array(40,30,205,));
$pdf->Row(array($linea['nomofi'],$linea['nombre_modulo'],$linea['nombre_pestana']),5,0);
$pdf->SetAligns(array('L','L','L'));		
$pdf->SetWidths(array(40,30,205));
}

}
$pdf->Output('reppermisos.pdf','I');

?>