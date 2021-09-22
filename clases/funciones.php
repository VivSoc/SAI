<?php

function cuadro_mensaje($mensaje)
{
	if ($mensaje!="")
	{
		echo '<script language="JavaScript">alert("'.$mensaje.'")</script>';
	}
}

function cuadro_mensaje2($mensaje)
{
	if ($mensaje!="")
	{
		echo '<div id="mensaje"><script language="JavaScript">auto_mensaje("'.$mensaje.'")</script></div>';
	}
}

function funcion_js($funcion)
{
	echo '<script language="JavaScript">'.$funcion.'</script>';
}


function barra_progreso($accion,$tiempo)
{
	echo '<div id="progreso"><script language="JavaScript">barra_progreso("'.$accion.'","'.$tiempo.'")</script></div>';
}

function cuadro_cargando()
{
	
	/*
	 * <script>$("#progressbar").progressbar("destroy");</script>
			<script>$("#progressbar").progressbar("widget");</script>
	 */
	echo '	<div id="cargando">
				<script language="JavaScript">auto_cargando();</script>
				<div id="progressbar"></div>
			</div>';
}


function menu_opcion_simple($nombre,$ruta,$numero,$permiso)
{
	if ($permiso == "si" || $permiso == "0070000006")
	{
		echo '
		<li>
			<a href="#" rel="'.$numero.'" title="'.$ruta.'">
				<span class="file">'.$nombre.'</span>
			</a>
		</li>';
	}
}

function formato_numero($str){
	return number_format($str,2,".","");
}

function Grabar_RecargoPorServicio($Referencia,$SERVICIO,$Uso,$Monto,$MontoTotalRecargo)
{
	GLOBAL $bd_conexion;
	$sql = "SELECT TipRec,ValRec,CodRec FROM FacTipRec WHERE CodSer = '".$SERVICIO."' And CodUso='".$Uso."' and TemRec='P' and activo='S'";
	$result = pg_query($bd_conexion,$sql);
	if (pg_num_rows($result) > 0)
	{
		while ($registro=pg_fetch_assoc($result))
		{
			switch ($registro['tiprec'])
			{
				case "P":
				{
					$MontoRecargo = ($Monto * $registro['valrec']) / 100;
					break;
				}
				case "M":
				{
					$MontoRecargo = $registro['valrec'];
					break;
				}
			}
			$sql = "Insert into FacRecFac (RefFac,codtip,MonREC,MonAju,MonPag) values('".$Referencia."','".$registro['codrec']."',".$MontoRecargo.",0,0)";
			pg_query($bd_conexion,$sql);
			
			$sql = "update facregfac set monrec=".$MontoRecargo." where reffac = '".$Referencia."'";
			pg_query($bd_conexion,$sql);
		}
	}
	else
	{
		$MontoRecargo = 0;
	}
	return $MontoRecargo;
}

function En_Facturacion($Refpag, $CodigoInm,$CodigoPer, $CodigoTom, $FechaSol, $FechaVen, $CodOfi, $SubAcu, $Derecho, $TotalPres, $MontoSer,$MontoRec,$RefFac, $Cod_Fac, $Cuota, $CodIntUsu)
{
	GLOBAL $bd_conexion;
	
	switch ($Derecho) 
	{
 		case 0: 
 		{
 			$Xmon = $MontoSer;
        	$XTip = "O";    //Otro Servicio
  			break;
 		}
 	
 		case 1:
 		{
			$Xmon = $TotalPres;
			$XTip = "P";    //Otro Servicio por Derecho de Incorporacion
			break;
 		}
		case 2:
 		{
			$Xmon = $MontoSer;
			$XTip = "C";    //Convenios de pago
			break;
 		}
		case 3:
 		{
			$Xmon = $MontoSer;
			$XTip = "R";    //Creditos a cuenta
			break;
 		}
	}

 	$sql = "Select Codcic,rutmed,codusotar,zonope,siscom,codemp from maeregtom where codinttom='".$CodigoTom."'";
 	$result = pg_query($bd_conexion,$sql);
 
 	if (pg_num_rows($result)>0)
 	{
		$XCodCic = pg_result($result,0,"codcic");
		$XRutMed = pg_result($result,0,"rutmed");
		$XCodUsoTar = pg_result($result,0,"codusotar"); 
		$XZonOpe = pg_result($result,0,"ZonOpe");  
		$XSisCom =  pg_result($result,0,"SisCom");   
		$XCodEmp =  pg_result($result,0,"codemp"); 
 
		if (($CodigoTom =="") || ($CodigoTom =="9999999999"))
		{
        	$sql = "SELECT MIN(codcic) as xCodCic, MIN(codrut) as xCodRut FROM ParDefRut WHERE CodSubAcu = '".$SubAcu."' GROUP BY codsubacu";
        	$result = pg_query($bd_conexion,$sql);
        	
        	if (pg_num_rows($result)>0)
        	{
				$XCodCic = pg_result($result,0,"XCodCic");
				$XRutMed = pg_result($result,0,"xCodRut");
			}
    	}
 	}
 	else
 	{
		$XCodCic = "";
		$XRutMed = "";
		$XCodUsoTar = "";
		$XZonOpe = ""; 
		$XSisCom =  "";   
		$XCodEmp = ""; 
	}
 
	$fecha = date("d/m/Y");
	$fecha = formato_fecha($fecha);
	$FechaVen = formato_fecha($FechaVen);
	//echo $FechaVen; exit;
	
	if ($MontoRec=="")
	{
		$MontoRec = 0;
	}


	
	$est = "0";
	$sql = "Insert Into FacRegFac (
				RefFac,
				refpag,
				CodIntInm,
				CodIntPer,
				CodIntTom,
				CodIntEmp,
				codemi,
				fecemi,
				FecVen,
				OfiCom,
				SubAcu,
				ZonOpe,
				SisCom,
				codemp,
				orifac,
				CodCic,
				RutMed,
				CodUso,
				MonFac,
				tipfac,
				MonAju,
				MonRec,
				MonDes,
				MonPag,
				numcuo,
				EstFac)
			values(
				'".$RefFac."',
				'".$Refpag."',
				'".$CodigoInm."',
				'".$CodigoPer."',
				'".$CodigoTom."',
				'".$CodIntUsu."',
  				'".$Cod_Fac."',
  				'".date("Y-m-d")."',
  				'".$FechaVen."',
  				'".$CodOfi."',
  				'".$SubAcu."',
  				'".$XZonOpe."',
  				'".$XSisCom."',
  				'".$XCodEmp."',
  				'A',
  				'".$XCodCic."',
  				'".$XRutMed."',
  				'".$XCodUsoTar."',
  				".$Xmon.",
  				'".$XTip."',
  				0,
  				".$MontoRec.",
  				0,
  				0,
  				'".$Cuota."',
  				'0')";


  	$result = pg_query($bd_conexion,$sql);
  	
  	if (pg_affected_rows($result)>0)
  	{
		return 1;
  	}
  	else
  	{
  		return -1;
  	}
}

Function En_ServiciosFacturacion($RefFac,$CodSer,$CanFac,$PreRef,$MontoSer)
{
    GLOBAL $bd_conexion;
	//En_ServiciosFacturacion = False
	$sql = "Insert into FacSerFac (RefFac,CodSer,CanFac,CanAju,MonAju,MonPag,MonDes,PreRef,MonFac) values ('".
			$RefFac."','".$CodSer."',".$CanFac.",0,0,0,0,".$PreRef.",".$MontoSer.")";
	$result = pg_query($bd_conexion,$sql);
	if(pg_affected_rows($result)>0)
	{
		return 1;
	}
	else
	{
		return 0;
	}
	
}

function Act_FacRefFac($RefFac,$CampoClave ,$CodOfi)
{
    GLOBAL $bd_conexion;
    $facRefFac ="-1";
    $sql = "Select * from FacRefFac where OfiCom='".$CodOfi."'";
    $result=pg_query($bd_conexion,$sql);    
    if (pg_num_rows($result)>0)
    {
        $sql = "update facreffac set ".$CampoClave." = '".$RefFac."' WHERE oficom = '".$CodOfi."'";
    }
    else
    {
        $sql = "Insert into facreffac (".$CampoClave.", OfiCom) values ('".$RefFac."','".$CodOfi."')";
    }
    $result = pg_query($bd_conexion,$sql);
	if(pg_affected_rows($result)>0)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}


//FUNCIONES DE CHEQUE DEVUELTO

function reversar_cheque($codintusu, $refpag, $numide, $codban, $monche,$fecdev,$codintusu){

    GLOBAL $bd_conexion;
    pg_query($bd_conexion,'BEGIN;');

 
 // consulta los datos correpondiente al cheques devuelto
    $sql = "SELECT a.refpag,b.monpag,b.codban,a.codofi_cli,a.refpag,a.codcaj,a.fecpag,a.codofi,a.codusotar
        FROM recdetfor b, recregpag a
        WHERE a.refpag = '".$refpag."' and a.refpag=b.refpag and b.codfor = '002' AND b.numide = '".$numide."' AND b.codban = '".$codban."'";
        $result = pg_query($bd_conexion, $sql);
		
		$recdetfor=pg_fetch_assoc($result);
		

	$sql = "select b.codcta from recciecaj a, recdetcie b where a.codintcie=b.codintcie and codfor='002' and codcaj='".$recdetfor['codcaj']."' and feccie='".$recdetfor['fecpag']."'";
        $result1 = pg_query($bd_conexion, $sql);	
        $recciecaj=pg_fetch_assoc($result1);
		

    if (($recdetfor['refpag'] == '')  || ($recciecaj['codcta'] == ''))  
	    {
		
        cuadro_mensaje("LA CAJA NO ESTA CERRADA, DEBE HACER EL REVERSO POR CONSULTA DE PAGOS");
        return 0;
    }
    else {
		
		$codcta=$recciecaj['codcta'];
		
		$sql = "select nomofi,ctaofi from paroficom where codofi='".$recdetfor['codofi_cli']."'";
        $result = pg_query($bd_conexion, $sql);
		$paroficom=pg_fetch_assoc($result);
		
		$sql = "select ctauso from catusotar where coduso='".$recdetfor['codusotar']."'";
        $result = pg_query($bd_conexion, $sql);
		$ctauso=pg_fetch_assoc($result);
		
		
		
		$cuenta='1010201'.$paroficom['ctaofi'].$ctauso['ctauso'];
		
		$sql = "select nomins from parinsfin where codins='".$codban."'";
        $result = pg_query($bd_conexion, $sql);
		$parinsfin=pg_fetch_assoc($result);
				
		// Inserto el registro correpondiente en el detalle de cheques devueltos
		$sqltemp = "";
		$sqltemp = "INSERT INTO recintechedev(
				  fecha,
				  monto,
				  numide,
				  codban,
				  codofi_cli,
				  refpag,
				  codcta,
				  codintemp,
				  status,
				  codcon,
				  codofi,
				  banco,
				  fecpag)
			VALUES(
			    '".$fecdev."',
				'".$recdetfor['monpag']."',
				'".$numide."',
				'".$codban."',
				'".$recdetfor['codofi_cli']."',
				'".$recdetfor['refpag']."',
				'".$codcta."',
				'".$codintusu."',
				'0',
				'".$cuenta."',
				'".$recdetfor['codofi']."',
				'".$parinsfin['nomins']."',
				'".$recdetfor['fecpag']."')";
				
				
		$resulttmp=pg_query($bd_conexion,$sqltemp);
		
        $sql = "select refpag, codinttom, moncre from recregpag where refpag = '".$refpag."'";
        $result = pg_query($bd_conexion, $sql);
        if (pg_num_rows($result) == 0){
            cuadro_mensaje("ERROR BUSCANDO DATOS DEL COMPROBANTE DE PAGO");
            return 0;
        }
        else{
            $moncre = pg_result($result, 0, "moncre");
            $codinttom = pg_result($result, 0, "codinttom");
        }
		
		

        // Actualiza las facturas y captura si aun queda dinero por reversar
        $monche = actualiza_factura_a_reversar($codinttom, $refpag, $monche);

       
        // Si las facturas se actualizaron satisfactoriamente
        if ($monche > 0){

            // Si el comprobante acreditÛ en cuenta
            if($moncre > 0){
                $sql = "UPDATE maeregtom
                    SET moncre = CASE WHEN moncre - ".$monche." > 0 THEN moncre - ".$monche." ELSE 0 END
                    WHERE codinttom = '".$codinttom."'";
                
                $result = pg_query($bd_conexion, $sql);
                if (pg_affected_rows($result) == 0) {
                    cuadro_mensaje("ERROR REVERSANDO EL CREDITO EN EL MAESTRO DE TOMAS");
                    return 0;
                }
                else {
                    //cuadro_mensaje("MAEREGTOM ACTUALIZADO");
                    $monche = $monche - $moncre;

                    //Actualiza la tabla de Creditos
                    $sql = "UPDATE reccretom SET moncre = 0 WHERE refpag = '".$refpag."'";
			$result = pg_query($bd_conexion,$sql);

                    
                   
                }
            }


        }
		
	
    }

    //Actualiza en el maestro de tomas
    $result = pg_query($bd_conexion,"UPDATE maeregtom SET stache = '1' WHERE codinttom = '".$codinttom."'");
    if (pg_affected_rows($result) == 0) {
    	cuadro_mensaje("ERROR ACTUALIZANDO EL STACHE EN LA MAEREGTOM");
		return 0;
	}
	//Actualiza en el maestro de recregpag status
    
	$sql_che="delete from recdetche where refpag = '".$refpag."'";
	$regdetfor=pg_query($sql_che);
		
	$result = pg_query($bd_conexion,"UPDATE recregpag SET status = '3' WHERE refpag = '".$refpag."'");
    if (pg_affected_rows($result) == 0) 
	{
    	cuadro_mensaje("ERROR ACTUALIZANDO EL STATUS EN LA RECREGPAG");
		return 0;
	}
	 
	 $sql="Update recdetfor set fecdevche='".date('Y/m/d')."', fecdevcheban='".$fecdev."' where refpag='".$refpag."' and codfor='002'";
	 $result = pg_query($bd_conexion,$sql);

    return 1;
}


function actualiza_factura_a_reversar($codinttom, $refpag, $monche){

    GLOBAL $bd_conexion;

    // Determino si en el pago se retuvo impuesto y el monto retenido
    $sql = "select monpag from recdetfor where refpag = '".$refpag."' and codfor = '006'";
    $result = pg_query($bd_conexion, $sql);
    if (pg_num_rows($result) > 0){
        $monret = pg_result($result, 0, "monpag");
    }
    else{
        $monret = 0;
    }

    // Busco todas las facturas pagadas en el recibo de pago
    $sql = "SELECT * FROM recdetpag WHERE refpag = '".$refpag."'";
    

    
    $result = pg_query($bd_conexion, $sql);
    if (pg_num_rows($result) > 0){
        while($monche > 0 && $linea = pg_fetch_assoc($result)){

            // Si el pago retuvo IVA, se reversa el pago menos el monto retenido
            if ($monret > 0){
                $monrev = $linea["monpag"] - $linea["monrec"] * (0.75);
            }
            else{
                $monrev = $linea["monpag"];
            }

            // Si el monto del cheque reversa el pago completo
            if ($monche >= $monrev){
                $monche = $monche - $monrev;
            }
            else{
                $monrev = $monche;
                $monche = 0;
            }

            // Actualiza el Maestro de FacturaciÛn
            $sql2 = "UPDATE facregfac SET monpag = monpag - ".$monrev.", estfac = '0'
                WHERE reffac = '".$linea["reffac"]."'";

            $result2 = pg_query($bd_conexion, $sql2);

            if (pg_affected_rows($result2) == 0) {
                cuadro_mensaje("FACREGFAC NO ACTUALIZADO");
                return -1;
            }
           // else {
                //cuadro_mensaje("FACREGFAC ACTUALIZADO");
           // }

            // Determina si el reverso de la factura implica un proceso adicional
            $xcodemi = $linea["codemi"];
            switch ($xcodemi) {
                case "CREDIT":{
                    $sql2 = "UPDATE maeregtom
                        SET moncre = CASE WHEN moncre - ".$linea["monpag"]." > 0 THEN moncre - ".$linea["monpag"]." ELSE 0 END
                        WHERE codinttom = '".$codinttom."'";




                    $result2 = pg_query($bd_conexion, $sql2);
                    if (pg_affected_rows($result2) == 0){
                        cuadro_mensaje("MAEREGTOM NO ACTUALIZADO");
                        return -1;
                    }
                  //  else{
                        //cuadro_mensaje("MAEREGTOM ACTUALIZADO");
                  //  }
                    break;
                }
                case "CVN_PG":{
                    $sql2 = "UPDATE facregfac SET estfac = '7', fecpag = NULL
                        WHERE reffac in (SELECT a.reffac
                                        FROM cdpcuofac a INNER JOIN cdpdetcon b on a.refcon = b.refcon AND a.numcuo = b.numcuo
                                        WHERE b.reffac = '".$linea["reffac"]."')";
                    $result2 = pg_query($bd_conexion, $sql2);
                    if (pg_affected_rows($result2) == 0){
                        cuadro_mensaje("ERROR ACTUALIZANDO LAS FACTURAS ASOCIADAS A LA CUOTA CONVENIO");
                        return -1;
                    }
                  //  else {
                        //cuadro_mensaje("FACTURAS DEL CONVENIO ACTUALIZADAS");
                  //  }
                    $sql2 = "UPDATE cdpdetcon SET monpag = monpag - ".$monrev.", fecpag = null, EstCuo = 'V'
                        WHERE reffac = '".$linea["reffac"]."'";
                    $result2 = pg_query($bd_conexion,$sql2);
                    if (pg_affected_rows($result2) == 0) {
                        cuadro_mensaje("ERROR ACTUALIZANDO EL REGISTRO CORRESPONDIENTE EN EL CONVENIO");
                        return -1;
                    }
                  //  else {
                        //cuadro_mensaje("CDPDETCON ACTUALIZADO");
                  //  }
                }
            }

            $ref_factura = $linea["reffac"];

            $sql2 = "SELECT * FROM aclsolser WHERE numfac = '".$ref_factura."'";
           //echo $sql2; exit();            
$result2 = pg_query($bd_conexion, $sql2);

            if (pg_num_rows($result2) > 0){

                $sql2 = "UPDATE aclsolser SET stasol = '0' WHERE numfac = '".$ref_factura."'";
                $result2 = pg_query($bd_conexion, $sql2);

                if (pg_affected_rows($result2) > 0){
                    //cuadro_mensaje("AclSolSer ACTUALIZADO");
                }
                else {
                    cuadro_mensaje("AclSolSer NO ACTUALIZADO");
                    return -1;
                }
            }

            if (reversar_descuento($ref_factura) == 0) {
                return -1;
            }

            $sql2 = "SELECT * FROM facserfac WHERE reffac = '".$ref_factura."' AND monpag > 0";
          
  $result2 = pg_query($bd_conexion, $sql2);

            if (pg_num_rows($result2) > 0){

                while ($monrev > 0 && $linea2 = pg_fetch_assoc($result2)){

                    if (($monrev - $linea2["monpag"]) > 0) {
                        $monrev = $monrev - $linea2["monpag"];
                        $monto = 0;
                    }
                    else{
                        $monto = $linea2["monpag"] - $monrev;
                        $monrev = 0;
                    }

                    // Si el pago de la factura generÛ una reinstalaciÛn
                    if ($linea2["codser"] == "008" || $linea2["codser"] == "024"){
                        $reinstalacion = $linea2["codser"];
                    }

                    // Actualiza la tabla de servicios
                    $sql3 = "UPDATE facserfac SET monpag = ".$monto."
                        WHERE reffac = '".$ref_factura."' AND codser = '".$linea2["codser"]."'";
                    
                    //echo $sql3; exit();
                    $result3 = pg_query($bd_conexion, $sql3);
                    if (pg_affected_rows($result3) == 0){
                        cuadro_mensaje("FacSerFac NO ACTUALIZADO");
                        return -1;
                    }
                   // else {
                        //cuadro_mensaje("FacSerFac ACTUALIZADO");
                   // }
                }
            }

            // Si aun queda dinero por reembolzar, actualiza la Tabla de Recargos
            if ($monrev > 0){
                $sql2 = "SELECT * FROM facrecfac WHERE reffac = '".$ref_factura."' and monpag > 0";
                $result2 = pg_query($bd_conexion, $sql2);

                if (pg_num_rows($result2) > 0){
                    while ($monrev > 0 && $linea2 = pg_fetch_assoc($result2)){
                        if (($monrev - $linea2["monpag"]) > 0) {
                            $monrev = $monrev - $linea2["monpag"];
                            $monto = 0;
                        }
                        else{
                            $monto = $linea2["monpag"] - $monrev;
                            $monrev = 0;
                        }
                        $sql3 = "UPDATE facrecfac SET monpag = ".$monto."
                            WHERE RefFac = '".$ref_factura."' AND codtip = '".$linea2["codtip"]."'";
                        $result3 = pg_query($bd_conexion,$sql3);
                        if (pg_affected_rows($result3) == 0) {
                            cuadro_mensaje("FacRecFac NO ACTUALIZADO");
                            return -1;
                        }
                       // else {
                            //cuadro_mensaje("FacRecFac ACTUALIZADO");
                       // }
                    }
                }
            }
        }
        if ($reinstalacion != ""){
            if (anula_orden() == 0){
                return -1;
            }
        }
    }



    return $monche;
} 





function reversar_descuento($referencia){
	
	GLOBAL $bd_conexion;	
	
	$monto_reversar = 0;
	$sql1 = "select * from facdesfac where reffac='".$referencia."'";
	$result1 = pg_query($bd_conexion,$sql1);
	if (pg_num_rows($result1) > 0){
    	$sql2 = "select * from factipdes where coddes='".pg_result($result1,0,"codtip")."'";
    	$result2 = pg_query($bd_conexion,$sql2);
    	if (pg_num_rows($result2) > 0){
    		while ($registro=pg_fetch_assoc($result2)){
				if ($registro["facrec"] == "R"){
                	///////////////////////////////////////////////////////////////////////////////////
                	///// El descuento fue generado en la recaudacion por lo que debemos reversar /////
                	///////////////////////////////////////////////////////////////////////////////////
                	$monto_reversar = $monto_reversar + pg_result($result1,0,"mondes");
                	pg_query($bd_conexion,"Update FacSerFac set MonDes = Mondes - ".pg_result($result1,0,"mondes")." Where RefFac = '".$referencia."' and CodSer = '".$registro["codser"]."'");
                	pg_query($bd_conexion,"Update FacRegFac set MonDes = Mondes - ".pg_result($result1,0,"mondes")." Where RefFac = '".$referencia."'");
            	}
			}
		}
	}
	return 1;
}

function anula_orden($ref_factura,$reinstalacion){
	
	GLOBAL $bd_conexion;
	
	$sql = "update ortordtra set status = 'A' where tipord in ('002', '999') and reffac = '".$ref_factura."'";
	$result = pg_query($bd_conexion,$sql);

	$sql = "update ortordtra set status = 'E' where tipord in ('003', '024') and reffac = '".$ref_factura."' and status = 'R'";
	$result = pg_query($bd_conexion,$sql);
	
	if ($reinstalacion == "008") $xesttom = "3";
	else $xesttom = "6"; 
	
	$sql = "update maeregtom set esttom = '".$xesttom."' where codinttom = '".codinttom."'";
	$result = pg_query($bd_conexion,$sql);
	
	return 1;

}






//FIN DE FUNCIONES DE CHEQUE DEVUELTO


function fecha_ingresada($fecha){
	if ($fecha == "") return date("d/m/Y");
	else return $fecha;
}

function salir(){
	
	echo "<script>window.close();</script>";
	exit();
	
}

function cta_min_max($acueducto,$ciclo,$emision,$tipo){
	
	GLOBAL $bd_conexion;	
	if ($ciclo=="" && $acueducto != "" && $emision!= ""){
   		$sql = "Select Max(B.NumCta) as maxima,Min(B.NumCta) as minima from MaeRegTom B,FacRegFac a
        		where a.CodIntTom=b.CodIntTom And a.SubAcu='".$acueducto."' and 
        		a.codemi='".$emision."'";
   		
   		//echo $sql; exit();
   		$result = pg_query($bd_conexion,$sql);
   		if (pg_num_rows($result)>0){      
			$cuentamin = pg_result($result,0,"maxima");
			$cuentamax = pg_result($result,0,"minima");
		}
	}
	else{
		if ($ciclo!="" && $acueducto != "" && $emision!= ""){
			$sql = "select * from maymencuenta('".$acueducto."','".$ciclo."',".$emision."')";
			$result = pg_query($bd_conexion,$sql);
   			if (pg_num_rows($result)>0){      
            		$cuentamin = pg_result($result,0,"maxima");
            		$cuentamax = pg_result($result,0,"minima");
   			}
		}
	}
	if ($tipo == "max") return $cuentamax;
	if ($tipo == "min") return $cuentamin;
	
	
}



function formato_entero($str){
	return number_format($str,0,",",".");
}

function formato_moneda($str){
	return number_format($str,2,",",".");
}

function formato_fecha($fecha){
	if (substr($fecha,4,1)=="-"){
		$fecha_nueva = substr($fecha,8,2)."/".substr($fecha,5,2)."/".substr($fecha,0,4);
		return $fecha_nueva;
	}
	if (substr($fecha,2,1)=="/"){
		$fecha_nueva = substr($fecha,6,4)."-".substr($fecha,3,2)."-".substr($fecha,0,2);
		return $fecha_nueva;
	}
	return $fecha;
}


function convertir_a_numero($str)
{
  $legalChars = "%[^0-9\-\. ]%";

  $str=preg_replace($legalChars,"",$str);
  return $str;
}


//ACTUALIZADA EL 08/08/2012 POR ING. EUDES VILLALBA
function obtener_emisionactual()
{
	GLOBAL $bd_conexion;
	$sql = "SELECT codemi,desemi FROM facemisio WHERE estemi = 'A'";
	$result = pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{
		return pg_result($result,0,"codemi");
	}
	else
	{
   		//cuadro_mensaje2("No existe ninguna EmisiÛn Abierta");
   		return;
	}
}

//DEVUELVE LA EMISION ANTERIOR
function emision_anterior($str)
{
	$mes = 0;
	$ano = 0;
	$emisionanterior = "";
	$mes = convertir_a_numero(substr($str,0,2));
	$ano = convertir_a_numero(substr($str,2,4));
	if ($mes == 1){
   		$mes = 12;
   		$ano = $ano - 1;
	}
	else{
   		$mes = $mes - 1;
	}
	if ($mes >= 1 && $mes <= 9){
   		$emisionanterior = "0" . (string) $mes;
	}
   	else{
   		if ($mes > 9){
   			$emisionanterior = (string) $mes;
   		}
   	}
	$emisionanterior = $emisionanterior . (string) $ano;
	return $emisionanterior;

}

//DEVUELVE LA EMISION ANTERIOR SI LA ANTERIOR A ESTA EST¡ CERRADA
function obtener_emisionanterior($str){
	GLOBAL $bd_conexion;
	$mes = 0;
	$ano = 0;
	$emisionanterior = "";
	$mes = convertir_a_numero(substr($str,0,2));
	$ano = convertir_a_numero(substr($str,2,4));
	if ($mes == 1){
   		$mes = 12;
   		$ano = $ano - 1;
	}
	else{
   		$mes = $mes - 1;
	}
	if ($mes >= 1 && $mes <= 9){
   		$emisionanterior = "0" . (string) $mes;
	}
   	else{
   		if ($mes > 9){
   			$emisionanterior = (string) $mes;
   		}
   	}
	$emisionanterior = emision_anterior($str);

	$sql = "Select * from FacEmiSio where codemi = '" . $emisionanterior . "'";
	$result=pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{
   		if (pg_result($result,0,"estemi") == "A")
   		{
   			cuadro_mensaje2("La Emision anterior a esta se encuentra abierta");
      		return "0";
      	
		}
    	else{
    		return $emisionanterior;
    		
    	}
	}
   	else{
    	cuadro_mensaje2("La Emision no puedo ser abierta, ya que la anterior a esta no ha sido procesada");
    	return "0";
   	}
   	return $emisionanterior;
}

function latin1($txt) {
 $encoding = mb_detect_encoding($txt, 'ASCII,UTF-8,ISO-8859-1');
 if ($encoding == "UTF-8") {
     $txt = utf8_decode($txt);
 }
 return $txt;
}

function utf8($txt) {
 $encoding = mb_detect_encoding($txt, 'ASCII,UTF-8,ISO-8859-1');
 if ($encoding == "ISO-8859-1") {
     $txt = utf8_encode($txt);
 }
 return $txt;
}


function primer_registro($tabla,$pk){
	GLOBAL $bd_conexion;
	$sql = "select min(".$pk.") as minimo from ".$tabla;
	//cuadro_mensaje($sql); exit();
	$result_minimo=pg_query($bd_conexion,$sql);
	return pg_result($result_minimo,0,"minimo");
}

function ultimo_registro($tabla,$pk){
	GLOBAL $bd_conexion;
	$sql = "select max(".$pk.") as maximo from ".$tabla;
	$result_maximo=pg_query($bd_conexion,$sql);
	return pg_result($result_maximo,0,"maximo");
}

function registro_anterior($tabla,$pk,$codini,$campos){
	
	GLOBAL $bd_conexion;
	if ($codini==primer_registro($tabla,$pk)){
		$sql="select ".$campos." from ".$tabla." where ".$pk." = (select max( ".$pk." ) from ".$tabla." )";
	}
	else{
		if ($codini==""){
			$sql="select ".$campos." from ".$tabla." where ".$pk." = (select min( ".$pk." ) from ".$tabla." )";
		}
		else{
			$sql="select ".$campos." from ".$tabla." where ".$pk." < '".$codini."' order by ".$pk." desc limit 1";
		}
	}
	return $sql;
	
}

function registro_siguiente($tabla,$pk,$codini,$campos){
	
	GLOBAL $bd_conexion;
	if ($codini==ultimo_registro($tabla,$pk)){
		$sql="select ".$campos." from ".$tabla." where ".$pk." = (select min( ".$pk." ) from ".$tabla." )";
	}
	else{
		if ($codini==""){
			$sql="select ".$campos." from ".$tabla." where ".$pk." = (select max( ".$pk." ) from ".$tabla." )";
		}
		else{
			$sql="select ".$campos." from ".$tabla." where ".$pk." > '".$codini."' order by ".$pk." limit 1";
		}
	}
	return $sql;
	
}


function consultar_grupo($condicion){
	//FUNCION PARA BUSCAR LA INFORMACION ASOCIADA AL GRUPO DE DOMICILIACION
	GLOBAL $bd_conexion;
	GLOBAL $codigo,$nombre,$descripcion,$domiciliacion,$ctacre,$forpaguni,$reqres,$codforpag,$codins,$ctacre,$numcue;	
	
	$sql="select codgru,nomgru,desgru,estdom,a.numcue,codfor,estforpag,estres,b.codinsfin
			from recgrudom a
			inner join concueban b on a.numcue = b.codintcue
			where ".$condicion;
	
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$codigo = pg_fetch_result($result10,0,"codgru");
		$nombre = pg_fetch_result($result10,0,"nomgru");
		$descripcion = pg_fetch_result($result10,0,"desgru");
		$domiciliacion = pg_fetch_result($result10,0,"estdom");
		$ctacre = pg_fetch_result($result10,0,"numcue");
		$forpaguni = pg_fetch_result($result10,0,"estforpag");
		$reqres = pg_fetch_result($result10,0,"estres");
		$codforpag = pg_fetch_result($result10,0,"codfor");
		$codins = pg_fetch_result($result10,0,"codinsfin");
		$numcue = pg_fetch_result($result10,0,"numcue");
	}
}

function def_archivo_dom($codigo)
{
	//FUNCION PARA COLOCAR EN EL FORMULARIO LOS CHECK DE PARAMETRIZACION
	//DEL ARCHIVO DE DOMICILIACION
	GLOBAL $bd_conexion;
	GLOBAL $numcam, $loncam, $ordarc;
		
	for($i=0;$i<9;$i++)
	{
		$numcam[$i] = "N";
		$loncam[$i] = "N";
		$ordarc[$i] = "N";
	}	
	
	$sql="SELECT count(numcam) as max_i FROM recgrudomarc Where Rtrim(CodGru) = '".$codigo."'";
	$result10=pg_query($bd_conexion,$sql);
	$max_i = pg_result($result10,0,"max_i");
		
	$sql="SELECT numcam, loncam, ordarc FROM recgrudomarc Where Rtrim(CodGru) = '".$codigo."'";
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		for($i=0;$i<$max_i;$i++)
		{
			if (pg_result($result10,$i,"loncam")!=0 && pg_result($result10,$i,"ordarc")!=0)
			{
				$numcam[pg_fetch_result($result10,$i,"numcam")] = pg_fetch_result($result10,$i,"numcam");
				$loncam[pg_fetch_result($result10,$i,"numcam")] = pg_fetch_result($result10,$i,"loncam");
				$ordarc[pg_fetch_result($result10,$i,"numcam")] = pg_fetch_result($result10,$i,"ordarc");
			}
			else
			{
				$numcam[pg_fetch_result($result10,$i,"numcam")] = "N";
				$loncam[pg_fetch_result($result10,$i,"numcam")] = "N";
				$ordarc[pg_fetch_result($result10,$i,"numcam")] = "N";
			}
		}
	}
}

function ins_dat_archivo_dom($codigo,$numero,$longitud,$orden)
{
	GLOBAL $bd_conexion;
	if ($longitud == "") 
	{
		$longitud = "0";
	}
	if ($orden == "") 
	{
		$orden = "0";
	}	

	if ($longitud != "0" && $orden!= "0")
	{
		$sql="insert into recgrudomarc (codgru,numcam,loncam,ordarc) values ('".$codigo."','".$numero."','".$longitud."','".$orden."')";
		$result10=pg_query($bd_conexion,$sql);
	}
}


function buscar_responsable($pais,$estado,$municipio,$localidad,$urbanizacion,$motivo){
	GLOBAL $bd_conexion;
	$sql = "SELECT a.codintusu, b.nomusu FROM parmotlocusu a INNER JOIN pardefusu b on 
		a.codintusu = b.codintusu WHERE 
		a.codbarurb = '".$urbanizacion."' and
		a.codloc = '".$localidad."' and 
		a.codpai = '".$pais."' and 
		a.codest = '".$estado. "' and 
		a.codmun = '".$municipio."' and 
		a.codmot = '".$motivo."' and
		estreg = '1'";
	
		$result3=pg_query($bd_conexion,$sql);
		if (pg_num_rows($result3)>0)
		{
			$responsable = pg_fetch_result($result3,0,"codintusu");
		}
	
		return $responsable;
}


/*
function buscar_responsable($pais,$estado,$municipio,$localidad,$motivo){
	GLOBAL $bd_conexion;
	$sql = "SELECT a.codintusu, b.nomusu FROM parmotlocusu a INNER JOIN pardefusu b on 
		a.codintusu = b.codintusu WHERE 
		a.codloc = '" .$localidad. "' AND 
		a.codmot = '" .$motivo. "' and 
		a.codpai = '" .$pais. "' and 
		a.codest = '" .$estado. "' and 
		a.codmun = '" .$municipio. "' and 
		estreg = '1'";
		
		$result3=pg_query($bd_conexion,$sql);
		if (pg_num_rows($result3)>0){
			$responsable = pg_fetch_result($result3,0,"codintusu");
		}
		else cuadro_mensaje("No esta registrado un responsable para este reclamo");
	
		return $responsable;
}
*/



function nombre_archivo($ruta){
	$trozos=explode("/",$ruta);
	return $trozos[count($trozos)-1];
}

function correl_codint($codigo){
	$codigo=$codigo+1;
	while (strlen($codigo)<10){
		$codigo='0'.$codigo;
	}
	return $codigo;
}
function generar_codigointerno($tabla,$campo,$oficina){
	GLOBAL $bd_conexion;
	if ($tabla=='MAEREGTOM' && $campo=='CodIntTom')
	{
		$maxcodigo=$oficina.'9999999';
		$sql="select max(".$campo.") as maximo from ".$tabla." where ".$campo." like '".$oficina."%' and codinttom<'".$maxcodigo."'";
		
	}
	else
	{
		if ($tabla=='MAEREGINM' && $campo=='CodIntInm')
		{
			$maxcodigo=$oficina.'9999999';
			$sql="select max(".$campo.") as maximo from ".$tabla." where ".$campo." like '".$oficina."%' and codintinm<'".$maxcodigo."'";
			
		}
		else
			$sql="select max(".$campo.") as maximo from ".$tabla." where ".$campo." like '".$oficina."%'";
	}
	//cuadro_mensaje2($sql);	
	$result=pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0){
		$codigo=substr(pg_result($result,0,"maximo"),3,7);
	} else
	{
		$codigo=0;
	}
	$codigo=$codigo+1;
	while (strlen($codigo)<7){
		$codigo='0'.$codigo;
	}
	return $oficina.$codigo;
}


function estatus_caja($codofi,$codcaj){	//Busca el estatus actual de la caja, devuelve "A" si esta abierta y "C" si esta cerrada
	GLOBAL $bd_conexion;
	$result=pg_query($bd_conexion,"select case when count(a.codintape)>count(b.codintcie) then 'A' else 'C' end as estatus from recapecaj a left join recciecaj b on a.fecape=b.feccie and a.codofi=b.codofi and a.codcaj=b.codcaj where a.fecape='".date("Y-m-d")."' and a.codofi='".$codofi."' and a.codcaj='".$codcaj."'");
	return pg_result($result,0,"estatus");
}

function tiene_caja_abierta($codintemp){//Busca si el usuario ya posee una caja abierta, devuelve el codigo de la caja o vacio en caso de no tener
	GLOBAL $bd_conexion;
	$aperturas=0;
	$cierres=0;

	$sql = "select * from recapecaj where fecape='".date("Y-m-d")."' and codintemp='".$codintemp."' and stacie='A' order by horape desc";
	
	$result=pg_query($bd_conexion,$sql);
	$aperturas=pg_num_rows($result);
	if ($aperturas>0){
		
		$result2=pg_query($bd_conexion,"select * from recciecaj where feccie='".date("Y-m-d")."' and codintemp='".$codintemp."' and codcaj='".pg_result($result,0,'codcaj')."' order by horcie desc");
		$cierres=pg_num_rows($result2);
		
		if ($aperturas>$cierres)
		{
		
			return pg_result($result,0,"codcaj");
		} else
		{
			return "";
		}
		
	} else
	{
		return "";
	}
}


function descuento_factura($reffac){
	GLOBAL $bd_conexion;
	$total=0;
	$descuento=0;
	
	$result1=pg_query($bd_conexion,"select * from facregfac where reffac='".$reffac."'");
	if (pg_num_rows($result1)>0){
		$coduso=pg_result($result1,0,"coduso");
		$fecven=pg_result($result1,0,"fecven");
		
		if (date("Y-m-d")<=$fecven){
			$result2=pg_query($bd_conexion,"select * from facserfac where reffac='".$reffac."'");
			if (pg_num_rows($result2)>0){
				
				while ($linea2=pg_fetch_assoc($result2)){
					$codser=$linea2["codser"];
					$monto=$linea2["monfac"];
			
					$result3=pg_query($bd_conexion,"select * from factipdes where coduso='".$coduso."' and codser='".$codser."' and facrec='R' and status='1'");
					if (pg_num_rows($result3)>0){
						while ($linea3=pg_fetch_assoc($result)){
							$tipdes=$linea3["tipdes"];
							$valdes=$linea3["valdes"];
					
							switch($tipdes){
								case 'P':
									$descuento=($monto*$valdes)/100;
								break;
								case 'M':
									$descuento=$valdes;
								break;
							}
							$total=$total+$descuento;
						}
					} else
					{
						return 0;
					}
					return $total;
				}
			} else
			{
				return 0;
			}
		} else
		{
			return 0;
		}
	} else
	{
		return 0;
	}
	
}

//FUNCION CREADA POR EUDES
function correl_ordtra($codofi){
	GLOBAL $bd_conexion;
	$result=pg_query($bd_conexion,"select max(substr(numord,4,8)) as numord from ortordtra where oficom='".$codofi."'");
	//$sql="select max(substr(numord,4,8)) as numord from ortordtra where oficom='".$codofi."'";
	if (pg_num_rows($result)>0){
		//$numord=intval(pg_result($result,0,"numord"));
		
		//cuadro_mensaje2("el numero es ".$numord. "el sql es ".$sql." la oficina es".$codofi);
		$numord=intval(pg_result($result,0,"numord"))+1;
		while (strlen($numord)<7){
			$numord='0'.$numord;
		}
		return $codofi.$numord;
	} else
	{
		return $codofi."0000001";
	}
}

function correl_refpag($codofi,$codcaj){
	GLOBAL $bd_conexion;

	$result=pg_query($bd_conexion,"select max(substr(refpag,7,14)) as refpag from recregpag where codofi='".$codofi."' and codcaj='".$codcaj."'");

	if (pg_num_rows($result)>0){
		$refpag=intval(pg_result($result,0,"refpag"))+1;
		
		while (strlen($refpag)<14){
			$refpag='0'.$refpag;
		}

		
		return $codofi.$codcaj.$refpag;
	} else
	{

		return $codofi.$codcaj."0000000000001";
	}
}

function correl_reffac($codofi)
{
	//echo $codofi;
	GLOBAL $bd_conexion;
	$sql = "select max(substr(refser,5,16)) as reffac from facreffac where oficom='".$codofi."'";
	$result=pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{
		$reffac=intval(pg_result($result,0,"reffac"))+1;
		while (strlen($reffac)<16)
		{
			$reffac='0'.$reffac;
		}
		return $codofi."P".$reffac;
	} 
	else
	{
		return $codofi."0000000000001";
	}
}


function correl_servicios($codofi,$campo,$tipo)
{
	GLOBAL $bd_conexion;
	$sql = "select $campo as reffac from facreffac where oficom='".$codofi."'";
	$result=pg_query($bd_conexion,$sql);
	$var = ($tipo=='P') ? 16 : 15;
	if (pg_num_rows($result)>0)
	{
		$reffac=intval(substr(pg_result($result,0,"reffac"),5))+1;
		while (strlen($reffac)<$var)
		{
			$reffac='0'.$reffac;
		}
		return $codofi.$tipo.$reffac;
	} 
	else
	{
		return $codofi.$tipo."0000000000001";
	}
}

function correl_num_control($codofi,$campo)
{
	GLOBAL $bd_conexion;
	$sql = "select $campo as numcon from facreffac where oficom='".$codofi."'";
	$result=pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{

		$numcon=intval(pg_result($result,0,"numcon"))+1;

		while (strlen($numcon)<8)
		{
			$numcon='0'.$numcon;
     		
		}
		
		return $numcon;
		
	} 
	else
	{
		return "00000001";
	}
}



function correl_refcon($codofi){
	GLOBAL $bd_conexion;
	$result=pg_query($bd_conexion,"select max(substr(refcon,7,14)) as refcon from facreffac where oficom='".$codofi."'");
	if (pg_num_rows($result)>0){
		$refcon=intval(pg_result($result,0,"refcon"))+1;
		while (strlen($refcon)<14){
			$refcon='0'.$refcon;
		}
		return "CON".$codofi.$refcon;
	} else
	{
		return "CON".$codofi."00000000000001";
	}
}

function correl_refcre($codofi){
	GLOBAL $bd_conexion;
	$result=pg_query($bd_conexion,"select max(substr(refcre,7,14)) as refcre from facreffac where oficom='".$codofi."'");
	if (pg_num_rows($result)>0){
		$refcre=intval(pg_result($result,0,"refcre"))+1;
		while (strlen($refcre)<14){
			$refcre='0'.$refcre;
		}
		return "CRE".$codofi.$refcre;
	} else
	{
		return "CRE".$codofi."00000000000001";
	}
}


function cifrar_password($pass){
	$pass=strtoupper($pass);
	$clave='NIMOLUMA';
	$cont_clave=0;
	$cont_pass=0;
	$pass_cif="                                                                           ";
	$cont_char=1;
	for ($i=0; $i<75;$i++){
		if ($cont_char==5){
			$num=ord($clave{$cont_clave})+ord($pass{$cont_pass});
			if (($num>126 and $num<161) or $num==39 or $num==40 or $num==41){
				$num=ord($pass{$cont_pass});
			}
			if($num>255){
				$num=$num-255;
			}
			if ($num==39 or $num==40 or $num==41){
				$num=ord($pass{$cont_pass});
			}
			$pass_cif{$i}=chr($num);
			$cont_pass++;
		} else
		{
			$pass_cif{$i}=chr(rand(1,126));
			if ((ord($pass_cif{$i})>126 and ord($pass_cif{$i})<161) or ord($pass_cif{$i})==39 or ord($pass_cif{$i})==40 or ord($pass_cif{$i})==41){
				$pass_cif{$i}=chr(rand(42,126));
			}
		}
		
		$cont_clave++;
		if ($cont_clave+1>strlen($clave)) $cont_clave=0;
		$cont_char++;
		if ($cont_char>5) $cont_char=1;
	}
	return $pass_cif;
}


function descifrar_password($pass,$nivel){
	$clave='NIMOLUMA';
	$cont_clave=0;
	$cont_pass=0;
	$pass_des="               ";
	$cont_char=1;
	$cont_nivel=0;
	for ($i=0; $i<75;$i++){
		if ($cont_char==5){
		if ($cont_nivel<$nivel){
			$num=ord($clave{$cont_clave})+ord($pass{$i});
			if (($num>126 and $num<161) or $num==39 or $num==40 or $num==41){
				$num=ord($pass{$i});
			} else
			{
				$num=ord($pass{$i})-ord($clave{$cont_clave});
			}
			if($num<0){
				$num=$num+255;
			}

			$pass_des{$cont_pass}=chr($num);
			$cont_pass++;
			$cont_nivel++;
		}
		}
		$cont_clave++;
		if ($cont_clave+1>strlen($clave)) $cont_clave=0;
		$cont_char++;
		if ($cont_char>5) $cont_char=1;
	}
	return trim($pass_des);
}






//Nombre de la persona
function obtener_nombrepersona($cuenta){
	GLOBAL $bd_conexion;
	$nombre = "";
	$sql = "Select codintper as codigo From MaeRegTom Where NumCta ='".$cuenta."'";
	$result = pg_query($bd_conexion,$sql);


		if (pg_num_rows($result)>0){      
			$clave = pg_result($result,0,"codigo");
			$sql = "Select nomper as nomb From maeregper Where CodIntPer = '".$clave."'";
			  
	
			$result = pg_query($bd_conexion, $sql);
			    if (pg_num_rows($result)>0){
					$nombre = pg_result($result,0,nomb);
					return $nombre;
				}
		}
return $nombre;
	
}
function validar_nombrepersona($cuenta, $acueducto,$ciclo,$emision,$desderuta,$hastaruta,$desuso,$hasuso){
	GLOBAL $bd_conexion;
	if ($ciclo==""){
	$sql = "Select a.codintper as codigo from MaeRegTom a,FacRegFactmp b
    where a.NumCta= '".$cuenta."' and a.codinttom=b.codinttom And b.codemi='".$emision."' and b.SubAcu='".$acueducto."'
       and trim(b.RutMed) between '".$desderuta."' and '".$hastaruta."' and b.coduso between
		  '".$desuso."' and '".$hasuso."'";
	$result = pg_query($bd_conexion,$sql);
   		if (pg_num_rows($result)>0){      
			return "1";
		}

}else
{
$sql = "Select a.codintper as codigo from MaeRegTom a,FacRegFactmp b
    where a.NumCta= '".$cuenta."' and a.codinttom=b.codinttom And b.codemi='".$emision."' and b.SubAcu='".$acueducto."'
      and a.CodCic='".$ciclo."' and trim(b.RutMed) between '".$desderuta."' and '".$hastaruta."' and b.coduso between
		  '".$desuso."' and '".$hasuso."'";
        	echo 'Consulta'.$sql;
			$result = pg_query($bd_conexion,$sql);
   		if (pg_num_rows($result)>0){      
			return "1";
		}
}


	return "0";
	
}

//TRAE LAS CUENTAS MINIMAS Y MAXIMAS
function cuenta_minima_maxima($acueducto,$ciclo,$emision,$tipo,$desderuta,$hastaruta,$desuso,$hasuso)
{
	
	GLOBAL $bd_conexion;
	if ($ciclo=="")
	{
		$sql = "Select min(a.NumCta) as minima,max(a.NumCta) as maxima from MaeRegTom a,FacRegFactmp b
        		where a.codinttom=b.codinttom And b.codemi='".$emision."' and b.SubAcu='".$acueducto."'
        		 and trim(b.RutMed) between '".$desderuta."' and '".$hastaruta."' and b.coduso between
				  '".$desuso."' and '".$hasuso."' 
        		 " ;
		$result = pg_query($bd_conexion,$sql);
   		if (pg_num_rows($result)>0)
		{      
			$cuentamin = pg_result($result,0,"minima");
			$cuentamax = pg_result($result,0,"maxima");
		}
		
	}

	Else
	{
		$sql = "Select min(a.NumCta) as minima,max(a.NumCta) as maxima from MaeRegTom a,FacRegFactmp b
        		where a.codinttom=b.codinttom And b.codemi='".$emision."' and a.CodCic='".$ciclo."' 
        		and a.SubAcu='".$acueducto."' and trim(b.RutMed) between '".$desderuta."' 
        		and '".$hastaruta."' and b.coduso between  '".$desuso."' and '".$hasuso."' 
        		 ";
		$result = pg_query($bd_conexion,$sql);
   		if (pg_num_rows($result)>0)
		{      
			$cuentamin = pg_result($result,0,"minima");
			$cuentamax = pg_result($result,0,"maxima");
		}
	}

	if ($tipo == "max") return $cuentamax;
	if ($tipo == "min") return $cuentamin;

}
/***********FUNCI”N QUE COLOCA EL ESTATUS EN PENDIENTE ****************/
function calcular_facturacion($ciclo,$acueducto,$emision,$desderuta,$hastaruta,$desuso,$hasuso,$numctades,$numctahas,$rut_pla)
{
	GLOBAL $bd_conexion;
	if ($ciclo=="")
	{
		$sql = "SELECT 
					COUNT(reffac) as numfac 
				FROM 
					facregfactmp a 
				INNER JOIN 
					maeregtom b ON a.codinttom = b.codinttom 
				WHERE 
					a.subacu = '".$acueducto."' AND 
					a.codemi = '".$emision."' and 
					a.codcic BETWEEN '000' AND '999' AND
					a.rutmed BETWEEN '".$desderuta."' AND '".$hastaruta."' AND 
					a.coduso BETWEEN '".$desuso."' AND '".$hasuso."' AND 
					b.numcta BETWEEN '".$numctades."' AND '".$numctahas."'";
	}
	else
	{
		$sql = "SELECT 
					COUNT(reffac) as numfac 
				FROM 
					facregfactmp a 
				INNER JOIN 
					maeregtom b ON a.codinttom = b.codinttom 
				WHERE 
					a.subacu = '".$acueducto."' AND a.codemi = '".$emision."' and 
					a.codcic ='".$ciclo."' AND
					a.rutmed BETWEEN '".$desderuta."' AND '".$hastaruta."' AND 
					a.coduso BETWEEN '".$desuso."' AND '".$hasuso."' AND 
					b.numcta BETWEEN '".$numctades."' AND '".$numctahas."'";
	}
	
	$result= pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{
		$numfact = pg_result($result,0,"numfac");
		if ($numfact==0)
		{
			cuadro_mensaje2("No Existen Facturas para los Criterios de Busqueda. Por favor verifique sus datos...");
			return 0;
		}
		else
		{
			$sql = "SELECT 
						nomusu, 
						TO_CHAR(fecpro, 'dd/mm/yyyy') AS fecpro 
					FROM 
						facproasi a 
					INNER JOIN 
						pardefusu b ON a.codintusu = b.codintusu 
					WHERE 
						codemi = '".$emision."' AND 
						status = '0' AND 
						codpro = 'CALFAC' AND 
						subacu = '".$acueducto."' AND 
						codcicini = '".$ciclo."' AND 
						codrutdes = '".$desderuta."' AND 
						codruthas = '".$hastaruta."' AND  
						codusodes = '".$desuso."' AND 
						codusohas = '".$hasuso."' AND 
						numctades = '".$numctades."' AND 
						numctahas = '".$numctahas."'";
			$result = pg_query($bd_conexion,$sql);
			if (pg_num_rows($result)>0)
			{
				$nombre = pg_result($result,0,"nomusu");
				$fecha = pg_result($result,0,"fecpro");
				cuadro_mensaje2("Existe una Solicitud PENDIENTE para los mismos parametros, realizada por: $nombre en fecha: $fecha Por favor Verifique...");
				return 0;
			}
			else
			{
				$codemiant = emision_anterior($emision); // actualizado por douglas 22.10.2012 para el calculo de consumo emision anterior
				$sql = "INSERT INTO facproasi(
							codpro,
							fecpro,
							status,
							subacu,
							codemi,
							codofi,
							codintusu,
							codemiant,
							codcicini,
							codrutdes,
							codruthas,
							codusodes,
							codusohas,
							numctades,
							numctahas,tipo_ruta) 
						VALUES (
							'CALFAC',
							current_date,
							'0',
							'".$acueducto."',
							'".$emision."',
							'".$_SESSION["codofi"]."',
							'".$_SESSION["codintusu"]."',
							'".$codemiant."',
							'".$ciclo."',
							'".$desderuta."',
							'".$hastaruta."',
							'".$desuso."',
							'".$hasuso."',
							'".$numctades."',
							'".$numctahas."',
							'".$rut_pla."')";			
				$result = pg_query($bd_conexion,$sql);
				if($result>0)
					cuadro_mensaje2("La Solicitud de Calculo de Facturas se ha enviado exitosamente");
				else
					cuadro_mensaje2("Error en la Solicitud de Calculo de Facturas, no se ha enviado exitosamente");				
				return 1;
			}
		}
	}
}
	
	/*FunciÛn CompararFechas: Compara dos fechas.
Parametros:
Fecha1: Fecha a comparar
Fecha2: Fecha a comparar

Retorna:
	Si F1 > F2 = Valor positivo
	Si F1 = F2 = 0
	Si F1 < F2 = Valor negativo

Formatos de Fecha Admitidos:
	-- 2007-07-07, 07-07-07
	-- 07-07-2007, 07-07-07
	-- 07/07/2007, 07/07/07
*/
function compararfechas($fecha1, $fecha2)
{
	//Compara la fecha con los formatos disponibles
	if (preg_match("/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/", $fecha1))
		list($ano1,$mes1,$dia1)=split("-",$fecha1);
	//echo $fecha1.'----'.$fecha2;
	if (preg_match("/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/", $fecha2))
		list($ano2,$mes2,$dia2)=split("-",$fecha2);

	$dif = mktime(0, 0, 0, $mes1, $dia1, $ano1) - mktime(0, 0, 0, $mes2, $dia2, $ano2);
	//echo $dif;
	return ($dif);
}
	
function valor_promedio($codigo)
{
GLOBAL $bd_conexion;

	$promedio=0;
	$sql = "Select Protom From MaeRegTom Where CodIntTom='".$codigo."'";
	
	$result = pg_query($bd_conexion,$sql);


		if (pg_num_rows($result)>0){      
				$promedio = pg_result($result,0,"ProTom");
		}
		
	return $promedio;
	
}

function valor_minimo_normal($codigouso, $acueducto, $emision,$tipo){
	
	GLOBAL $bd_conexion;
	$minimo=0;
	$normal=0;
	$sql = "Select ValMin,Normal From Pardefmin where coduso='".$codigouso."'
      and acue='".$acueducto."' and emision='".$emision."'";
	
	$result = pg_query($bd_conexion,$sql);

		if (pg_num_rows($result)>0){      
				$minimo = pg_result($result,0,"ValMin");
				$normal = pg_result($result,0,"Normal");
			
		}
	if ($tipo==0){
	return $minimo;
	}
	else return $normal;
}



/**FUNCION UTILIZADA POR EL PROCESO DE ADICIONAL Y AJUSTE *IMPORTANTE**/
function emision_facturada($mCodEmision,$CodigoToma,&$Pregunta,&$GeneraCredito,&$RefFacOri,&$Fact_Ajustar)
{
	GLOBAL $bd_conexion;
	$Fact_Ajustar="";
	

$sql = "Select * From FacRegFac 
       Where CodIntTom = '".$CodigoToma."' and CodEmi ='".$mCodEmision."' Order by fecemi desc";

$result = pg_query($bd_conexion,$sql);

		if (pg_num_rows($result)>0)
		{		  
			$Fact_Ajustar = pg_result($result,0,"reffac");
			$estatus = pg_result($result,0,"estfac");
			$monto = pg_result($result,0,"monpag");
			$referencia = pg_result($result,0,"reffac");
			if (($estatus=="0") || ($estatus=="4"))
			{						
				$Pregunta = "1";
        		$GeneraCredito = $monto;
        		$RefFacOri = $referencia;
			}
			else
			{				
				$Pregunta = "0";
   				$GeneraCredito = "0";
   				$RefFacOri = "";
			}			
			return "1";
		}
		else
		{			
			$Pregunta = "0";
    		return "0";
		}	
}

function validar_emisiones($desde,$hasta){

$dia_inicio = "01";
$mes_inicio = substr($desde,0,2);
$ano_inicio = substr($desde,2,4);
$fecha1=mktime(0,0,0,($mes_inicio-1),$dia_inicio,$ano_inicio);

$dia_fin ="01";
$mes_fin=substr($hasta,0,2);
$ano_fin = substr($hasta,2,4);

$fecha2 = mktime(0,0,0,($mes_fin-1),$dia_fin,$ano_fin);
	

$dias= ((($fecha2-$fecha1)/60/60)/24);

return $dias;
}

function validar_precios($acueducto,$emision,$coduso){
	GLOBAL $bd_conexion;
	$bandera = "0";
	$sql = "Select * From FacPreRef Where CodSubAcu = '".$acueducto."' and emision = '".$emision."' 
	 and coduso = '".$coduso."'";
	
	$result = pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0){ 
		$bandera = "1";
	}
	return $bandera;
}

function actualizar_reffac($campo, $codofi){
GLOBAL $bd_conexion;


$sql = "Select * from FacRefFac where OfiCom='".$codofi."'";
$result = pg_query($bd_conexion,$sql);

 if (pg_num_rows($result)>0){
	$result2=pg_query($bd_conexion,"update facreffac set reffac='".$campo."' where oficom='".$codofi."'");
	return "1";
}
else{
	
	$result2=pg_query($bd_conexion,"insert into facreffac (reffac, OfiCom) values ('".$campo."','".$codofi."')");
	return "1";
}
return "0";
}


function Generar_RecargoPorServicio($ReferenciaFactura, $servicios,$codigouso, $Monto, $MontoTotalRecargo){
	GLOBAL $bd_conexion;
	
	$sql = "SELECT * FROM FacTipRec WHERE CodSer = '".$servicios."' And  
          CodUso='".$codigouso."' and TemRec='E' AND ACTIVO='S'";

	$result = pg_query($bd_conexion,$sql);
	
	
	 if (pg_num_rows($result)>0){
	  while ($registro=pg_fetch_assoc($result)){
	 	$TipRec = pg_result($result,0,"tiprec");
	 	$ValRec = pg_result($result,0,"valrec");
	 	$CodRec = pg_result($result,0,"codrec");
			switch ($TipRec){
				case "P":{
										
					 $MontoRecargo = ($Monto * $ValRec) / 100;
					
					 break;
					
				}
				case "M":{
					$MontoRecargo = $ValRec;
					break;
					
				}
			}
			if ($MontoRecargo > 0){
        		 $sql = "Select * From FacRecFac Where RefFac='".$ReferenciaFactura."'
              	 And CodTip='".$CodRec."'";
        		$result = pg_query($bd_conexion,$sql);
        		 
        		 if (pg_num_rows($result)>0){
        		 	$sql = "Update FacRecFac set MonRec=(monrec + '".$MontoRecargo."') where RefFac='".$ReferenciaFactura."'
                 		And CodTip='".$CodRec."'";
        		 }else{
        		 	$sql = "Insert into FacRecFac (RefFac,codtip,MonRec) values ('".$ReferenciaFactura."',
        		 	'".$CodRec."','".$MontoRecargo."')";
        		 }
        		 $result = pg_query($bd_conexion,$sql);
        		 $MontoTotalRecargo = $MontoTotalRecargo + $MontoRecargo;
			}
	 		
		}
	 	
	 }

	
	
	return $MontoTotalRecargo;
}




function procesar_clientes($numcta,$codofi,$codintusu,$desde,$Fact_Ajuste,$servicios,$Consumo,$GeneraCredito,$RefFacOri){

GLOBAL $bd_conexion;
$fecha=date("Y/m/d");


pg_query($bd_conexion,"BEGIN WORK");

$CodigoUsoTar = "";
$BsAguaMar = 0;
$BsAguaCamion = 0;
$TotalRecargos010 = 0;
$TotalRecargos005 = 0;
$Can_Metros = 0;




$sql = "Select * From MaeRegTom Where NumCta ='".$numcta."'";
$result = pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0){ 
		$codigopersona = pg_result($result,0,"codintper");
		$codigotoma = pg_result($result,0,"codinttom");
		$Dotacion =  pg_result($result,0,"dottom");
		$numhab = pg_result($result,0,"NumHab");
		$codigoinmueble = pg_result($result,0,"CodIntInm");
		$codigotoma = pg_result($result,0,"codinttom");
		$codigoempresa = pg_result($result,0,"codemp");
		$zonaop = pg_result($result,0,"ZonOpe");
		$sistemacom = pg_result($result,0,"SisCom");
		$acueducto = pg_result($result,0,"SubAcu");
		$ciclo = pg_result($result,0,"codcic");
		$rutamedicion = pg_result($result,0,"rutmed");
		$codigouso = pg_result($result,0,"codusotar");				
		$consumo2 = pg_result($result,0,"consumo2");
		$consumo1 = pg_result($result,0,"consumo1");
		$consumobase = pg_result($result,0,"consumobase");
	}

$sql = "Select * from ParDefMin where CodUso='".$codigouso."' and EMISION='".$desde."' and acue='".$acueducto."'";
$result = pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0){ 
	$Cons_Minimo =pg_result($result,0,"ValMin"); 
    $Cons_Dotacion = pg_result($result,0,"ExeDot");  
    $Porc_Dotacion = pg_result($result,0,"PorDot");
	}
	
$sql = "Select * from ParFactor where CodUso='".$codigouso."' and EMISION='".$desde."' and acue='".$acueducto."'";
$result = pg_query($bd_conexion,$sql);
if (pg_num_rows($result)>0){ 
	$Factor1 =pg_result($result,0,"ValFF");
    $Factor2 = pg_result($result,0,"ValFN");
    $Factor3 = pg_result($result,0,"ValEXE1");
    $Factor4 = pg_result($result,0,"ValEXE2"); 
    $RanFF1 =  pg_result($result,0,"RanFF1");
    $RanFF2 =  pg_result($result,0,"RanFF2");
    $RanFN1 = pg_result($result,0,"RanFN1"); 
    $RanFN2 = pg_result($result,0,"RanFN2"); 
    $RanEX11 = pg_result($result,0,"RanEX11"); 
    $RanEX12 = pg_result($result,0,"RanEX12"); 
    $RanEX21 = pg_result($result,0,"RanEX21"); 
    $RanEX22 = pg_result($result,0,"RanEX22"); 
    $Tipo_Calculo = pg_result($result,0,"Tipo_Calculo"); 
    $PorDotEx1 = pg_result($result,0,"PorDotEx1");  
    $PorDotEx2 = pg_result($result,0,"PorDotEx2");
	}



	if ($numhab < 1){
		 $numhab = 1;
	}
	
	$referencia_factura = correl_reffac($codofi);
	
	if ($Fact_Ajuste != ""){
		$XTipfac = "J";  //AJUSTE
	}else{
		$XTipfac = "D"; //ADICIONAL
	}

	//echo "$Fact_Ajuste - $desde  - $codigouso - $acueducto - $numcta - $codofi - $codintusu - $consumo";
	pg_query($bd_conexion,"Insert into facregfac(RefFac,orifac,tipfac,CodIntPer,CodIntInm,CodIntTom,CodIntEmp,codemi,fecemi,FecVen,EstFac,codemp,ZonOpe,SisCom,OfiCom,SubAcu,CodCic,RutMed,CodUso) 
        values ('".$referencia_factura."','A','".$XTipfac."','".$codigopersona."',
        '".$codigoinmueble."','".$codigotoma."','".$codintusu."', 
        '".$desde."',current_date,'".$fecha."','0','".$codigoempresa."',
        '".$zonaop."', '".$sistemacom."', '".$codofi."','".$acueducto."',
        '".$ciclo."','".$rutamedicion."','".$codigouso."' )");
	
	
	
	if ($referencia_factura!=""){
		$MontoFactura = 0;
        $MontoRecargo = 0;
        $cantidad = 0;
        $MontoDescuento = 0;
        $BsAgua = 0;
        $BsCargoFijo = 0;
        $BsExceso = 0;
	
        //ELIMINAR SERVICIOS DE LA FACTURA
          $sql = "Delete from FacSerFac Where RefFac = '".$referencia_factura."'";
	 	  pg_query($bd_conexion,$sql);
		
	 	//ELIMINAR RECARGOS DE LA FACTURA
		 $sql = "Delete from FacRecFac Where RefFac = '".$referencia_factura."'";
		   pg_query($bd_conexion,$sql);
		   
		 //ELIMINAR DESCUENTOS DE LA FACTURA
		  $sql = "Delete from FacDesFac Where RefFac = '".$referencia_factura."'";
		   pg_query($bd_conexion,$sql);
		   
		$i=0;
		
		//SERVICIOS QUE ESTAN CHECKEADOS
	while ($i <= count ($servicios)-1){
			$MontoServicio = 0;
			$Cantidad = $Consumo;
			$Precio = 0;
  			
		
		$sql = "Select  est_con,codser,desser from ParServic p where temser='E' and sta_act='1' and codser='".$servicios[$i]."'";   		
    		 $result = pg_query($bd_conexion,$sql);
    		 if (pg_num_rows($result)>0){
    		 	$Est_Con= pg_result($result,0,"est_con");
    		 	
    		 }

     $sql = "Select * From FacPreRef Where CodSubAcu = '".$acueducto."' and emision = '".$desde."' and 
       codser = '".$servicios[$i]."' and coduso = '".$codigouso."'";
		$result = pg_query($bd_conexion,$sql);
    		 if (pg_num_rows($result)>0){
    		 	$Precio= pg_result($result,0,"preref");
    		 	
    		 }
    		 
      switch ($servicios[$i]) {
      	//Calculo de Servicio de Agua
    	case '001':
    		$ConsumoOri = $Consumo;
    		
    		$Consumo = ($Consumo/$numhab);
    		
    		if ($Consumo<$Cons_Minimo){
    			$Consumo = $Cons_Minimo;
    			
    		}
    		
    		if ($Tipo_Calculo > 1){
    			
    		if ($Dotacion == 0){
      			 $Dotacion = $Cons_Dotacion;
      			
    		}
    			if ($Consumo < $Dotacion){
    				
      			 $BsAgua = $Consumo * $Factor1 * $Precio;
      			
    			}else{
       				$BsAgua = $Dotacion * $Factor1 * $Precio;
       				
    			}
  			  if ($Consumo > $Dotacion){
      			 $CANTIDADAGUA = $Dotacion;
  			  }
    		else{
      			 $CANTIDADAGUA = $Consumo;
      			
    		}
    		}else{
    			switch ($Consumo){
    				 case (($Consumo >= $RanFF1)&&($Consumo <= $RanFF2)):
    				 	$BsAgua = $Consumo * $Factor1 * $Precio;
    				 	
    				 	 case (($Consumo >= $RanFN1)&&($Consumo <= $RanFN2)):
        					 $TarSoc15 = $RanFF2 * $Factor1 * $Precio;
         					 $BsAgua = $TarSoc15 + (($Consumo - $RanFF2) * $Factor2 * $Precio);
     					 case (($Consumo >= $RanEX11)&&($Consumo<=$RanEX12)):
         					$TarSoc15 = $RanFF2 * $Factor1 * $Precio;
         					$TarSoc40 = $TarSoc15 + (($RanFN2 - $RanFF2) * $Factor2 * $Precio);
         					$BsAgua = $TarSoc40 + (($Consumo - $RanFN2) * $Factor3 * $Precio);
      					case ($Consumo>$RanEX12):
         					$TarSoc15 = $RanFF2 * $Factor1 * $Precio;
         					$TarSoc40 = $TarSoc15 + (($RanFN2 - $RanFF2) * $Factor2 * $Precio);
         					$TarSoc100 = $TarSoc40 + (($RanEX12 - $RanFN2) * $Factor3 * $Precio);
         					$BsAgua = $TarSoc100 + (($Consumo - $RanEX12) * $Factor4 * $Precio);
       			}
    			 $BsAgua = $BsAgua * $numhab;
    			
    			 $Consumo = $ConsumoOri;
    			 $CANTIDADAGUA = $Consumo;
    		}
    		$MontoServicio = $BsAgua;
    		$Cantidad = $CANTIDADAGUA;
    		
    		
		  echo"<br />$servicios[$i] Este es el servicio de Agua potable $MontoServicio <br />";
			
     	   break;
     	   
     	   //Calculo de Servicio de Aguada Maritima
    	case '013':
    		$BsAguaMar = $Precio * 10 * $Consumo;
    		$MontoServicio = $BsAguaMar;
    	   echo"013 Este es el servicio de AguadaMaritima $MontoServicio <br />";
     	   break;
        
     	   //Calculo de Exceso
     	 case '010':
        	
        	if ($Tipo_Calculo > 1){
        		
   				 if ($Dotacion == 0){
   				 	 $Dotacion = $Cons_Dotacion;
   				 }
    			if ($Consumo < $Dotacion) {
       			 $BsExceso = 0;
       			 $CANTIDADEXCESO = 0;
       			
    			}
    			else{
    				$emision_aux = substr($desde,2,4).substr($desde,0,2);
    				
       				 if (($emision_aux <= "201002") || ($Tipo_Calculo == 3)){
         			   $BsExceso = ($Consumo - $Dotacion) * $Factor3 * $Precio;
          			  $CANTIDADEXCESO = $Consumo - $Dotacion;
          			  
       				 }else{
          				  if ($Consumo <= ($PorDotEx1 * $Dotacion)) {
            	   			 $BsExceso = ($Consumo - $Dotacion) * $Factor3 * $Precio;
               			 	$CANTIDADEXCESO = $Consumo - $Dotacion;
            			}else{
               				 $BsExceso = (($PorDotEx1 * $Dotacion) - $Dotacion) * $Factor3 * $Precio;
                			 $CANTIDADEXCESO = ($PorDotEx1 * $Dotacion) - $Dotacion;
            }
        }
    }
  }
        $Cantidad = $CANTIDADEXCESO;
         $MontoServicio = $BsExceso;
    	   echo"$servicios[$i] Este es el servicio de Exceso  $MontoServicio <br /> ";
     	   break;
     	   
     	   //Calculo de 2do. Exceso
       case '028':{
       	$emision_aux = substr($desde,2,4).substr($desde,0,2);
       		
       		if ($emision_aux>"201002"){
       			$Cantidad = $Consumo;
       			if ($Tipo_Calculo == 2){
   				 if ($Dotacion ==0){
       				 $Dotacion = $Cons_Dotacion;
       			}
    		if ($Consumo <= ($PorDotEx1 * $Dotacion)){
        		$BsExceso = 0;
       			$CANTIDADEXCESO = 0;
    		}
   			else{
        		$BsExceso = ($Consumo - ($PorDotEx1 * $Dotacion)) * $Factor4 * $Precio;
        		$CANTIDADEXCESO = $Consumo - ($PorDotEx1 * $Dotacion);
    		}

       		}
       	}
         $Cantidad = $CANTIDADEXCESO;
         $MontoServicio = $BsExceso;
       	   echo" $servicios[$i] Este es el de 2do exceso  $MontoServicio <br />";
     	   break;
       }  
     	  //Calculo de Cargo Fijo
       case '005':{
       	if ($Tipo_Calculo > 1){
    		if ($Dotacion == 0){
     		  $Dotacion = $Cons_Dotacion;
       	}
   		 
       	$CantidadFijo = $Porc_Dotacion * $Dotacion;
   		 
   	 	if ($CantidadFijo < ($Cons_Dotacion * $Porc_Dotacion)){
      			 $CantidadFijo = $Cons_Dotacion * $Porc_Dotacion;
   				 }
   			$CantidadFijo = Round($CantidadFijo);
   			$BsCargoFijo = $CantidadFijo * $Factor1 * $Precio;
       	}  
       	$Cantidad = $CantidadFijo;
        $MontoServicio = $BsCargoFijo;
   			 
   		echo"005 Este es el cargo fijo $MontoServicio <br /> ";
     	   break;
       }
             	         
      //Calculo de Caudal Contratado 
       case '004':{
       	$Cantidad = $consumobase;
        
       	$sql = "Select * From FacPreRef Where CodSubAcu= '".$acueducto."' and emision='".$desde."' and Coduso='".$codigouso."' and CodSer='".$servicios[$i]."'";
      	$result = pg_query($bd_conexion,$sql);
    		 if (pg_num_rows($result)>0){
    		 	$Registro= pg_result($result,0,"TIPPRE");
				$precio_ref = pg_result($result,0,"PreRef");
					
    		 		if($Registro =="P"){
    		 			 $BsOtroServicio = $Cantidad*($precio_ref/100);
    		 			
       				
    		 		}
    		 		else{
    		 			$BsOtroServicio = $Cantidad * $precio_ref;
    		 			
    		 		}
    		 }else{
    		 	$BsOtroServicio = 0;
    		 }
       		$MontoServicio = $BsOtroServicio;
       	   
    	   echo"$servicios[$i] CAUDAL CONTRATADO $MontoServicio <br /> ";
     	   break;
       }
       
       //Calculo de Caudal Emergencia Programado
       case '006':
      {
       	$Cantidad = $consumo1;
       	$sql = "Select * From FacPreRef Where CodSubAcu= '".$acueducto."' and emision='".$desde."' and Coduso='".$codigouso."' and CodSer='".$servicios[$i]."'";
      	$result = pg_query($bd_conexion,$sql);
    		 if (pg_num_rows($result)>0){
    		 	$Registro= pg_result($result,0,"TIPPRE");
				$precio_ref = pg_result($result,0,"PreRef");
    		 		if($Registro =="P"){
    		 			 $BsOtroServicio =  $Cantidad*($precio_ref/100);
    		 			
    		 		}
    		 		else{
    		 			$BsOtroServicio =  $Cantidad* $precio_ref;
    		 			
    		 		}
    		 }else{
    		 	$BsOtroServicio = 0;
    		 }
       		$MontoServicio = $BsOtroServicio;
       	   
    	   echo"$servicios[$i] CAudal Emergente Programado $MontoServicio <br />";
     	   break;
       }
       
       //Calculo de Caudal Emergencia Imprevisto
       case '007':{
        	$Cantidad = $consumo2;
       	$sql = "Select * From FacPreRef Where CodSubAcu= '".$acueducto."' and emision='".$desde."' and Coduso='".$codigouso."' and CodSer='".$servicios[$i]."'";
      	$result = pg_query($bd_conexion,$sql);
    		 if (pg_num_rows($result)>0){
    		 	$Registro= pg_result($result,0,"TIPPRE");
				$precio_ref = pg_result($result,0,"PreRef");
    		 		if($Registro =="P"){
    		 			 $BsOtroServicio =  $Cantidad*($precio_ref/100);
    		 			
    		 		}
    		 		else{
    		 			$BsOtroServicio =  $Cantidad * $precio_ref;
    		 			
    		 		}
    		 }else{
    		 	$BsOtroServicio = 0;
    		 }
       		$MontoServicio = $BsOtroServicio;
       	   
    	   echo"$servicios[$i] CAUDAL EMERGENTE IMPREVISTO $MontoServicio <br />";
     	   break;
       }
       
       	//CALCULO DE OTROS SERVICIOS       
       default:{
       	$Cantidad = 1;
       	$sql = "Select * From FacPreRef Where CodSubAcu= '".$acueducto."' and emision='".$desde."' and Coduso='".$codigouso."' and CodSer='".$servicios[$i]."'";
      	$result = pg_query($bd_conexion,$sql);
    		 if (pg_num_rows($result)>0){
    		 	$Registro= pg_result($result,0,"TIPPRE");
				$precio_ref = pg_result($result,0,"preref");
    		 		if($Registro =="P"){
    		 			 $BsOtroServicio =  $MontoFactura*($precio_ref/100);
    		 			   		 			
    		 		}
    		 		else{
    		 			$BsOtroServicio =  $MontoFactura*$precio_ref;
    		 			
    		 		}
    		 }else{
    		 	$BsOtroServicio = 0;
    		 }
       		$MontoServicio = $BsOtroServicio;
       	   
    	   echo"$servicios[$i] OTRO Servicio $MontoServicio <br />";
     	   break;
      	 }
     	   
		}
		
		$MontoFactura = $MontoFactura + $MontoServicio;
		 if ($Est_Con == "1"){
              $Can_Metros = $Can_Metros + $Cantidad;
              
		 }
		$servicio = $servicios[$i];
		 if ($MontoServicio > 0){
		 
                    $sql = "Insert into facserfac (RefFac,CodSer,CanFac,PreRef,MonFac) 
                    values ('".$referencia_factura."','".$servicio."','".$Cantidad."',
                    '".$Precio."','".$MontoServicio."')";
           
                    pg_query($bd_conexion,$sql);
         } 
         
		 
		 //Generar Recargos 
		 $servicio = $servicios[$i];
		$MontoRecargo =  Generar_RecargoPorServicio($referencia_factura,$servicio,$codigouso, $MontoServicio, $MontoRecargo);

	
		$i++;	
		}
		
		
		
	}
	
	echo "Monto a FActurar-------> $MontoFactura  <br />";
	echo("MONTO RECARGO -> $MontoRecargo <br />");
	echo("MONTO DESCUENTO -> $MontoDescuento <br />");
	$MontoTotal = $MontoFactura + $MontoRecargo - $MontoDescuento;
	
	echo("MONTO TOTAL-> $MontoTotal");
	
	
	
	
	//Actualiza el encabezado de la factura

	 $sql = "Update FacRegFac set MonFac='".$MontoFactura."',MonRec='".$MontoRecargo."',
	 MonDes='".$MontoDescuento."',metfac='".$Can_Metros."' Where RefFac= '".$referencia_factura."'";
		pg_query($bd_conexion,$sql);
	
	//Verifica si el proceso genera crÈdito
	if ($GeneraCredito > 0){
            $sql = "Update MaeRegTom set MonCre = MonCre + '".$GeneraCredito."' Where CodIntTom = '".$codigotoma."'";
           		pg_query($bd_conexion,$sql);
            $sql = "Insert into RecCreTom (codinttom,moncre,feccre,tipcre,refpag) values ('".$codigotoma."','".$GeneraCredito."',current_date,'A','".$RefFacOri."')";
				pg_query($bd_conexion,$sql);
	}
	
	
	//Para confirmar registro de datos --
	
	
	
	$aja = actualizar_reffac($referencia_factura,$codofi);
	
	
	
	if ($aja=="1"){
			
		if ($Fact_Ajuste != ""){
			
				$sql = "update facregfac set estfac = '9', fecpag = current_date where reffac = '".$Fact_Ajuste."'";
                    pg_query($bd_conexion,$sql);
			}
		$sql = "select promediodetoma('".$codigotoma."')";
                pg_query($bd_conexion,$sql);
        	
             pg_query($bd_conexion,"COMMIT");
        	return "1";
	}else{	
		pg_query($bd_conexion,"ROLLBACK");
		return "0";
	
	}
	
	
}




//CODIGO DE MICHAEL
function correl_reffac1($codofi){
	GLOBAL $bd_conexion;
	$result=pg_query($bd_conexion,"select max(substr(refcon,4,17)) as reffac from cdpconpag where codofi='".$codofi."'");
	if (pg_num_rows($result)>0){
		$reffac=intval(pg_result($result,0,"reffac"))+1;
		while (strlen($reffac)<17){
			$reffac='0'.$reffac;
		}
		return $codofi.$reffac;
	} else
	{
		return $codofi."0000000000001";
	}
}

function Grabar_Convenio($op,$codigo,$arc_codintinm,$arc_codintper,$arc_codinttom,$arc_fecharec,$codofi,$arc_moncon,$arc_numcuo,$arc_monini,$arc_ref)
{
	GLOBAL $bd_conexion;
	if ($op== "Anular")
	{
    	$sql = "Update CdpConPag set CodIntInm='".$arc_codintinm."',CodIntSus='".$arc_codintper.
        	  	"',CodIntTom='".$arc_codinttom."',FecCon=to_date('".$arc_fecharec."','DD/MM/YYYY'),".
         		"tipcon='002',CodOfi='".$codofi."',MonCon=".$arc_moncon.
				",numcuo=".$arc_numcuo.",MonIni=".$arc_monini.",CodIntEmp='".$codigo."',EstCon='V' Where RefCon='".$arc_ref."';";
	}
	else
	{
   		$sql = "Insert Into CdpConPag (RefCon,CodIntInm,CodIntSus,CodIntTom,FecCon,tipcon,CodOfi,MonCon,numcuo,".
				"MonIni,CodIntEmp,EstCon) values('".$arc_ref."','".$arc_codintinm."','".$arc_codintper.
         		"','".$arc_codinttom."',to_date('".$arc_fecharec."','DD/MM/YYYY'),'002','".$codofi.
         		"',".$arc_moncon.",".$arc_numcuo.",".$arc_monini.",'".$codigo."','V');";
	}

	$result = pg_query($bd_conexion,$sql);
	if (pg_affected_rows($result)>0)
	{
		return "1";
	}
	else
	{
		return "0";
	}
}

function Grabar_GridConvenio($codigo,$arc_codintinm,$arc_codintper,$arc_codinttom,$arc_fecharec,$codofi,$arc_moncon,$arc_numcuo,$arc_monini,$arc_ref,$datosdeuda,$datospago,$datosamort,$CodigoSubAcu)
{
    GLOBAL $bd_conexion;
    $valretor="-1";
	for($i = 0;$i<=count($datosdeuda);$i++)
	{
   		if ($datosdeuda[$i][0]!= "")
   		{
       		$sql = "Insert Into CdpDeuCon (RefCon,RefFac) values ('".$arc_ref."','".$datosdeuda[$i][1]."');";
			$result = pg_query($bd_conexion,$sql);
			if (pg_affected_rows($result)<=0)
			{
				return "-1";
			}

			$sql = "Update FacRegFac set Refpag='".$arc_ref."',FecPag=to_date('".$arc_fecharec.
            		"','DD/MM/YYYY'), EstFac='7' where RefFac = '".$datosdeuda[$i][1]."';";
        	$result = pg_query($bd_conexion,$sql);
   			if (pg_affected_rows($result)<=0)
			{
				return "-1";
			}
   		}
	}

	for($i=0;$i<count($datospago);$i++)
	{
    	$ReferenciaFactura=correl_refcon($codofi);
    	if ($datospago[$i][5]!=" ")
    	{
       		$fecha = $datospago[$i][5];
    	}
    	else
    	{
        	$fecha ="01/01/1900";
    	}    
    	$FechaVencimiento = $datospago[$i][1];
    	$MontoCuota = $datosamort[$i][1];
    	$MontoRec = $datosamort[$i][2];
    	$MetCub =(float)$datospago[$i][8];
    	if ($datospago[$i][0]== "0001")
    	{ // // ES LA INICIAL
       		$MontoInt = 0;
       		$MontoIvaInt = 0;
       		for($j=0;$j<count($datosamort);$j++)
       		{
           		$MontoInt = $MontoInt + $datosamort[$j][3];
           		$MontoIvaInt = $MontoIvaInt + $datosamort[$i][4];
       		}
    	}	
    	else
    	{
       		$MontoIvaInt = 0;
       		$MontoInt = 0;
    	}
    	
    	if (En_Facturacion($arc_ref,$arc_codintinm, $arc_codintper,$arc_codinttom, $arc_fecharec, $FechaVencimiento,$codofi,
			$CodigoSubAcu, 2, 0, ($MontoCuota + $MontoInt), ($MontoRec + $MontoIvaInt),$ReferenciaFactura, "CVN_PG",
			$datospago[$i][0], $codigo)=="1")
		{
			if (En_ServiciosFacturacion($ReferenciaFactura, "001", $MetCub, $MontoCuota, $MontoCuota)=="1")
			{
            	if ($MontoRec > 0)
            	{
               		$sql = "Insert into FacRecFac (RefFac,codtip,MonREC,MonAju,MonPag) values('".$ReferenciaFactura.
                     		"','002',".$MontoRec.",0,0);";
            	}
            	if ($MontoInt > 0)
            	{
            		if(En_ServiciosFacturacion($ReferenciaFactura, "002", "1", $MontoInt, $MontoInt)!="1")
               		{
               			return "-1";
               		}
            	}
               	            
               	if (Act_FacRefFac($ReferenciaFactura, "RefCon", $codofi)=="1")
               	{
                	$sql = "Insert Into CdpDetCon (RefCon,numcuo,FecVen,MonCuo,MonRec,MonDes,MonPag,FecPag,EstCuo,RefFac,".
                    	  	"MonInt,MonIvaInt) values ('".$arc_ref."','".$datospago[$i][0]."',to_date('".
                      		$datospago[$i][1]."','DD/MM/YYYY'),".$datosamort[$i][1].",".
                      		$datosamort[$i][2].",0,".$datospago[$i][4].",to_date('".
                      		$fecha."','DD/MM/YYYY'),'V','" .$ReferenciaFactura."',".$datosamort[$i][3].
                      		",".$datosamort[$i][4].");";
                	pg_query($bd_conexion,$sql);
				}
				else
				{
					return "-1";
            	}
        	}
        	else
        	{
        		return "-1";
        	}
		}
		else
		{
			return "-1";
    	}
	}
	return "1";
}

function Grabar_CuotasXFacturas($arc_ref,$datosdeuda,$datospago){
    GLOBAL $bd_conexion;
    for($i = 0;$i<count($datospago);$i++){
        switch ($datospago[$i][2]) {
            case "INICIAL":
                $Letra = "I";
                break;
            default:
                $Letra=substr($datospago[$i][2],11);               
                break;
        }
        for($x=0;$x<count($datosdeuda);$x++){
            if($Letra==$datosdeuda[$x][0]){
                $sql = "Insert Into CdpCuoFac (RefCon,numcuo,RefFac) values ('".$arc_ref.
                 "','".$datospago[$i][0]."','".$datosdeuda[$x][1]."');";
                pg_query($bd_conexion,$sql);
            }
        }
    }
    return "1";
}

function anularConvenio($arc_ref){
    GLOBAL $bd_conexion;
    pg_query($bd_conexion,"begin;");
   /*'---------------------------------------
   '-- Cambiamos el Estatus del Convenio --
   '---------------------------------------*/
   $sql = "Update CdpConPag set EstCon='A' where RefCon='".$arc_ref."';";
   pg_query($bd_conexion,$sql);
   /*'---------------------------------------------------------------------------------------
   '-- Cambiamos el estatus de las Emisiones que estan asociadas a las cuotas a Vigentes --
   '---------------------------------------------------------------------------------------*/
   $sql = "update facregfac set EstFac='0',MonPag='0',FecPag=Null,RefPag=Null where reffac in ( ".
         "select a.reffac from cdpcuofac a,(select * from cdpdetcon where RefCon='".$arc_ref."' AND estcuo<>'C') b ".
         "where a.refcon=b.refcon  and a.numcuo=b.numcuo);";
   pg_query($bd_conexion,$sql);
   /*'----------------------------------------------------
   '-- Cancelamos las Facturas que gener√≥ el Convenio --
   '----------------------------------------------------*/
   $sql = "Update FacRegFac set EstFac='8', fecpag = current_date where ".
         "RefFac in (Select RefFac from CDPDetCon where RefCon='".$arc_ref."' and estcuo <> 'C');";
   pg_query($bd_conexion,$sql);
   pg_query($bd_conexion," commit;");
   return "1";
}
function Generar_CodigoConsecutivo($NombreTabla, $CampoClave, $Longitud){
    GLOBAL $bd_conexion;
    $condicion="";
    $maximo="";
    while (strlen($condicion)<$Longitud){
        $condicion=$condicion.'9';
    }    
    $sql = "Select Max(".$CampoClave.") From ".$NombreTabla." Where ".$CampoClave." < '".$condicion."'";
    $result=pg_query($bd_conexion,$sql);
    if (pg_num_rows($result)>0){
        $maximo=intval(pg_result($result,0,"max"))+1;
        while (strlen($maximo)<$Longitud){
            $maximo='0'.$maximo;
        }        
            return $maximo;
    } else{
        return "001";
    }
}
function multiexplode ($delimiters,$string) {
    $ary = explode($delimiters[0],$string);
    array_shift($delimiters);
    if($delimiters != NULL) {
        foreach($ary as $key => $val) {
             $ary[$key] = multiexplode($delimiters, $val);
        }
    }
    return  $ary;
}

function FILL($cadena, $cart, $cuantos, $modo){
//   Modo: Modo de relleno
//     1) Izquierda
//     2) Centrado
//     3) Derecha
$lonre;
$reizq;
$reder;
    if ($cart != ""){
        if (strlen($cadena) < $cuantos){
            $lonre = $cuantos - strlen($cadena);
            switch ($modo){
                case 1:{
                    $reizq=$lonre;
                    $reder=0;
                    break;
                }
                case 2:{
                    $reizq=$lonre/2;
                    $reder=$lonre-$reizq;
                    break;
                }
                case 3:{
                        $reizq=0;
                        $reder=$lonre;
                        break;
                }
            }
            for($lonre=1;$lonre<=$reizq;$lonre++){
                $cadena= $cart."".$cadena;
            }
            for($lonre=1;$lonre<=$reder;$lonre++){
                $cadena=$cadena."".$cart;
            }
        }
    }
    return $cadena;
}
function rec_regdompago_Generar_CodigoInterno($NombreTabla, $CampoClave, $ValorDelCampoClave ){
    GLOBAL $bd_conexion;
    $CodigoInterno = "1";
    $CodigoInterno =$ValorDelCampoClave.FILL($CodigoInterno, "0", 7, 1);
    $sql = "SELECT MAX(".$CampoClave.") FROM ".$NombreTabla." where ".$CampoClave.
        " LIKE '".$ValorDelCampoClave."%'";
    $result=pg_query($bd_conexion,$sql);
    $coun=pg_num_rows($result);
    if($coun>0){
        $numde=pg_fetch_result($result,0,"max");
        if($numde!=""){
            $Codigo =substr(trim($numde),3,7);
      $Codigo +=1;
      $CodigoInterno =$Codigo;
      $CodigoInterno = FILL(trim($Codigo), "0", 7, 1);
      $CodigoInterno = $ValorDelCampoClave.$CodigoInterno;
    }else{
        $CodigoInterno = $ValorDelCampoClave.$CodigoInterno;
    }
}
return $CodigoInterno;
}
//FIN DE CODIGO DE MICHAEL

//FUNCIONES SOLICITUD DE SERVICIO
function Grabar_RecaudosSolicitud($numsol,$recaudos)
{
	GLOBAL $bd_conexion;
	$sql = "Delete from AclRecSol where NumSol = '".$numsol."'";
	$result = pg_query($bd_conexion,$sql);
	
	$i = 0;
	while($i<strlen($recaudos) && $recaudos[$i]!="")
	{
   		$sql = "Insert into AclRecSol (NumSol,CodRec) values ('".$numsol."','".$recaudos[$i]."')";
    	$result = pg_query($bd_conexion,$sql);
    	$i = $i+1;
	}
}
// FIN DE FUNCIONES SOLICITUD DE SERVICIOS








function Obtener_PrecioReferencial($EncontroPrecio,$CodigoServicio,$CodSubAcu,$CodUso)
{
	GLOBAL $bd_conexion;
	$sql = "Select * From FacPreRef Where CodSubAcu='".$CodSubAcu."' and CodSer = '".$CodigoServicio."' And coduso='".$CodUso."' order by substr(emision,3,4)||substr(emision,1,2) desc";
	$result = pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0) 
	{
    	if (pg_result($result,0,"tippre")=="P")
    	{ 
    		return (pg_result($result,0,"preref") / 100);
    	}
		else
    	{
       		return pg_result($result,0,"preref");
		}
	}
	else
	{
    	return 0;
	}
}



//FUNCION DE GENERACION DE FACTURA EN ORDEN DE TRABAJO
function Generar_Factura($codinttom,$numord)
{
	GLOBAL $bd_conexion;
	
	//Determina el Estatus de la cuenta
	$mEstTom = "";
	$sql = "Select * From maeregtom Where CodInttom = '".$codinttom."'";
	$result=pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{
    	$mEstTom = pg_result($result,0,"esttom");
    	$mCodusotar = pg_result($result,0,"codusotar");
    	$mCodSubAcu = pg_result($result,0,"subacu");
    	$CodIntSus = pg_result($result,0,"codintper");
    	$CodIntInm = pg_result($result,0,"codintinm");
	}

	//Si la cuenta se encuentra en estatus de corte
	if ($mEstTom == "3" || $mEstTom == "6")
	{
		$xTieRei = false;
    	$mreffac = "";
    	
    	//Determina si existe la factura de corte correspondiente
    	switch ($mEstTom)
    	{
    		case "3":
    		{
            	$XCodSer = "008";
            	$xTipOrd = "003";
            	break;
            }
        	case "6":
        	{
        		$XCodSer = "024";
        		$xTipOrd = "024";
        		break;
        	}
		}
    	$sql = "Select * from FacSerFac where CodSer = '".$XCodSer."' and reffac in (select reffac from facregfac where codinttom = '".$codinttom."' and estfac = '0')";
    	$result=pg_query($bd_conexion,$sql);
    	if(pg_num_rows($result)>0)
    	{
       		$xTieRei = true;
		}
		else
		{
			$xTieRei = false;
		}
    
		//Si no existe, genera la factura de corte correspondiente
		if ($xTieRei == false)
		{
        	//Determina el nombre abreviado del servicio
        	$sql = "Select nomabr, desser From ParServic Where CodSer ='".$XCodSer."' and TemSer <> 'E' and sta_act = '1'";
			$result=pg_query($bd_conexion,$sql);
    		if(pg_num_rows($result)>0)
    		{
            	$xDesSer = pg_result($result,0,"desser");
            	if (pg_result($result,0,"nomabr") == "")
            	{ 
            		$XCodEmi = "OTR_SV";
    			}
            	else
            	{ 
            		$XCodEmi = pg_result($result,0,"nomabr");
            	}
            }
        
        	//Determina el n˙mero de la orden correspondiente al corte
			$sql = "select numord, numsol from OrtOrdTra where CodIntTom = '".$codinttom."' and TipOrd = '".$xTipOrd."' and status = 'E' order by fecord desc limit 1";
			$result=pg_query($bd_conexion,$sql);
    		if(pg_num_rows($result)>0)
    		{
            	$xNumOrd = pg_result($result,0,"numord");
            	$mNumSol = pg_result($result,0,"numsol");
        	}
        
        	//Genera la factura correspondiente al corte
        	$XMonFac = Grabar_En_Facturacion1($xNumOrd, $XCodSer, $XCodEmi, $xDesSer, $CodIntSus, $CodIntInm,$codinttom, $mCodusotar, 1, $mreffac, $mCodSubAcu);
            
        	//Si la factura no se genera satisfactoriamente
        	if ($XMonFac == 0)
        	{
        		cuadro_mensaje2("La factura no se genero correctamente, verificar");
        		exit;
        	}
        
        	//Actualiza la Orden de Trabajo con la factura generada
        	$sql = "update ortordtra set reffac = '".$mreffac."' where numord = '".$xNumOrd."'";
        	$result=pg_query($bd_conexion,$sql);
        
        	//Si existe una solicitud de servicio, actualiza la Solicitud
        	/*
        	if ($mNumSol != "")
        	{
        		$sql = "UPDATE aclsolser SET WHERE numsol = '" & DatosOrd(6).Text & "'";
        	}
        	*/
            
		}
	}

	//Asigna el servicio de cobro extrajudicial
	$XCodSer = "044";
	$sql = "Select nomabr, desser From ParServic Where CodSer ='".$XCodSer."' and TemSer <> 'E' and sta_act = '1'";
	$result=pg_query($bd_conexion,$sql);
	//Determina el nombre abreviado del servicio
	if(pg_num_rows($result)>0)
    {
    	$xDesSer = pg_result($result,0,"desser");
    	if (pg_result($result,0,"nomabr") == "")
    	{
    		$XCodEmi = "OTR_SV";
    	}
	    else
	    {
	    	$XCodEmi = pg_result($result,0,"nomabr");
    	}
	}

	$mreffac = "";
	$XMonFac = 0;

	//Determina el monto de la deuda
	$sql = "select sum(monfac - mondes + monaju - monpag) as xDeuda from facregfac
    		where CodIntTom = '".$codinttom."' and estfac = '0' and (monfac - mondes + monaju - monpag) > 0";
    $result=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result)>0)
	{
    	$XMonFac = pg_result($result,0,"xdeuda");
    	if ($XMonFac == 0) 
    	{
        	cuadro_mensaje2("Para Ejecutar esta accion la cuenta debe mantener una deuda con la Hidrologica. Revise sus Datos...");
        	exit;
		}
	}

	//Si la factura correspondiente al cobro extrajudicial se genera satisfactoriamente
	if (Grabar_En_Facturacion1($numord,$XCodSer,$XCodEmi,$xDesSer,$CodIntSus,$CodIntInm,$codinttom,$mCodusotar,$XMonFac,$mreffac,$mCodSubAcu) > 0)
	{
    	//Ingresa la cuenta al cÛdigo especial correspondiente
    	$sql = "SELECT codesp FROM parctacodesp WHERE codinttom = '".$codinttom."'";
    	$result=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result)>0)
		{
        	$sql = "UPDATE parctacodesp SET codesp = '000' WHERE codinttom = '".$codinttom."'";
			$result=pg_query($bd_conexion,$sql);
		}
    	else
    	{
	        $sql = "INSERT INTO parctacodesp (codesp, codinttom, codintusu) VALUES ('000', '".$codinttom."', '".$CodIntUsu."')";
	        $result=pg_query($bd_conexion,$sql);
	    }
	}
	return true;
}
//FIN FUNCION DE GENERACION DE FACTURA EN ORDEN DE TRABAJO


function Grabar_En_Facturacion1($mRefOrd,$mCodSer,$mCodemi,$mDesSer,$mCodIntPer,$mCodIntInm,$mCodIntTom,$mCodUso,$mMonFac,$mreffac,$mCodSubAcu)
{
	$MontoTRecargo = 0;
	$mPreRef = Obtener_PrecioReferencial($EncontroPrecio,$mCodSer,$mCodSubAcu,$mCodUso);
	if ($mPreRef > 0)
	{
		$mreffac = correl_reffac($_SESSION["codofi"]);
		$mMonFac = $mMonFac * $mPreRef;
		
    	if (En_Facturacion($mRefOrd, $mCodIntInm, $mCodIntPer, $mCodIntTom, date("Y-m-d"), date("d/m/Y"),$_SESSION["codofi"], $mCodSubAcu, 0, 0, $mMonFac, $mMonRec, $mreffac, $mCodemi, "", $CodIntUsu) == 1) 
    	{
	       if (En_ServiciosFacturacion($mreffac, $mCodSer, "1", $mPreRef, $mMonFac)==1 )
        	{
	            if (Grabar_RecargoPorServicio($mreffac, $mCodSer, $mCodUso, $mMonFac, $mMonRec) )
            	{
	                if (Act_FacRefFac($mreffac, "reffac", $_SESSION["codofi"]) == 1)
                	{
	                    return $mMonFac;
					}
				}
			}
		}
	}
	else
	{
	    cuadro_mensaje2("En el Acueducto ".$mCodSubAcu." el Servicio ".$mDesSer." no tiene asociado un Precio Referencial para el uso ".$mCodUso.". Por favor verifique sus datos ");
	    exit;
	}
}


/********************FUNCIONES DE ALEXANDRA*************************/

//FUNCION QUE DEVUELVE EL ESTATUS DE UNA TOMA
function obtener_status($status){
	switch ($status){
		case '1':{
			return "ACTIVA";
			break;
		}
		case '2':{
			return "INACTIVA";
			break;
		}
		case '3':{
			return "CORTADA";
			break;
		}
		case '4':{
			return "ELIMINADA";
			break;
		}
		case '5':{
			return "RETIRADA";
			break;
		}
		case '6':{
			return "CORTADA C/ADEC";
			break;
		}
		case '7':{
			return "EXTRAJUDICIAL";
			break;
		}
	}
}

//FUNCION QUE DEVUELVE SI LA CUENTA TIENE RECLAMOS PENDIENTES
function cuenta_tiene_reclamo($codigo){
	GLOBAL $bd_conexion;
	$sql= "SELECT tiprec FROM aclrecque WHERE codinttom= '".$codigo."' and tiprec<'003'";
	$result= pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

//FUNCION QUE DEVUELVE SI LA CUENTA TIENE CONVENIO DE PAGO
function cuenta_tiene_convenio($codigo){
	GLOBAL $bd_conexion;
	$sql= "select estcon from cdpconpag WHERE codinttom= '".$codigo."' and estcon='V'";
	$result= pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{
		return true;
	}
	else
	{
		return false;
	}

}

function restar_dias($fecha,$dias){
return date("Y-m-d", strtotime("$fecha -$dias day")); 
}

function sumar_dias($fecha,$dias){
return date("Y-m-d", strtotime("$fecha +$dias day")); 
}

function datosMes($month = null, $year = null)
  {
      // The current month is used if none is supplied.
      if (is_null($month))
          $month = date('n');

      // The current year is used if none is supplied.
      if (is_null($year))
          $year = date('Y');

      // Verifying if the month exist
      if (!checkdate($month, 1, $year))
          return null;

      // Calculating the days of the month
      $first_of_month = mktime(0, 0, 0, $month, 1, $year);
      $days_in_month = date('t', $first_of_month);
      $last_of_month = mktime(0, 0, 0, $month, $days_in_month, $year);

      $m = array();
      $m['first_mday'] = 1;
      $m['first_wday'] = date('w', $first_of_month);
      $m['first_weekday'] = strftime('%A', $first_of_month);
      $m['first_yday'] = date('z', $first_of_month);
      $m['first_week'] = date('W', $first_of_month);
      $m['last_mday'] = $days_in_month;
      $m['last_wday'] = date('w', $last_of_month);
      $m['last_weekday'] = strftime('%A', $last_of_month);
      $m['last_yday'] = date('z', $last_of_month);
      $m['last_week'] = date('W', $last_of_month);
      $m['mon'] = $month;
      $m['month'] = strftime('%B', $first_of_month);
      $m['year'] = $year;

      return $m;
}
function actualizar_reffac_generacion($campo,$campo2,$codofi,$tipo)
{
GLOBAL $bd_conexion;
$sql = "Select * from FacRefFac where OfiCom='".$codofi."'";
$result = pg_query($bd_conexion,$sql);
if (pg_num_rows($result)>0)
{
	if ($tipo=='P')
	{
		$result2=pg_query($bd_conexion,"update facreffac set refser='".$campo."',numser='".$campo2."' where oficom='".$codofi."'");
		return "1";
	}
	else
	{
		$result2=pg_query($bd_conexion,"update facreffac set refnot_d='".$campo."',numcon_d='".$campo2."' where oficom='".$codofi."'");
		return "1";
	}	
}
else{
	
	$result2=pg_query($bd_conexion,"insert into facreffac (reffac, OfiCom) values ('".$campo."','".$codofi."')");
	return "1";
}
return "0";
}

function correl_reffac_generacion($codofi,$tipo)
{
	//echo $codofi;
	GLOBAL $bd_conexion;
	if ($tipo=='P')
	{
		$sql = "select max(substr(refser,5,16)) as reffac from facreffac where oficom='".$codofi."'";
		$result=pg_query($bd_conexion,$sql);		        

		if  (pg_num_rows($result)>0)
		{
			$reffac=intval(pg_result($result,0,"reffac"))+1;
			
	  		
			while (strlen($reffac)<16)
			{
				$reffac='0'.$reffac;
			}
				return $codofi."P".$reffac;
		}
		else
		{
			return $codofi."000000000000001";
		}
	}
	else
		{
		$sql = "select substr(refnot_d,6,15) as reffac from facreffac where oficom='".$codofi."'";
		
		$result=pg_query($bd_conexion,$sql);
		if (pg_num_rows($result)>0)
		{
			$reffac=intval(pg_result($result,0,"reffac"))+1;
			while (strlen($reffac)<15)
			{
				$reffac='0'.$reffac;
			}
				return $codofi."JD".$reffac;
		} 
		else
		{
			return $codofi."000000000000001";
		}
	}
}

function correl_num_control_generacion($codofi,$campo)
{
	GLOBAL $bd_conexion;
	$sql = "select $campo as numcon from facreffac where oficom='".$codofi."'";
	$result=pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{
		$numcon=intval(pg_result($result,0,"numcon"))+1;
		while (strlen($numcon)<8)
		{
			$numcon='0'.$numcon;     		
		}		
		return $numcon;		
	} 
	else
	{
		return "00000001";
	}

}

function mes_en_letras($mes)
{
	switch($mes)
	{
		case '01': $mes_letras='Enero'; break;
		case '02': $mes_letras='Febrero'; break;
		case '03': $mes_letras='Marzo'; break;
		case '04': $mes_letras='Abril'; break;
		case '05': $mes_letras='Mayo'; break;
		case '06': $mes_letras='Junio'; break;
		case '07': $mes_letras='Julio'; break;
		case '08': $mes_letras='Agosto'; break;
		case '09': $mes_letras='Septiembre'; break;
		case '10': $mes_letras='Octubre'; break;
		case '11': $mes_letras='Noviembre'; break;
		case '12': $mes_letras='Diciembre'; break;
    }
	
 return $mes_letras;	
}
function generar_codigo_producto($tabla,$campo,$categoria){
	GLOBAL $bd_conexion;
	$sql="select pre_categoria from categorias where id_categoria='".$categoria."'";
	$result2=pg_query($bd_conexion,$sql);
		$sql="select max(".$campo.") as maximo from ".$tabla." where ".$campo." like '".pg_result($result2,0,"pre_categoria")."%'";
	
	$result=pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{
		$codigo=substr(pg_result($result,0,"maximo"),4,6);

	} else
	{
		$codigo=0;
	}
	$codigo=$codigo+1;
	while (strlen($codigo)<6){
		$codigo='0'.$codigo;
	}
	return pg_result($result2,0,"pre_categoria").$codigo;
}
function generar_codigo_bd($tabla,$campo){
	GLOBAL $bd_conexion;
	$sql="select max(".$campo.") as maximo from ".$tabla;	
	$result=pg_query($bd_conexion,$sql);
	
	if (pg_num_rows($result)>0)
	{
		$numcon=intval(pg_result($result,0,"maximo"))+1;
		while (strlen($numcon)<12)
		{
			$numcon='0'.$numcon;
     		
		}
		
		return $numcon;		
	} 
	else
	{
		return "000000000001";
	}
}
function generar_id_compra($tabla,$campo,$tipo){
	GLOBAL $bd_conexion;
	$sql="select max(".$campo.") as maximo from ".$tabla." where ".$campo." like '".$tipo."%'";
	
	$result=pg_query($bd_conexion,$sql);
	if (pg_num_rows($result)>0)
	{
		$codigo=substr(pg_result($result,0,"maximo"),4,8);

	} else
	{
		$codigo=0;
	}
	$codigo=$codigo+1;
	while (strlen($codigo)<8){
		$codigo='0'.$codigo;
	}
	return $tipo.$codigo;
}

?>
