<?php

require_once 'excel.php';

class ClientesAba extends ArchivoExcel
{
    /**
     * Obtiene datos de la hoja 1
     * @return array
     */
    public static function getSheetAbaPlus()
    {
        self::$cols = [
            'central' => 'A',
            'cedula' => 'C',
            'aba' => 'E',
            'equipo' => 'F',
            'unidad' => 'H'
        ];
        self::$sheet = self::$excel->setActiveSheetIndex(0);
        return self::getSheetData();
    }

    /**
     * Obtiene datos de la hoja 2
     * @return array
     */
    public static function getSheetITP()
    {
        self::$cols = [
            'central' => 'A',
            'cedula' => 'C',
            'movimiento' => 'F',
            'status' => 'G',
            'unidad' => 'I'
        ];
        self::$sheet = self::$excel->setActiveSheetIndex(1);
        return self::getSheetData();
    }
}
