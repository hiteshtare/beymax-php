<?php
  try
  {
	include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config
	
	//parameters passed from html  
	$userid = $_POST['userid'] ?? '';
	$room = $_POST['room'] ?? '';
	
	//check for null			
	if($userid != NULL && $room != NULL) {
	
	//check for valid data type
	if(is_string($userid) && is_string($room)) {
		
			//to get devices data userwise and roowmwise 
			$sth = $db->prepare('SELECT * FROM DeviceStat WHERE userid=:userid AND room=:room ORDER BY DATETIME(updated_date) DESC;');
			$sth->bindParam(':userid', $userid, PDO::PARAM_STR,55); //binding parameters
			$sth->bindParam(':room', $room, PDO::PARAM_INT);	
			$sth->execute();
			  
			//fetch all records into result
			$result = $sth->fetchAll();	   						

			$rows = count($result);//rows count
			
			if ($rows > 0) {
				printResult(1,$result); 
			}
			else{
				printResult(0,'zero roomdata fetched.');
			}
		}
		else {
			printResult(0,'FAILURE >> PARAMS data type cannot be invalid.'); 
		}
	}
	else{
		printResult(0,'FAILURE >> PARAMS cannot be null.'); 
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