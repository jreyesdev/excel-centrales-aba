<?php
//importar
if(count($_POST)){
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require_once 'conexion.php';
	
	$archivos = 'Centrales_mdu';
//cargar
$excel = PHPExcel_IOFactory::load($archivos);
//cargar hoja
$excel -> setActiveSheetIndex(0);
//numero de filas
$numerofila = $excel -> setActiveSheetIndex(0);//-> getHighestRow();


for($i=2;$i <= $numerofila;$i++){ 
	
	$CODIGO_CONTABLE = $excel -> getActiveSheet() -> getCell ('A'.$i);//->getCalculatedValue();

	if($CODIGO_CONTABLE==""){
		
	}else{
		
		$NOMBRE_DE_EQUIPO = $excel -> getActiveSheet() -> getCell ('B'.$i);//->getCalculatedValue();
		
		$REGION = $excel -> getActiveSheet() -> getCell ('C'.$i);//->getCalculatedValue();
		$ESTADO = $excel -> getActiveSheet() -> getCell ('D'.$i);//->getCalculatedValue();
		
		
		$tabla = $CODIGO_CONTABLE.'-'.$NOMBRE_DE_EQUIPO.'-'.$REGION.'-'.$ESTADO.'<br>';
		//$CONSULTA = "INSERT INTO clientes_aba_plus(Central,Abonado,Cedula_Rif,Fecha_Instalacion,Aba,Equipo,Nombre_Razon_Zocial,Unidad_Negocio) value ('$Central', '$Abonado', '$Cedula_Rif', '$Fecha_Instalacion', '$Aba', '$Equipo', '$Nombre_Razon_Zocial', '$Unidad_Negocio')";
		print_r($tabla);
		
		//$resultado = $mysqli->query ($CONSULTA);
		
	}
	
}
//header('location: /excel2');
}
?>