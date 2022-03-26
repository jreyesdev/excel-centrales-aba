<?php

error_reporting(E_ERROR | E_PARSE);

require_once 'PHPExcel/Classes/PHPExcel.php';

class ArchivoExcel
{
    /** @var PHPExcel */
    public static $excel;

    /** @var PHPExcel_Worksheet */
    public static $sheet;

    /** @var array */
    public static $cols = [];

    /**
     * Lee archivo excel segun ruta
     * @param string $ruta
     */
    public static function leerArchivo(string $ruta)
    {
        if (!file_exists($ruta)) {
            setMsgError('Archivo no existe.');
        }
        self::$excel = PHPExcel_IOFactory::load($ruta);
    }

    /**
     * Obtiene datos de las colummnas de la hoja
     * segun propiedad $cols
     * @return array
     */
    public static function getSheetData()
    {
        $h = self::$sheet->getHighestRow();
        $resp = [];

        // Valida que exista mas de 1 fila
        if ($h < 2) {
            return [];
        }

        for ($i = 2; $i <= $h; $i++) {
            $row = [];
            foreach (self::$cols as $k => $col) {
                // Guarda cada valor de cada columna
                $row[$k] = self::$sheet->getCell($col . $i)->getCalculatedValue();
            }
            $resp[] = $row;
        }
        return $resp;
    }
}
