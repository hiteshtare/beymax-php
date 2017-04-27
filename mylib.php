<?php
  function setConfig(){
  header('Access-Control-Allow-Origin: *'); //Cross Domain AJAX.
	error_reporting(0);	// Turn off all error reporting
	$config = parse_ini_file('../php_config.ini'); //read config
	$db = new PDO($config['db_path']); //open the database
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //exception mode true 
	return $db;
  }	

  function printResult($flag, $message){ 
    $result = new stdClass();
	$result->flag=$flag;
	$result->message=$message;
	
	echo json_encode($result);
  }
?>