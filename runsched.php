<?php
 try
  { 
	include 'mylib.php'; //include user-defined mylib  
	
	header('Access-Control-Allow-Origin: *'); //Cross Domain AJAX.
	error_reporting(0);	// Turn off all error reporting
	$config = parse_ini_file('../php_config.ini'); //read config
	$rfPath = $config[schedular_path]; //schedular path
	
	//operation and param args
	$operation = $_POST['operation'];
	$param = $_POST['param'];

	//$operation = '5';
	//$param = 'lights on';

	//create rfCode 
	$rfCode = $operation . ',' . $param;

	//create rfScript
	$rfScript = $rfPath . '"' . $rfCode . '"';

	//execute rfScript
	$result = shell_exec($rfScript);

	//decode the result into resultData
	$resultData = json_decode($result, true);
	
	//extract flag and msg from resultData
	$obj = new stdClass();
	$obj->flag=$resultData['flag'];
	$obj->msg=$resultData['msg'];

	//echo json_encode($obj); //print obj
	printResult($resultData['flag'],$resultData['msg']); 
	}	 
catch (Exception $e) 
{
  printResult(0,'FAILURE >> General Error: '.$e->getMessage()); 
}

?>
