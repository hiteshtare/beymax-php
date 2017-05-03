<?php
  try
  {	
		include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config

//to get count from status
	$sth = $db->prepare('SELECT * FROM rooms where room=1');	
	//$sth = $db->prepare('SELECT COUNT(*) FROM status WHERE name="RFSniffer" AND isrunning=1;');	
	$sth->execute();
	
	//fetch all records into result
	$result = $sth->fetchAll();	   						
		
	$rows = count($result);//rows count
	
		if ($rows > 0) {
		printResult(1,'Service is running.'); 
	}
	else{
		printResult(0,'Service has stopped working!');
	}
  }
catch (PDOException $e) 
{
  echo 'DataBase Error: <br>'.$e->getMessage();
} 
catch (Exception $e) 
{
  echo 'General Error: <br>'.$e->getMessage();
}
  
?>