<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is comming from a form
	
	
	//mysql credentials
	$mysql_host = "localhost";
	$mysql_username = "root";
	$mysql_password = "DukePeter6";
	$mysql_database = "test";
	
	//Open a new connection to the MySQL server
	//see https://www.sanwebe.com/2013/03/basic-php-mysqli-usage for more info
	$mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);

	//Output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}	
	

	$id = uniqid();
	$premium = "error";
	$premium_calculator = "http://ec2-3-87-121-179.compute-1.amazonaws.com/premiumCalV2.php";

	$p_breed = filter_var($_POST["pet_breed"], FILTER_SANITIZE_STRING); //set PHP variables like this so we can use them anywhere in code below
	$p_dob = filter_var($_POST["pet_dob"], FILTER_SANITIZE_STRING);
	$p_age = filter_var($_POST["pet_age"], FILTER_SANITIZE_STRING);
    $p_gender = filter_var($_POST["pet_gender"], FILTER_SANITIZE_STRING);
    $p_spayneuter = filter_var($_POST["pet_spayneuter"], FILTER_SANITIZE_STRING);
    $u_experience = filter_var($_POST["user_experience"], FILTER_SANITIZE_STRING);
    $u_city = filter_var($_POST["user_city"], FILTER_SANITIZE_STRING);
	$u_zip = filter_var($_POST["user_zip"], FILTER_SANITIZE_STRING);
    $u_home = filter_var($_POST["user_home"], FILTER_SANITIZE_STRING);
    $u_message = filter_var($_POST["user_message"], FILTER_SANITIZE_STRING); 

	if($p_age == ""){
		$today = date("Y-m-d");
		$p_age = date_diff(date_create($p_dob), date_create($today))->format("%y");
	}
   
	function calculatePremium(){
		global $mysqli, $id, $p_breed, $p_dob, $p_age, $p_gender, $p_spayneuter, $u_experience, $u_city, $u_zip, $u_home, $u_message, $premium, $premium_calculator;
		$curl = curl_init();
		$cal_request_address = $premium_calculator."?";
		
		$cal_request_address = $cal_request_address."page=$p_age&";
		$cal_request_address = $cal_request_address."bread=$p_breed&";
		$cal_request_address = $cal_request_address."loca=$u_home&";
		$cal_request_address = $cal_request_address."repr=$p_spayneuter";
		
		curl_setopt($curl, CURLOPT_URL, $cal_request_address);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$premium = curl_exec($curl);
		curl_close($curl);
		
		// $statement = "INSERT INTO premiums (id, premium) VALUES ('$id', '$premium')";
		// if(mysqli_query($mysqli,$statement)){
		// 	echo "worked";
		// }else{
		// 	echo $mysqli->error;
		// }
	}



	// function storeInDB(){
	// 	global $mysqli, $p_breed, $p_dob, $p_age, $p_gender, $p_spayneuter, $u_experience, $u_city, $u_zip, $u_home, $u_message;
		
	// 	$statement = "INSERT INTO test5 (pet_breed, pet_dob, pet_age, pet_gender, pet_spayneuter, user_experience, user_city, user_zip, user_home, user_message) 
	// 	VALUES ('$p_breed', '$p_dob', '$p_age', '$p_gender', '$p_spayneuter', '$u_experience', '$u_city', '$u_zip', '$u_home', '$u_message')";
	
	// 	if(mysqli_query($mysqli, $statement)) {
	// 		print 'Hello!, it worked! (maybe)';
	// 	}else{
	// 		print $mysqli->error; //show mysql error if any
	// 	}
    
	// }

	function returnPremiumPage(){
		global $id;
		$url = "Location: http://ec2-3-87-121-179.compute-1.amazonaws.com/Forms/FormResult.html?id=$id";	
		header($url);
	}


	function storeData() {
		global $mysqli, $id, $premium, $p_breed, $p_dob, $p_age, $p_gender, $p_spayneuter, $u_experience, $u_city, $u_zip, $u_home, $u_message, $premium, $premium_calculator;

		$statement = "INSERT INTO users (id, premium, pet_breed, pet_dob, pet_age, pet_gender, pet_spayneuter, user_experience, user_city, user_zip, user_home, user_message) 
		VALUES ('$id', '$premium', '$p_breed', '$p_dob', '$p_age', '$p_gender', '$p_spayneuter', '$u_experience', '$u_city', '$u_zip', '$u_home', '$u_message')";	

		if(mysqli_query($mysqli, $statement)) {
			print 'Hello!, it worked! (maybe)';
		}else{
			print $mysqli->error; //show mysql error if any
		}
	}

	echo "$id<br>";
	calculatePremium();
    //storeInDB();
	returnPremiumPage();
	storeData();
	mysqli_close($mysqli);
}


?>
