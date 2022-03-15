<?php
session_start();
//importar
/*
if(count($_POST)){
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require_once 'conexion.php';
	
	$archivos = '../clientes aba plus.xlsx';
//cargar
$excel = PHPExcel_IOFactory::load($archivos);
//cargar hoja
$excel -> setActiveSheetIndex(0);
//numero de filas
$numerofila = $excel -> setActiveSheetIndex(0)->getHighestRow();

for($i=1;$i <= $numerofila;$i++){ 
	
	$Central = $excel -> getActiveSheet() -> getCell ('A'.$i)->getCalculatedValue();

	if($Central==""){
		
	}else{		
		$Abonado = $excel -> getActiveSheet() -> getCell ('B'.$i)->getCalculatedValue();
		
		$Cedula_Rif = $excel -> getActiveSheet() -> getCell ('C'.$i)->getCalculatedValue();
		$Fecha_Instalacion = $excel -> getActiveSheet() -> getCell ('D'.$i) ->getCalculatedValue();
		$Aba = $excel -> getActiveSheet() -> getCell ('E'.$i)->getCalculatedValue();
		$Equipo = $excel -> getActiveSheet() -> getCell ('F'.$i)->getCalculatedValue();
		$Nombre_Razon_Zocial = $excel -> getActiveSheet() -> getCell ('G'.$i)->getCalculatedValue();
		
		$Unidad_Negocio = $excel -> getActiveSheet() -> getCell ('H'.$i)->getCalculatedValue();
		
		$tabla = $Central.'-'.$Abonado.'-'.$Cedula_Rif.'-'.$Fecha_Instalacion.'-'.$Aba.'-'.$Equipo.'-'.$Nombre_Razon_Zocial.'-'.$Unidad_Negocio.'<br>';
		//$CONSULTA = "INSERT INTO clientes_aba_plus(Central,Abonado,Cedula_Rif,Fecha_Instalacion,Aba,Equipo,Nombre_Razon_Zocial,Unidad_Negocio) value ('$Central', '$Abonado', '$Cedula_Rif', '$Fecha_Instalacion', '$Aba', '$Equipo', '$Nombre_Razon_Zocial', '$Unidad_Negocio')";
		print_r($tabla);
				//$resultado = $mysqli->query ($CONSULTA);		
	}
	
}
//header('location: /excel2');
}
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<title>Archivos Excel</title>
</head>
<body>
	
				 <div class="col-lg-12" style="padding-top:20px">
				 	<?= $_SESSION['error']; ?>
				 </div>
     

  <div class="card-header">
   <b>Importar Excel Clientes Aba</b>
  </div>
    	<div class="formulario">
		<form action="carga_clientes.php" class="formulariocompleto" method="post" enctype="multipart/form-data">
			 <div class="row">
			<input type="file" name="archivo" class="form-control">
			<div class="col-lg-2">
			<input class="btn btn-primary" style="width:100%" type="submit" value="SUBIR ARCHIVO" class="form-control" name="enviar">
		 </div>
     <div class="col-lg-5" id="div_table"><br> 
     </div>
     </div>
      </form>
      </div>
      <br>
      <br>



      <div class="card-header">
   <b>Centrales MDU</b>
  </div>
    	<div class="formulario">
		<form action="actualiza_centrales.php" class="formulariocompleto" method="post" enctype="multipart/form-data">
			 <div class="row">
			<input type="file" name="archivo" class="form-control">
			<div class="col-lg-2">
			<input class="btn btn-warning" style="width:100%" type="submit" value="SUBIR ARCHIVO" class="form-control" name="enviar">
		 </div>
     <div class="col-lg-5" id="div_table"><br> 
     </div>
     </div>
      </form>
      </div>
      <br>
      <br>


      <div class="card-header">
   <b>RESUMEN</b>
  </div>
    	<div class="formulario">
		<form action="index_cruce.php" class="formulariocompleto" method="post" enctype="multipart/form-data">
			 <div class="row">
			<div class="col-lg-2">
			<input class="btn btn-danger" style="width:100%" type="submit" value="Resultado" class="form-control" name="enviar">
		 </div>
     <div class="col-lg-5" id="div_table"><br> 
     </div>
     </div>
      </form>
      </div>
      <br>
      <br>
     

</body>
</html>
