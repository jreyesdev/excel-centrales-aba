<?php
session_start();
require_once 'funcion.php';
if(count($_FILES) && validaExtension()){
    
    
    // Validar columnas segun tipo de datos
    // Copiar a raiz del proyecto
    // Renombrar a centrales.xlsx
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
    exit;
}else{
    // Agregar mensaje de error a variable $_SESSION
    $_SESSION['error'] = 'Extension de archivo no permitido';
}

// REDIRECCION DE RESPUESTA
header('location: /excel2');
