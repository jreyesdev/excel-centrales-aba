<?php

/**
 * Valida extension del archivo enviado por POST
 * @return boolean
 */
function validaExtension()
{
	$file = explode('.', $_FILES['archivo']['name']);
	$ext = array_pop($file);
	return $ext === 'xlsx' || $ext === 'xls' ? true : false;
}

/**
 * Mueve archivo a directorio
 * @param string $dir
 * @return string|boolean
 */
function moverArchivo(string $dir = '/')
{
	$ruta = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir . basename($_FILES['archivo']['name']);
	// Agregar validacion de subida del archivo
	if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)) {
		return $ruta;
	} else {
		setMsgError('Error al mover archivo');
		return false;
	}
}

/**
 * Renombrar archivo
 * @param string $dir
 * @param string $newName
 * @return string
 */
function renombarArchivo(string $dir, string $newName)
{
	$info = pathinfo($dir);
	$fileName =  $info['dirname'] . DIRECTORY_SEPARATOR . $newName . '.' . $info['extension'];
	rename($dir, $fileName);
	return $fileName;
}

/**
 * Elimina archivo antiguo de centrales.xlsx/xls
 */
function eliminaArchivoCentrales()
{
	if (file_exists('centrales.xls')) {
		unlink('centrales.xls');
	}
	if (file_exists('centrales.xlsx')) {
		unlink('centrales.xlsx');
	}
}

/**
 * Crea mensaje de error en variable global $_SESSION
 * @param string $msg
 * @return void
 */
function setMsgError(string $msg)
{
	$_SESSION['msg']['error'] = $msg;
	redirect();
}

/**
 * Crea mensaje de exito en variable global $_SESSION
 * @param string $msg
 * @return void
 */
function setMsgSuccess(string $msg)
{
	$_SESSION['msg']['success'] = $msg;
	redirect();
}

/**
 * Devuelve array de mensaje y su tipo,
 * alojados en $_SESSION
 * @return mixed
 */
function mensajesDeSession()
{
	$msg = false;
	if (isset($_SESSION['msg']) && count($_SESSION['msg'])) {
		if (isset($_SESSION['msg']['error'])) {
			$msg = ['error', $_SESSION['msg']['error']];
		} else if (isset($_SESSION['msg']['success'])) {
			$msg = ['success', $_SESSION['msg']['success']];
		}
		$_SESSION['msg'] = [];
	}
	return $msg;
}

/**
 * Redirige a pag principal
 * @param string $url
 * @return void
 */
function redirect(string $url = '')
{
	header('location: ../' . $url);
	die();
}

/**
 * Devuelve array ordenado descendentemente por nombre
 * @return array
 */
function archivosDirectorioResultado(): array
{
	// Archivos excel a retornar
	$files = [];
	// Directorio a consultar
	$dir = 'resultado/';
	// Valida si existe el directorio
	if (is_dir($dir)) {
		// Valida si puede leer el directorio
		if ($dh = opendir($dir)) {
			// Lee todos los archivos que contiene el directorio
			while (($file = readdir($dh)) !== false) {
				$fileInfo = pathinfo($dir . $file);
				// Valida que la extension sea xlsx o xls
				if (preg_match('/^detalle_mdu_[0-9]{4}(_[0-9]{2}){5}\.(xls|xlsx)$/', $fileInfo['basename'])) {
					// Agrega al arreglo
					$files[] = $fileInfo['basename'];
				}
			}
			closedir($dh);
		}
	}
	// Ordena descendentemente
	rsort($files);
	return $files;
}

/**
 * Valor cero para todas la columnas de la central
 * @return array
 */
function resultadoCentralNulo(): array
{
	return [
		'K' => 0,
		'L' => 0,
	];
}

/**
 * Devuelve datos para la central pasada por parametro
 * @param array $central
 * @return array
 */
function resultadoCentral(array $central): array
{
	$resp = [];
	$res_nores = [
		'RES' => 0,
		'NORES' => 0,
	];
	// Cantidad de usuarios VOZ
	$aux = array_reduce($central, 'usuariosVoz', $res_nores);
	$resp['H'] = $aux['RES'] ?? 0;
	$resp['I'] = $aux['NORES'] ?? 0;
	// Cantidad de puertos ABA Res y no RES
	$aux = array_reduce($central, 'puertosAbaPlus', $res_nores);
	$resp['K'] = $aux['RES'] ?? 0;
	$resp['L'] = $aux['NORES'] ?? 0;
	// Cantidad de CONRED RES y NORES
	$aux = array_reduce($central, 'comRed', $res_nores);
	$resp['O'] = $aux['RES'] ?? 0;
	$resp['P'] = $aux['NORES'] ?? 0;
	// Cantidad de ITP RES y NORES
	$aux = array_reduce($central, 'cantITP', $res_nores);
	$resp['R'] = $aux['RES'] ?? 0;
	$resp['S'] = $aux['NORES'] ?? 0;
	// IABA pendiente por crear
	$resp['U'] = pendienteIABA($central);
	// Segmento VPPS
	// $resp['V'] = segmentoVPPS($resp);
	return $resp;
}

/**
 * Separa ABA e ITP
 * @param array $central
 * @return array
 */
function separaABAITP(array $central): array
{
	$arr['aba'] = [];
	$arr['itp'] = [];
	foreach ($central as $cen) {
		if (key_exists('status', $cen)) {
			// ITP
			$arr['itp'][] = $cen;
		} else {
			// ABA
			$arr['aba'][] = $cen;
		}
	}
	return $arr;
}

/**
 * Cantidad de usuarios voz residenciales y no residenciales
 * @param array $acum
 * @param array $central
 * @return array
 */
function usuariosVoz(array $acum, array $central): array
{
	$unid = trim(strtoupper($central['unidad']));
	if ($unid === 'R') {
		$acum['RES']++;
	} else if ($unid === 'NR') {
		$acum['NORES']++;
	}
	return $acum;
}

/**
 * Cantidad de puertos ABA PLUS residenciales y no residenciales
 * @param array $acum
 * @param array $central
 * @return array
 */
function puertosAbaPlus(array $acum, array $central): array
{
	if (key_exists('aba', $central) && trim(strtoupper($central['aba'])) === 'ABA') {
		$unid = trim(strtoupper($central['unidad']));
		if ($unid === 'R') {
			$acum['RES']++;
		} else if ($unid === 'NR') {
			$acum['NORES']++;
		}
	}
	return $acum;
}

/**
 * Cantidad de COMRED IABA residencial y no residencial
 * @param array $acum
 * @param array $central
 * @return array
 */
function comRed(array $acum, array $central): array
{
	if (key_exists('status', $central) && trim($central['status']) === '399') {
		$unid = trim(strtoupper($central['unidad']));
		if ($unid === 'R') {
			$acum['RES']++;
		} else if ($unid === 'NR') {
			$acum['NORES']++;
		}
	}
	return $acum;
}

/**
 * Cantidad de ITP residencial y no residencial
 * @param array $acum
 * @param array $central
 * @return array
 */
function cantITP(array $acum, array $central): array
{
	if (key_exists('status', $central) && trim($central['status']) === '300') {
		$unid = trim(strtoupper($central['unidad']));
		if ($unid === 'R') {
			$acum['RES']++;
		} else if ($unid === 'NR') {
			$acum['NORES']++;
		}
	}
	return $acum;
}

/**
 * Cantidad de IABA pendientes por crear
 * @param array $central
 * @return int
 */
function pendienteIABA(array $central): int
{
	$arr = separaABAITP($central);
	$arr['pend'] = 0;
	// Busca los que no aparezcen en ITP
	foreach ($arr['aba'] as $user) {
		$aux = array_filter($arr['itp'], function ($item) use ($user) {
			return trim($user['cedula']) === trim($item['cedula']);
		});
		if (!count($aux)) {
			$arr['pend']++;
		}
	}
	return $arr['pend'];
}

/**
 * Establece valor para columna Segmento VPPS
 * @param array $central
 * @return string
 */
function segmentoVPPS(array $central): string
{
	$res = [];
	$nores = [];
	foreach ($central as $k => $val) {
		// RES
		if (in_array($k, ['H', 'K', 'O', 'R'])) {
			$res[] = $val;
		}
		// NORES
		if (in_array($k, ['I', 'L', 'P', 'S'])) {
			$nores[] = $val;
		}
	}
	if (array_sum($res)) {
		if (array_sum($nores)) {
			return 'MIXTO';
		}
		return 'RES';
	}
	if (array_sum($nores)) {
		return 'NORES';
	}
	// No agregar a los datos
	return 'NULL';
}
