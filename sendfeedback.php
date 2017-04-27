<?php
 try
  {	
	include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config
	
    //parameters passed from html  
	$message = $_POST['message'] ?? '';
	$isattach = $_POST['include'] ?? '';
	//$message = 'testing123'; 
	//$isattach = '1';
	
	//check for null			
	if($message != NULL && $isattach != NULL) {
		
		//check for valid data type
		if(is_string($message) && is_string($isattach)) {
			$sth = $db->prepare('INSERT INTO feedback (message, isattach, inserted_date, issend) VALUES (:message, :isattach, datetime("now", "localtime"),	0);');
			$sth->bindParam(':message', $message, PDO::PARAM_STR, 255);	//binding parameters	   
			$sth->bindParam(':isattach', $isattach, PDO::PARAM_BOOL);
			$sth->execute();   
			$rows = $sth->rowCount();					
			
			if ($rows > 0) {
				printResult(1,'SUCCESS >> ' . $rows . ' rows affected.'); 
			}
			else{
				printResult(0,'FAILURE >> zero rows affected.');
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