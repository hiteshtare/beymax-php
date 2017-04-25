<?php
  try
  {
	include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config
	
	//to get all devices data sorted by updated_date
	$sth = $db->prepare("SELECT r.room as rroom,r.alias as room,d.device as ddevice,d.name as device,no,c.code,c.state,ds.updated_date as timestamp FROM devicestat AS ds  INNER JOIN rooms AS r ON  ds.room = r.room INNER JOIN devices AS d ON ds.type = d.device INNER JOIN commands AS c ON ds.status = c.code AND ds.type = c.device WHERE ack=1 ORDER BY ds.updated_date DESC;");	
	$sth->execute();
	  
	//fetch all records into result
	$result = $sth->fetchAll();	   						
		
	$rows = count($result);//rows count
	
	if ($rows > 0) {
		printResult(1,$result); 
	}
	else{
		printResult(0,"zero recentdata fetched.");
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