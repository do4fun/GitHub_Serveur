<?php
session_start();

// This script is used add record in the logbook
require_once( './db/connexion.php' );
require_once( 'session.php' );

generateJS( 7, 17, 4, 12 );

// If the session id passed in URL parameter is valid, verify if actvity and userid URL parameter are not null and the add record into logbook table
if( $_GET['sessionid'] != null && sessionExist($_GET['sessionid'])) {
	if( !($_GET['activity'] == null) && !($_GET['userid'])){
		$userid = $_GET['userid'];
		$time = time();
		$year = date('y', $time);
		$month = date('m', $time);
		$day = date('d', $time);
		$hour = date('G', $time);
		$minute = date('i', $time);
		$sql = "INSERT INTO git_logbook (userid, year, month, day, hour, minute, activity) VALUES (" . $userid . ", " . $year . ", " . $month . ", " . $day . ", " . $hour . ", " . $minute . ", ". $_GET['activity'] . " )";
//		echo $sql . "<br>";
		if (executeSQL($sql) == true) {
			echo "OK";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}else if($_GET['activity'] == null){
		echo '<br>unavailable userid parameter';
	}else if($_GET['userid'] == null){
		echo '<br>unavailable userid parameter';
	}
} else {
	echo '<br>Session unavailable';
}

function generateJS( $userid, $year, $month, $day ){
	$sql = "SELECT * FROM git_logbook WHERE userid = " . $userid . " AND year = " . $year . " AND month = " . $month . " AND day = " . $day;
	$result = getSQLResult($sql);
	$hourArray = array();
	$minuteArray = array();
	$activityArray = array();
	$cssArray = array();
	
	$actualHour = 2;
	$actualMinute = 15;
	$actualActivity = 1;
	
	$cssActivity = 0;
	$cssHour = 0;
	$cssSection = 0;
	$cssMinute = 0;
	
	while( $row = mysqli_fetch_assoc($result) ){
		$hourArray[] = $row['hour'];
		$minuteArray[] = $row['minute'];
		$activityArray[] = $row['activity'];
	}
	$counter = 0;
	while( $hourArray[$counter] != null ){
		$actualHour = $hourArray[$counter];
		$actualMinute = $minuteArray[$counter];
		$actualActivity = $activityArray[$counter];
		if($actualMinute < $minuteArray[$counter + 1]){
			
		}
//		if( $actualActivity != )
		$cssActivity = 0;
		$cssHour = 0;
		$cssSection = 0;
		$cssMinute = 0;
		$counter++;
	}
}

?>