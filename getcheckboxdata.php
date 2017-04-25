<?php
  try
  {	
	include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config
	
	//to get checkbox data for all rooms with devices
	$sth = $db->prepare("SELECT (CASE LENGTH(r.room) WHEN 1 THEN 0 || r.room  ELSE r.room END) as room,r.alias,(CASE LENGTH(d.device) WHEN 1 THEN 0 || d.device  ELSE d.device END) as device,d.name,no,d.name || ' ' || no as nameno,isdim FROM rdmapping AS rd INNER JOIN rooms AS r ON r.room = rd.room INNER JOIN devices AS d ON rd.device = d.device WHERE rd.isactive=1;");
	$sth->execute();
	 
	//fetch all records into result
	$result = $sth->fetchAll();
	
	$rows = count($result);//rows count
	
	if ($rows > 0) {
		printResult(1,$result); 
	}
	else{
		printResult(0,"0 rows fetched.");
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