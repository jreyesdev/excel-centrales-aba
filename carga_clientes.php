<?php

session_start();

require_once 'funciones.php';

if (count($_FILES) && validaExtension()) {
    // Mueve a directorio subidas
    $ruta = moverArchivo('subidas/');
    // Renombra archivo con fecha de subida
    $ruta = renombarArchivo($ruta, 'cargaclientes_' . date('Y_m_d_H_i_s'));
    // Clases estaticas
    require_once 'clientes_aba.php';
    require_once 'centrales.php';
    require_once 'detalle.php';
    // Lee archivo
    ClientesAba::leerArchivo($ruta);
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
    // Separados por central
    $aba_plus_itp = [];
    foreach ([...$aba_plus, ...$itp] as $c) {
        $aba_plus_itp[$c['central']][] = $c;
    }
    // Datos de las centrales (centrales.xlsx)
    $cents = Centrales::getCentrales();
    $centrales = [];
    foreach ($cents as $cen) {
        if (preg_match('/^[0-9]{4}[A-Z]{1}$/', trim($cen['codigo']))) {
            $centrales[trim($cen['codigo'])] = $cen;
        }
    }
    // Ordenados por KEY
    ksort($aba_plus_itp);
    ksort($centrales);
    // Datos a guardar en el archivo
    $datos = [];
    foreach ($centrales as $cod => $cen) {
        if (isset($aba_plus_itp[$cod])) {
            $res = resultadoCentral($aba_plus_itp[$cod]);
            if ($res['V'] !== 'NULL') {
                $datos[] = [
                    'A' => trim($cen['codigo']),
                    'B' => trim($cen['nombre']),
                    'C' => trim($cen['region']),
                    'D' => trim($cen['estado']),
                    'E' => trim($cen['municipio']),
                    'F' => trim($cen['cant_mdu']),
                    'G' => trim($cen['puertos']),
                    'H' => $res['H'],
                    'I' => $res['I'],
                    'J' => $res['H'] + $res['I'],
                    'K' => $res['K'],
                    'L' => $res['L'],
                    'M' => $res['K'] + $res['L'],
                    'N' => trim($cen['puertos']),
                    'O' => $res['O'],
                    'P' => $res['P'],
                    'Q' => $res['O'] + $res['P'],
                    'R' => $res['R'],
                    'S' => $res['S'],
                    'T' => $res['R'] + $res['S'],
                    'U' => $res['U'],
                    'V' => trim($cen['segmento']),
                    'W' => trim($cen['u_nuevos']),
                    'X' => trim($cen['matriz']),
                    'Y' => trim($cen['u_nuevos']) + trim($cen['matriz']),
                    'Z' => trim($cen['estatus']),
                    'AA' => trim($cen['t_servicio'])
                ];
            }
        }
    }
    // Guarda los datos y devuelve la ruta del archivo guardado
    $archivoRuta = DetalleMDU::guardaArchivo($datos);

    error_reporting(E_ALL);

    if ($archivoRuta) {
        $_SESSION['file'] = $archivoRuta;
        setMsgSuccess('Archivo generado exitosamente.');
    } else {
        setMsgError('Error al generar el archivo');
    }
} else {
    // Agregar mensaje de error a variable $_SESSION
    setMsgError('Extension de archivo no permitido');
}
