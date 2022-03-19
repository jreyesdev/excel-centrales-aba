<?php

error_reporting(E_ERROR | E_PARSE);

require_once 'PHPExcel/Classes/PHPExcel.php';

class ClientesAba
{
    /** @var PHPExcel */
    public static $excel;

    /** @var PHPExcel_Worksheet */
    public static $sheet;

    /** @var array */
    public static $cols = [];

    public static function leerArchivo(string $ruta)
    {
        self::$excel = PHPExcel_IOFactory::load($ruta);
    }

    /**
     * Obtiene datos de la hoja 1
     * @return array
     */
    public static function getSheetAbaPlus()
    {
        self::$cols = ['central' => 'A', 'equipo' => 'F', 'unidad' => 'H'];
        self::$sheet = self::$excel->setActiveSheetIndex(0);
        return self::getSheetData();
    }

    /**
     * Obtiene datos de la hoja 2
     * @return array
     */
    public static function getSheetITP()
    {
        self::$cols = ['central' => 'A', 'movimiento' => 'F', 'unidad' => 'I'];
        self::$sheet = self::$excel->setActiveSheetIndex(1);
        return self::getSheetData();
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
