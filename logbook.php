<?php
session_start();

// This script is used add record in the logbook
require_once( './db/connexion.php' );
require_once( 'session.php' );

generateJS( 7, 17, 4, 12 );


// If the session id passed in URL parameter is valid, verify if actvity and userid URL parameter are not null and the add record into logbook table
if( $_GET['sessionid'] != null && sessionExist( $_GET['sessionid'] ) ) {
	if( !( $_GET['activity'] == null ) && !( $_GET['userid'] ) ){
		$userid = $_GET['userid'];
		$time = time();
		$year = date( 'y', $time );
		$month = date( 'm', $time );
		$day = date( 'd', $time );
		$hour = date( 'G', $time );
		$minute = date( 'i', $time );
		$sql = "INSERT INTO git_logbook ( userid, year, month, day, hour, minute, activity ) VALUES ( " . $userid . ", " . $year . ", " . $month . ", " . $day . ", " . $hour . ", " . $minute . ", ". $_GET['activity'] . " )";
//		echo $sql . "<br>";
		if ( executeSQL( $sql ) == true ) {
			echo "OK";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}else if( $_GET['activity'] == null ){
		echo '<br>unavailable userid parameter';
	}else if( $_GET['userid'] == null ){
		echo '<br>unavailable userid parameter';
	}
} else {
	echo '<br>Session unavailable';
}


function generateJS( $userid, $year, $month, $day ){
	$sql = "SELECT * FROM git_logbook WHERE userid = " . $userid . " AND year = " . $year . " AND month = " . $month . " AND day = " . $day;
	$result = getSQLResult( $sql );
	$hourArray = array();
	$minuteArray = array();
	$activityArray = array();
	$cssArray = array();

	$PADDING = 1;
	$MIDDLE = 2;
	$BOTTOM = 3;

	$hourArray[0] = 0;
	$minuteArray[0] = 0;
	$activityArray[0] = 2;
	$hourArray[1] = 0;
	$minuteArray[1] = 0;
	$activityArray[1] = 0;
	$hourArray[2] = 0;
	$minuteArray[2] = 0;
	$activityArray[2] = 2;
	$hourArray[3] = 0;
	$minuteArray[3] = 0;
	$activityArray[3] = 1;
	$hourArray[4] = 0;
	$minuteArray[4] = 0;
	$activityArray[4] = 3;
	
	$actualSection = 1;
	
	$counter = 0;
	$arrayCounter = count( $hourArray );
	while( $counter < $arrayCounter ){
		$previousActivity = $activityArray[$counter - 1];
		$actualActivity = $activityArray[$counter];
		$actualHour = $hourArray[$counter];
		$actualMinute = $minuteArray[$counter];
		if( $counter > 0 ){
			$activityCount = $actualActivity - $previousActivity;
			//  If the activity has change to higher value, print a line down into the grid
			if( $activityCount > 0 ){
				echo generateCSS( $previousActivity, $MIDDLE, $actualHour, $actualMinute ) . "<br>";
				array_push($cssArray, generateCSS( $previousActivity, $MIDDLE, $actualHour, $actualMinute ));
				for( $activityCounter = 0; $activityCounter < $activityCount;   ){
					echo generateCSS( $previousActivity + $activityCounter, $BOTTOM, $actualHour, $actualMinute ) . "<br>";
					array_push($cssArray, generateCSS( $previousActivity + $activityCounter, $BOTTOM, $actualHour, $actualMinute ));
					$activityCounter++;
					echo generateCSS( $previousActivity + $activityCounter, $PADDING, $actualHour, $actualMinute ) . "<br>";
					array_push($cssArray, generateCSS( $previousActivity + $activityCounter, $PADDING, $actualHour, $actualMinute ));
					echo generateCSS( $previousActivity + $activityCounter, $MIDDLE, $actualHour, $actualMinute ) . "<br>";
					array_push($cssArray, generateCSS( $previousActivity + $activityCounter, $MIDDLE, $actualHour, $actualMinute ));
				}
			}
			$activityCount = $previousActivity - $actualActivity;
			if( $activityCount > 0 ){
//				echo generateCSS( $previousActivity, $MIDDLE, $actualHour, $actualMinute ) . " - 1<br>";
//				array_push($cssArray, generateCSS( $previousActivity, $MIDDLE, $actualHour, $actualMinute ));
				for( $activityCounter = $activityCount; $activityCounter > 0; ){
					echo generateCSS( $previousActivity - $activityCounter, $PADDING, $actualHour, $actualMinute ) . " - 2<br>";
					array_push($cssArray, generateCSS( $previousActivity - $activityCounter, $PADDING, $actualHour, $actualMinute ));
					$activityCounter--;
					echo generateCSS( $previousActivity - $activityCounter, $BOTTOM, $actualHour, $actualMinute ) . " - 3<br>";
					array_push($cssArray, generateCSS( $previousActivity - $activityCounter, $BOTTOM, $actualHour, $actualMinute ));
					echo generateCSS( $previousActivity - $activityCounter, $MIDDLE, $actualHour, $actualMinute ) . " - 4<br>";
					array_push($cssArray, generateCSS( $previousActivity - $activityCounter, $MIDDLE, $actualHour, $actualMinute ));
				}
			}
		}
		$counter++;
		echo '-----------------------------------------' . '<br>';
	}
//	displayArray( $cssArray );
}

function displayArray( $array ){
	$arrayCounter = count( $array );
	$counter = 0;
	while( $counter < $arrayCounter ){
		echo $array[$counter] . '<br>';
		$counter++;
	}
}

function generateCSS( $activity, $section, $hour, $minute ){	
	$OFFDUTTY = 0;
	$SLEEPER = 1;
	$DRIVING = 2;
	$ONDUTY = 3;
	$PADDING = 1;
	$MIDDLE = 2;
	$BOTTOM = 3;
	
	if( $activity == $OFFDUTTY ){
		$cssActivity = 'offduty';
	}else if( $activity == $SLEEPER ){
		$cssActivity = 'sleeper';
	}else if( $activity == $DRIVING ){
		$cssActivity = 'driving';
	}else if( $activity == $ONDUTY ){
		$cssActivity = 'onduty';
	}
	if( $section == $PADDING ){
		$cssSection = 'padding';
	}else if( $section == $MIDDLE ){
		$cssSection = 'middle';
	}else if( $section == $BOTTOM ){
		$cssSection = 'bottom';
	}
	if( $hour < 10 ){
		$cssHour = '0' . $hour . 'h';
	}else{
		$cssHour = $hour . 'h';
	}
	if( $minute < 10 ){
		$cssMinute = '0' . $minute . 'm';
	}else{
		$cssMinute = $minute . 'm';
	}
	// #offduty #00h #padding #00m
	return '#' . $cssActivity . ' #' . $cssHour . ' #' . $cssSection . ' #' . $cssMinute;
}

?>