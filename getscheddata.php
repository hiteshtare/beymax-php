<?php
  try
  {	
	include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config
	
	//to get all schedular data
	$sth = $db->prepare("SELECT room,type,no,status,timeslice,comment, CASE isactive WHEN 1 THEN 'Active' ELSE 'Disabled' END AS 'isactive',frequency,prev_schedule,next_schedule FROM schedular WHERE isdeleted=0 ORDER BY DATETIME(next_schedule) DESC;");	
	$sth->execute();
	  
	//fetch all records into result
	$result = $sth->fetchAll();	   						

	$rows = count($result);//rows count
	
	if ($rows > 0) {
		printResult(1,$result); 
	}
	else{
		printResult(0,"zero scheddata fetched.");
	}
  }
catch (PDOException $e) 
{
	printResult(0,"FAILURE >> Database Error: ".$e->getMessage()); 
} 
catch (Exception $e) 
{
	printResult(0,"FAILURE >> General Error: ".$e->getMessage()); 
}
finally {
    $db = NULL;	//close the database
}
?>