<?php
  try
  {	
	header('Access-Control-Allow-Origin: *'); //Cross Domain AJAX.
	error_reporting(0);	// Turn off all error reporting
	$config = parse_ini_file('../php_config.ini'); //read config
	$db = new PDO($config[db_path]); //open the database
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //exception mode true 
	
	//to get count from status
	$sth = $db->prepare("SELECT COUNT(*) FROM status WHERE name='RFSniffer' AND isrunning=1;");	
	$sth->execute();
	
	//fetch all records into result
	$result = $sth->fetchAll();	   						

	$db = NULL;	//close the database
	
	echo json_encode($result); //print result
  }
catch (PDOException $e) 
{
  echo "DataBase Error: <br>".$e->getMessage();
} 
catch (Exception $e) 
{
  echo "General Error: <br>".$e->getMessage();
}
  
?>