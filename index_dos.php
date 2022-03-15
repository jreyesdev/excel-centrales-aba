<?php
//importar
if(count($_POST)){
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require_once 'conexion.php';
	
	$archivos = '../Aba_Plus_Ordenes_ITP_IABA_Pendi';
//cargar
$excel = PHPExcel_IOFactory::load($archivos);
//cargar hoja
$excel -> setActiveSheetIndex(0);
//numero de filas
$numerofila = $excel -> setActiveSheetIndex(0);//-> getHighestRow();


for($i=2;$i <= $numerofila;$i++){ 
	
	$Central = $excel -> getActiveSheet() -> getCell ('A'.$i);//->getCalculatedValue();

	if($Central==""){
		
	}else{
		
		$Abonado = $excel -> getActiveSheet() -> getCell ('B'.$i);//->getCalculatedValue();
		
		$Cedula_Rif = $excel -> getActiveSheet() -> getCell ('C'.$i);//->getCalculatedValue();
		$Nombre_Apellido_Razon_Social = $excel -> getActiveSheet() -> getCell ('D'.$i);//->getCalculatedValue();
		
		$Orden = $excel -> getActiveSheet() -> getCell ('E'.$i);//->getCalculatedValue();
		$Movimiento = $excel -> getActiveSheet() -> getCell ('F'.$i);//->getCalculatedValue();
		$Status = $excel -> getActiveSheet() -> getCell ('G'.$i);//->getCalculatedValue();

		$Fecha_Solicitud = $excel -> getActiveSheet() -> getCell ('H'.$i);//->getCalculatedValue();
		
		$Unidad_Negocio = $excel -> getActiveSheet() -> getCell ('I'.$i);//->getCalculatedValue();
		
		$tabla = $Central.'-'.$Abonado.'-'.$Cedula_Rif.'-'.$Nombre_Apellido_Razon_Social.'-'.$Orden.'-'.$Movimiento.'-'.$Status.'-'.$Fecha_Solicitud.'-'.$Unidad_Negocio.'<br>';
		//$CONSULTA = "INSERT INTO clientes_aba_plus(Central,Abonado,Cedula_Rif,Fecha_Instalacion,Aba,Equipo,Nombre_Razon_Zocial,Unidad_Negocio) value ('$Central', '$Abonado', '$Cedula_Rif', '$Fecha_Instalacion', '$Aba', '$Equipo', '$Nombre_Razon_Zocial', '$Unidad_Negocio')";
		print_r($tabla);
		
		//$resultado = $mysqli->query ($CONSULTA);
		
	}
	
}
//header('location: /excel2');
}
?>