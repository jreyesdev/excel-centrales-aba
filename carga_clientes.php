<?php

session_start();

require_once 'funciones.php';

if (count($_FILES) && validaExtension()) {
    // Mueve a directorio subidas
    $ruta = moverArchivo('subidas/');
    // Validar columnas segun tipo de datos
    $COLUMMNAS_ABA_PLUS = ['central', 'equipo', 'unidad negocio'];
    $COLUMMNAS_ITP = ['central', 'movimiento', 'unidad negocio'];


    require_once 'excel.php';

    $excel = ClientesAba::leerArchivo($ruta);
    // Valida cantidad de hojas
    if (ClientesAba::$excel->getSheetCount() !== 2) {
        // Faltan hojas
        // Elimina archivo
        unlink($ruta);
        setMsgError('Error de hojas. Deben existir hojas con datos de clientes ABA plus y clientes ITP');
    }
    // Datos hoja 1
    $aba_plus = ClientesAba::getSheetAbaPlus();
    // Datos hoja 2
    $itp = ClientesAba::getSheetITP();
    // Arreglos combinados
    $aba_plus_itp = [...$aba_plus];
    foreach ($itp as $v) {
        $aba_plus_itp[] = $v;
    }
    // Todas las centrales
    $centrales = [];

    foreach ($aba_plus_itp as $c) {
        $centrales[$c['central']][] = $c;
    }


    error_reporting(E_ALL);
    echo '<pre>';
    print_r(($centrales));
    echo '</pre>';
    exit;
} else {
    // Agregar mensaje de error a variable $_SESSION
    setMsgError('Extension de archivo no permitido');
}
