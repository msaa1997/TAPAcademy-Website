<?php

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

	
	$id = $_GET['id'];

	$query = "SELECT premium FROM premiums WHERE id='$id'";
	$result = $mysqli->query($query);
	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){
		echo $row['premium'];
		}
	}
	$mysqli->close();
?>
