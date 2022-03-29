<?php

require_once 'excel.php';

class DetalleMDU extends ArchivoExcel
{
    /**
     * Nombre de archivo a crear
     * @var string
     */
    public static $nombreArchivo = '';

    /**
     * Nombre de la hoja
     * @var string
     */
    public static $hoja = 'Detalle MDU';

    /**
     * Datos a guardar en el archivo
     * @var array
     */
    public static $datos = [];

    /**
     * Estilos para el titulo de las columnas (header)
     * @var PHPExcel_Style[]
     */
    public static $estiloCabecera = [
        'fill' => [
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => '8DB4E2']
        ],
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],
            'size' => 14
        ],
        'alignment' => [
            'horizontal' => 'center',
            'vertical' => 'center'
        ],
        'borders' => [
            'allborders' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['rgb' => '000000']
            ]
        ]
    ];

    /**
     * Primera fila a guardar (Encabezado)
     * @var array
     */
    public static $header = [
        'A' => 'CODIGO CONTABLE',
        'B' => 'NOMBRE DE EQUIPO',
        'C' => 'REGION',
        'D' => 'ESTADO',
        'E' => 'MUNICIPIO',
        'F' => 'CANTIDAD DE MDU',
        'G' => 'PUERTOS HABILITADOS ASAP',
        'H' => 'USUARIOS VOZ (ABOACT ASAP) RES',
        'I' => 'USUARIOS VOZ (ABOACT ASAP) NORES',
        'J' => 'TOTAL VOZ (RES + NORES)',
        'K' => 'PUERTOS ABA (ABOACT ASAP) RES',
        'L' => 'PUERTOS ABA (ABOACT ASAP) NORES',
        'M' => 'TOTAL ABA (RES + NORES)',
        'N' => 'CANTIDAD DE VIVIENDAS',
        'O' => 'O/S COMRED (RES)',
        'P' => 'O/S COMRED (NORES)',
        'Q' => 'TOTAL COMRED (RES + NORES)',
        'R' => 'ITP RES (PINST)',
        'S' => 'ITP NORES (PINST)',
        'T' => 'TOTAL ITP (RES+NORES)',
        'U' => 'IABA PENDIENTE POR CREAR',
        'V' => 'SEGMENTO VPPS',
        'W' => 'USUARIOS NUEVOS',
        'X' => 'USUARIOS POR MATRIZ DE TRANSFERENCIA',
        'Y' => 'POTENCIALIDAD GGMM',
        'Z' => 'ESTATUS',
        'AA' => 'TIPO DE SERVICIO'
    ];

    /**
     * Guarda archivo excel los datos pasados por parametro
     * @param array $datos
     * @return string
     */
    public static function guardaArchivo(array $datos): string
    {
        try {
            self::$datos = $datos;
            self::setPropiedades();
            self::escribeCabecera();
            self::escribeDatos();
            self::setAutoDimensionColumnas();
            $ruta = self::rutaGuardado();
            PHPExcel_IOFactory::createWriter(self::$excel, 'Excel2007')->save($ruta);
            return $ruta;
        } catch (PHPExcel_Writer_Exception $e) {
            throw new PHPExcel_Writer_Exception($e);
        }
    }

    /**
     * Establece nombre del archivo a guardar
     * @return void
     */
    public static function setNombreArchivo(): void
    {
        self::$nombreArchivo = 'detalle_mdu_' . date('Y_m_d_H_i_s') . '.xlsx';
    }

    /**
     * Establece propiedades del archivo excel
     * @return void
     */
    public static function setPropiedades(): void
    {
        // Instancia del archivo
        self::$excel = new PHPExcel();
        // Propiedades del archivo
        self::$excel->getProperties()
            ->setCreator('')
            ->setLastModifiedBy("")
            ->setTitle(self::$hoja)
            ->setSubject("")
            ->setDescription("")
            ->setKeywords("Excel")
            ->setCategory("");
        // Establece hoja principal
        self::$sheet = self::$excel->setActiveSheetIndex(0);
        // Establece nombre a la hoja principal
        self::$sheet->setTitle(self::$hoja);
        // Columnas a escribir
        self::$cols = array_keys(self::$header);
    }

    /**
     * Escribe la primera fila (header)
     * @return void
     */
    public static function escribeCabecera(): void
    {
        foreach (self::$header as $col => $val) {
            self::$sheet->setCellValue($col . '1', $val);
        }
        self::aplicaEstilos(self::$estiloCabecera);
    }

    /**
     * Escribe los datos en el archivo
     * DATOS: array de array asociativos con claves como las columnas
     * @return void
     */
    public static function escribeDatos(): void
    {
        if (!count(self::$datos)) return;

        $row = 2;
        for ($i = 0; $i < count(self::$datos); $i++) {
            foreach (self::$cols as $col) {
                self::$sheet->setCellValue($col . $row, trim(self::$datos[$i][$col]));
            }
            $row++;
        }
        self::aplicaEstilos([
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        self::centralizaColumnas();
    }

    /**
     * Aplica estilos pasados por parametros a las filas escritas
     * @param array $styles
     * @return void
     */
    public static function aplicaEstilos(array $styles): void
    {
        self::$sheet->getStyle(
            'A1:' . self::$cols[count(self::$cols) - 1] . self::$sheet->getHighestRow()
        )->applyFromArray($styles);
    }

    /**
     * Aplica alineacion central a las columnas
     * @return void
     */
    public static function centralizaColumnas(): void
    {
        $cols = ['A2:A', 'F2:Y'];
        foreach ($cols as $col) {
            self::$sheet->getStyle($col . self::$sheet->getHighestRow())
                ->applyFromArray([
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],
                ]);
        }
    }

    /**
     * Autodimensiona las columnas para que se vean completas
     * @return void
     */
    public static function setAutoDimensionColumnas(): void
    {
        foreach (self::$cols as $col) {
            self::$sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    /**
     * Ruta completa para guardar archivo
     * @return string
     */
    public static function rutaGuardado(): string
    {
        // Nombre del archivo
        self::setNombreArchivo();
        $info = pathinfo(__FILE__);
        return $info['dirname'] . DIRECTORY_SEPARATOR . 'resultado/' . self::$nombreArchivo;
    }
}
