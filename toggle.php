<?php
try
  {
	header('Access-Control-Allow-Origin: *'); //Cross Domain AJAX.
	error_reporting(0);	// Turn off all error reporting
	$config = parse_ini_file('../php_config.ini'); //read config
	$rfPath = $config[codesend_path]; //codesend path
	
	//outletId and outletStatus args
	$outletId = $_POST['outletId'];
	$outletStatus = $_POST['outletStatus'];

	//create rfCode 
	$rfCode = $outletId . $outletStatus;

	//create rfScript
	$rfScript = $rfPath . $rfCode;

	//execute rfScript
	$result = shell_exec($rfScript);

	//decode the result into resultData
	$resultData = json_decode($result, true);
	
	//extract flag and msg from resultData
	$obj = new stdClass();
	$obj->flag=$resultData['flag'];
	$obj->msg=$resultData['msg'];

	echo json_encode($obj); //print obj
}	 
catch (Exception $e) 
{
  echo 'General Error: <br>'.$e->getMessage();
}

?>
