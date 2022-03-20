<?php
session_start();

require_once 'funciones.php';

if (count($_FILES) && validaExtension()) {
    // Elimina archivo de centrales
    eliminaArchivoCentrales();
    // Mueve archivo subido
    $ruta = moverArchivo('');
    // Renombrar a centrales.xlsx y mueve a raiz del proyecto
    $ruta = renombarArchivo($ruta, 'centrales');
    // Validar columnas segun tipo de datos
    // Mensaje de resultado
    setMsgSuccess('Archivo cargado');
    // echo '<pre>';
    // print_r('ruta: ');
    // print_r(pathinfo($ruta));
    // print_r('<br>');
    // print_r($_FILES);
    // echo '</pre>';
    // exit;
} else {
    // Agregar mensaje de error a variable $_SESSION
    setMsgError('Extension de archivo no permitido');
}
