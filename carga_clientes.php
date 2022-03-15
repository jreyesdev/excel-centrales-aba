<?php

session_start();
require_once 'funcion.php';
if(count($_FILES) && validaExtension()){
    
    
    // Validar columnas segun tipo de datos
    $COLUMMNAS_ABA_PLUS = ['central','equipo','unidad negocio'];
    $COLUMMNAS_ITP = ['central','movimiento','unidad negocio'];

    $excel = PHPExcel_IOFactory::load($_FILES['archivo']['tmp_name']);
    // Lee hoja 1
    $excel->setActiveSheetIndex(0);

    // Valida las columnas en fila 1
    // Verificar el tamaño de la fila
    // Validar que existan las colummnas en $COLUMMNAS_ABA_PLUS

    //for($i=1; $i<=$tamFila)

    //numero de filas
    echo '<pre>';
    print_r($excel->setActiveSheetIndex(0)->getCell ('A1')->getCalculatedValue());
    echo '</pre>';
    exit;
}else{
    // Agregar mensaje de error a variable $_SESSION
    $_SESSION['error'] = 'Extension de archivo no permitido';
}

// REDIRECCION DE RESPUESTA
header('location: /excel2');