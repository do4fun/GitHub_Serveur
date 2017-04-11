<?php
// This script is used add record in the logbook

require_once( './db/connexion.php' );
require_once( 'session.php' );
// If the session passed in URL parameter is valid, verify if actvity and userid URL parameter are not null and the add record into logbook table
if( sessionExist($_GET['sessionid'])) {
	if( !($_GET['activity'] == null) && !($_GET['userid'])){
		$userid = $_GET['userid'];
		$time = time();
		$year = date('y', $time);
		$month = date('m', $time);
		$day = date('d', $time);
		$hour = date('G', $time);
		$minute = date('i', $time);
		$sql = "INSERT INTO git_logbook (userid, year, month, day, hour, minute, activity) VALUES (" . $userid . ", " . $year . ", " . $month . ", " . $day . ", " . $hour . ", " . $minute . ", ". $_GET['activity'] . " )";
		// echo $sql . "<br>";
		
		$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
		if (mysqli_query($connection, $sql) === TRUE) {
			echo "OK";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close();
	}else if($_GET['activity'] == null){
		echo 'unavailable userid parameter';
	}else if($_GET['userid'] == null){
		echo 'unavailable userid parameter';
	}
} else {
	echo 'Session unavailable';
}

?>