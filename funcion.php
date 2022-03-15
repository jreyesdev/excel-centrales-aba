<?php
	function validaExtension(){
		$ext = substr($_FILES['archivo']['name'],-4);
		return $ext === 'xlsx' ? true : false;
	}
