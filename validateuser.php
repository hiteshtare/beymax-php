<?php
  try
  {
		include 'mylib.php'; //include user-defined mylib
    $db = setConfig(); //mylib - set config

	//parameters passed from html  	
	$username = $_POST['username'];
	$password = $_POST['password'];
	//$username = "admin";
	//$password = "admin3";
		
	//to get userinfo data using username and password
	$sth = $db->prepare("SELECT id,name,count,time FROM userinfo WHERE username=:username AND password=:password;");
	$sth->bindParam(':username', $username, PDO::PARAM_STR, 55);	//binding parameters
	$sth->bindParam(':password', $password, PDO::PARAM_STR, 55);
	
	$sth->execute();
	  
	//fetch all records into result
	$result = $sth->fetchAll();	 

	$rows = count($result);//rows count
	
	if ($rows > 0) {
		printResult(1,$result); 
	}
	else{
		printResult(0,"Invalid user credentials.");
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