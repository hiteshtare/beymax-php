<?php
  try
  {
	include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config
	
	//parameters passed from html  	
	$username = $_POST['username'];
	$oldpassword = $_POST['oldpassword'];
	$newpassword = $_POST['newpassword'];
	//$username = 'admin';
	//$oldpassword = 'admin1';
	//$newpassword = 'admin2';
	
		//check for null			
	if($username != NULL && $oldpassword != NULL && $newpassword != NULL) {
		
		//check for valid data type
		if(is_string($username) && is_string($oldpassword) && is_string($newpassword)) {
			
			//to get count for a user's credentials
			$sth = $db->prepare("SELECT COUNT(*) FROM userinfo WHERE username=:username AND password=:oldpassword;");
			$sth->bindParam(':username', $username, PDO::PARAM_STR, 55); //binding parameters
			$sth->bindParam(':oldpassword', $oldpassword, PDO::PARAM_STR, 55);
			$sth->execute();
			
			//fetch only one record into number_of_rows  
			$number_of_rows = $sth->fetchColumn();
			
			//to check number_of_rows is greater than zero
			if ($number_of_rows > 0) {
					$sth = $db->prepare("UPDATE userinfo SET password=:newpassword WHERE username=:username AND password=:oldpassword;");
					$sth->bindParam(':newpassword', $newpassword, PDO::PARAM_STR, 55); 
					$sth->bindParam(':username', $username, PDO::PARAM_STR, 55);
					$sth->bindParam(':oldpassword', $oldpassword, PDO::PARAM_STR, 55);
					$sth->execute();   
					
					$rows = $sth->rowCount();					
			
					if ($rows > 0) {
						printResult(1,"SUCCESS >> " . $rows . " rows affected."); 
					}
					else{
						printResult(0,"FAILURE >> 0 rows affected."); 
					}			
			}	
			else {
				printResult(0,"Invalid user credentails."); 
			}
		}
		else {
			printResult(0,"FAILURE >> PARAMS data type cannot be invalid."); 
		}
	}
	else{
		printResult(0,"FAILURE >> PARAMS cannot be null."); 
	}
	
	$db = NULL;	//close the database
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