<?php
 try
  {  	
	include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config
	
    //parameters passed from html  	
	$POST_DATA = file_get_contents('php://input');
	$Request = json_decode($POST_DATA);
	$arr_deviceId = $Request->o_deviceId;
  
	//to iterate through arr_deviceId
	for ($i = 0; $i < count($arr_deviceId); ++$i) {
        
		//get each value from arr_deviceId and arr_checked
		$deviceId = $arr_deviceId[$i];
	
		if ($i == 0) {
			//delete all revoke records
			$sth = $db->prepare('DELETE FROM revoke;');
			$sth->execute();
		}
		
		//to insert revoke data using deviceid and checked
		$sth = $db->prepare('INSERT INTO revoke (deviceid, ischeck, inserted_date, updated_date) VALUES (:deviceId,1,datetime("now", "localtime"),datetime("now", "localtime"));');
		$sth->bindParam(':deviceId', $deviceId, PDO::PARAM_STR, 55);
		$sth->execute();   
	
    }
	
	printResult(1,'SUCCESS >> ' . count($arr_deviceId) . ' rows affected.'); 
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