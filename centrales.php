<?php

require_once 'excel.php';

class Centrales extends ArchivoExcel
{
    /**
     * Archivo valido de centrales
     * @var string
     */
    public static $archivo = '';

    /**
     * Obtiene las centrales del archivo centrales.xlsx
     * ubicado en la raiz
     * @return array
     */
    public static function getCentrales()
    {
        self::setArchivoCentrales();
        self::leerArchivo(self::$archivo);
        self::$cols = ['codigo' => 'A', 'nombre' => 'B', 'region' => 'C', 'estado' => 'D'];
        self::$sheet = self::$excel->setActiveSheetIndex(0);
        return self::getSheetData();
    }

    /**
     * Selecciona el archivo de centrales
     */
    public static function setArchivoCentrales()
    {
        if (file_exists('centrales.xlsx')) {
            self::$archivo = 'centrales.xlsx';
        } else if (file_exists('centrales.xls')) {
            self::$archivo = 'centrales.xls';
        } else {
            setMsgError('Archivo de centrales no existe, por favor cargar archivo.');
        }
    }
}
