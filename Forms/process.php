<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is comming from a form

	//mysql credentials
	$mysql_host = "localhost";
	$mysql_username = "root";
	$mysql_password = "DukePeter6";
	$mysql_database = "test";
	
	$p_dob = filter_var($_POST["pet_dob"], FILTER_SANITIZE_STRING); //set PHP variables like this so we can use them anywhere in code below
	$p_age = filter_var($_POST["pet_age"], FILTER_SANITIZE_NUMBER_INT);
    $p_gender = filter_var($_POST["pet_gender"], FILTER_SANITIZE_STRING);
    $p_spayneuter = filter_var($_POST["pet_spayneuter"], FILTER_SANITIZE_STRING);
    $u_experience = filter_var($_POST["user_experience"], FILTER_SANITIZE_STRING);
    $u_city = filter_var($_POST["user_city"], FILTER_SANITIZE_STRING);
	$u_zip = filter_var($_POST["user_zip"], FILTER_SANITIZE_STRING);
    $u_home = filter_var($_POST["user_home"], FILTER_SANITIZE_STRING);
    $u_message = filter_var($_POST["user_message"], FILTER_SANITIZE_STRING);
    

	//Open a new connection to the MySQL server
	//see https://www.sanwebe.com/2013/03/basic-php-mysqli-usage for more info
	$mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
	
	//Output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}	
	
    //$statement = $mysqli->prepare("INSERT INTO test3 (pet_bdate, pet_age, gender, experience, user_city, user_region, user_zip, user_country, pet_illness, user_message) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,)"); //prepare sql insert query
    $statement = "INSERT INTO test4 (pet_dob, pet_age, pet_gender, pet_spayneuter, user_experience, user_city, user_zip, user_home, user_message) 
    VALUES ($p_dob, $p_age, '$p_gender', '$p_spayneuter', '$u_experience', '$u_city', '$u_zip', '$u_home', '$u_message')";
	//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
	//$statement->bind_param('sissssssss', $u_bdate, $u_age, $u_gender, $u_exp, $u_city, $u_region, $u_zip, $u_country, $u_illness, $u_message); //bind values and execute insert query
	
	if(mysqli_query($mysqli, $statement)) {
		print 'Hello!, it worked! (maybe)';
	}else{
		print $mysqli->error; //show mysql error if any
    }
    
    mysqli_close($mysqli);
}
?>