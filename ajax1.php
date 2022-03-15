<?php
if(is_array($_FILES['archivoexcel']) && count($FILES['archivoexcel'])>0){
//Libreria phpexcel

	require'PHPexcel/Classes/PHPExcel.php';
	require'conexion.php';

	$tmpfname = $FILES['archivoexcel']['tmp_name'];

//Cargar Excel

	$excelobj = $leerexcel->load($tmpfname);

//Cargar hoja

	$hoja = $excelobj ->getSheet(0);
	$filas = $hoja ->getHighestRow();

	echo "<table id='tabla_detalle' class='tabla-responsive' style='width:100%;
	table-layout:fixed'>
	<thead>

		<tr>

			<td>Central</td>
			<td>Abonado</td>
			<td>Cedula_Rif</td>
			<td>Fecha_instalacion</td>
			<td>Aba</td>
			<td>Equipo</td>
			<td>Nombre_Razon_Zocial</td>
			<td>Unidad_negocio</td>

		</tr>
		</thead><tbody> id='ybody_tabla_detalle'>";

		for($row = 1;$row<=$filas;$row++){
			$Central = $hoja ->getcell('A'.$row)->getValue();
			$Abonado = $hoja ->getcell('B'.$row)->getValue();
			$Cedula_Rif = $hoja ->getcell('C'.$row)->getValue();
			$Fecha_instalacion  = $hoja ->getcell('D'.$row)->getValue();
			$Aba  = $hoja ->getcell('E'.$row)->getValue();
			$Equipo = $hoja ->getcell('F'.$row)->getValue();
			$Nombre_Razon_Zocial = $hoja ->getcell('G'.$row)->getValue();
			$Unidad_negocio = $hoja ->getcell('H'.$row)->getValue();
			echo"<tr>";
			echo"<td>".$Central."</td>";
			echo"<td>".$Abonado."</td>";
			echo"<td>".$Cedula_Rif."</td>";
			echo"<td>".$Fecha_instalacion."</td>";
			echo"<td>".$Aba."</td>";
			echo"<td>".$Equipo."</td>";
			echo"<td>".$Nombre_Razon_Zocial."</td>";
			echo"<td>".$Unidad_negocio."</td>";
			echo"</tr>";
		}

		echo "</tbody></table>"
}

?>