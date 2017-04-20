<?php

require_once( './db/connexion.php' );


// This function test if the session id exist and is active and return true if the last access date/time of this session is under 1 day.
function sessionExist( $session ){
	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
	$sql = "SELECT * FROM git_session WHERE id = " . $session . " AND active = 1";
//	echo '$sql - ' . $sql . "<br>";
	$result = mysqli_query($connection, $sql) or die("Impossible de se connecter : " . mysql_error());
	$array = array();
	while( $row=mysqli_fetch_assoc($result) ){
		$date = new DateTime();
		$date->setTimestamp($row['lastaccess'] )->format('Y-m-d H:i:s') . '<br>';
//		echo '$date - ' . $date->format('Y-m-d H:i:s') . "<br>";
		$actualDate = date( 'y-m-d G:i', time() );
//		echo '$actualDate - ' . $actualDate . "<br>";
		$difference = $date->diff(new DateTime($actualDate))->format('%d');
//		echo '$difference - ' . $difference . "<br>";
		if( $difference < 1 ){
//			echo "true<br>";
			return true;
		}else{
//			echo "false<br>";
			return true;
		}
	}
	return false;
}

function generateSessionId(){
	return time();
}

// Update last access column into session table for specific user id passed parameter
function updateLastAccess( $sessionid ){
	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
	$sql = "UPDATE git_session SET lastaccess = " . time(); //. " WHERE sessionid = " . $sessionid ;
	mysqli_query($connection, $sql);	
}

// This script is used to verify if user name and password passed in URL parameter are linked with a active user in the database
if( $_GET['username'] != null && $_GET['passw'] != null ){
	$sql = "SELECT * FROM git_users WHERE username = " . $_GET['username'] . " AND userpassword = " . $_GET['passw'];
	$result = getSingleRecordForColumn(getSQLResult($sql), 'id');
//	echo $sql . "<br>";
	$_SESSION['sessionid'] = generateSessionId();
	$sql = "INSERT INTO git_session (id, userid, active, lastaccess) VALUES ('" . $_SESSION['sessionid'] . "' ," . $result . ", 1, '" . time() . "')";
//		echo $sql . "<br>";
	if (executeSQL( $sql ) === true) {
		$sql = "SELECT id as sessionid, userid FROM git_session WHERE id = " . $_SESSION['sessionid'];
		echo getJSONFormat(getSQLResult($sql));
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}	

?>







