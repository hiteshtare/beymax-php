<?php
  try
  {
	include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config
	
	//parameters passed from html  
	$select = $_POST['select'] ?? '';
	$room = $_POST['room'] ?? '';
	$device = $_POST['device'] ?? '';
	
	//to reset result value
	$result = null;
	
	//check for null			
	if($select != NULL) {
		//check for valid data type
		if(is_string($select)) {
			
			if($select == 'room')
			{	
				//to get room data
				$sth = $db->prepare('SELECT room as value,alias as label FROM rooms WHERE isactive=1 ORDER BY room ASC;');		
				$sth->execute();
				  
				//fetch all records into result
				$result = $sth->fetchAll();

				$rows = count($result);//rows count
				
				if ($rows > 0) {
					printResult(1,$result); 
				}
				else{
					printResult(0,'zero selectdata fetched for room.');
				}  				
			}
			else if ($select == 'device')
			{	
				//to get devices data roomwise
				$sth = $db->prepare('SELECT room,d.device,d.name,no,isdim FROM rdmapping AS rd INNER JOIN devices AS d ON rd.device = d.device WHERE room=:room AND rd.isactive=1;');
				$sth->bindParam(':room', $room, PDO::PARAM_INT);	//binding parameters	 
				$sth->execute();
				  
				//fetch all records into result
				$result = $sth->fetchAll();	  						
				
				$rows = count($result);//rows count
				
				if ($rows > 0) {
					printResult(1,$result); 
				}
				else{
					printResult(0,'zero selectdata fetched for device.');
				}
			}
			else if ($select == 'state')
			{				
				//to get commands data devicewise
				$sth = $db->prepare('SELECT state as label,code as value FROM commands WHERE device=:device AND isactive=1 ORDER BY seq ASC;');
				$sth->bindParam(':device', $device, PDO::PARAM_INT);	
				$sth->execute();
				  
				//fetch all records into result
				$result = $sth->fetchAll();

				$rows = count($result);//rows count
				
				if ($rows > 0) {
					printResult(1,$result); 
				}
				else{
					printResult(0,'zero selectdata fetched for state.');
				}				
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