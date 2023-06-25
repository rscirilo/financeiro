<?php
require 'environment.php';

global $config;
$config = array();
if(ENVIRONMENT == 'development') {
	$config['dbname'] = 'u768380518_diego';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'u768380518_diego';
	$config['dbpass'] = '310199@Aa';
} else {
	$config['dbname'] = 'financeiro';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
}
?>