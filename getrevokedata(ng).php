<?php
  try
  {
	include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config
	
	//to get all revoke data
	$sth = $db->prepare('SELECT deviceid FROM revoke where ischeck=1;');	
	$sth->execute();
	  
	//fetch all records into result
	$result = $sth->fetchAll();	   						

	$rows = count($result);//rows count
	
	if ($rows > 0) {
		printResult(1,$result); 
	}
	else{
		printResult(0,'zero revokedata fetched.');
	}
  }
catch (PDOException $e) 
{
	printResult(0,'FAILURE >> Database Error: '.$e->getMessage()); 
} 
catch (Exception $e) 
{
	printResult(0,'FAILURE >> General Error: '.$e->getMessage()); 
}
finally {
    $db = NULL;	//close the database
}
?>