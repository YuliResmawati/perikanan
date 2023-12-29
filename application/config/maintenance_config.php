<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['maintenance_mode'] = false;

if (PHP_SAPI != 'cli') {
	if($_SERVER['SERVER_NAME']=='dkpp.agamkab.go.id'){
		$config['maintenance_mode'] = false;
	}
}

?>