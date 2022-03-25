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
				if (preg_match('/^(xls|xlsx)$/', $fileInfo['extension'])) {
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
