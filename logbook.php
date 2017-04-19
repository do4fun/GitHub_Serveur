<?php
session_start();

// This script is used add record in the logbook
require_once( './db/connexion.php' );
require_once( 'session.php' );

generateJS( 7, 17, 4, 12 );

/*
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

 */
function generateJS( $userid, $year, $month, $day ){
	/*	$sql = "SELECT * FROM git_logbook WHERE userid = " . $userid . " AND year = " . $year . " AND month = " . $month . " AND day = " . $day;
	 $result = getSQLResult( $sql );
	 */	$hourArray = array();
	$minuteArray = array();
	$activityArray = array();
	$cssArrayActivities = array();
	$cssArrayTime = array();

	$EMPTY = 1;
	$PADDING = 2;
	$MIDDLE = 3;
	$BOTTOM = 4;

	//   Données de test pour les changements d'activitées.
	$hourArray[0] = 0;
	$minuteArray[0] = 0;
	$activityArray[0] = 2;
	$hourArray[1] = 5;
	$minuteArray[1] = 15;
	$activityArray[1] = 1;
	$hourArray[2] = 7;
	$minuteArray[2] = 30;
	$activityArray[2] = 3;
	$hourArray[3] = 10;
	$minuteArray[3] = 45;
	$activityArray[3] = 4;
	$hourArray[4] = 19;
	$minuteArray[4] = 0;
	$activityArray[4] = 1;

	$actualActivity = current($activityArray);
	while($actualActivity != null  ){
		$previousActivity = current($activityArray);
		$previousMinute = current($minuteArray);
		$previousHour = current($hourArray);
		$actualActivity = next($activityArray);
		$actualMinute = next($minuteArray);
		$actualHour = next($hourArray);

		$activityCount = $previousActivity - $actualActivity;
		//  If the activity has change to higher value, print a line UP into the grid
		if( $activityCount >= 1 && $previousActivity > 0 && $actualActivity > 0 ){
			array_push($cssArrayActivities, generateCSS( $previousActivity, $PADDING, $actualHour, $actualMinute ));
			array_push($cssArrayActivities, generateCSS( $previousActivity, $EMPTY, $actualHour, $actualMinute ));
			array_push($cssArrayActivities, generateCSS( $actualActivity, $BOTTOM, $actualHour, $actualMinute ));
			array_push($cssArrayActivities, generateCSS( $actualActivity, $MIDDLE, $actualHour, $actualMinute ));
			for( $activityCounter = 1; $activityCount > $activityCounter; $activityCounter++){
				array_push($cssArrayActivities, generateCSS( $actualActivity + $activityCounter, $EMPTY, $actualHour, $actualMinute ));
				array_push($cssArrayActivities, generateCSS( $actualActivity + $activityCounter, $PADDING, $actualHour, $actualMinute ));
				array_push($cssArrayActivities, generateCSS( $actualActivity + $activityCounter, $MIDDLE, $actualHour, $actualMinute ));
				array_push($cssArrayActivities, generateCSS( $actualActivity + $activityCounter, $BOTTOM, $actualHour, $actualMinute ));
			}
		}
		//  If the activity has change to higher value, print a line DOWN into the grid
		$activityCount = $actualActivity - $previousActivity;
		if( $activityCount >= 1 ){
			array_push($cssArrayActivities, generateCSS( $previousActivity, $MIDDLE, $actualHour, $actualMinute ));
			array_push($cssArrayActivities, generateCSS( $previousActivity, $BOTTOM, $actualHour, $actualMinute ));
			array_push($cssArrayActivities, generateCSS( $actualActivity, $EMPTY, $actualHour, $actualMinute ));
			array_push($cssArrayActivities, generateCSS( $actualActivity, $PADDING, $actualHour, $actualMinute ));
			for( $activityCounter = 1; $activityCount > $activityCounter; $activityCounter++){
				array_push($cssArrayActivities, generateCSS( $previousActivity + $activityCounter, $EMPTY, $actualHour, $actualMinute ));
				array_push($cssArrayActivities, generateCSS( $previousActivity + $activityCounter, $PADDING, $actualHour, $actualMinute ));
				array_push($cssArrayActivities, generateCSS( $previousActivity + $activityCounter, $MIDDLE, $actualHour, $actualMinute ));
				array_push($cssArrayActivities, generateCSS( $previousActivity + $activityCounter, $BOTTOM, $actualHour, $actualMinute ));
			}
		}
		//  If minute is not set to 0, fill the top line of each quarter hour BEFORE each activities
		$previousMinuteGap = 60 - $previousMinute;
		if( $previousMinuteGap < 60 ){
			$previousMinuteStep = $previousMinute / 15;
			for( $previousMinuteStepCounter = 1; $previousMinuteStepCounter <= $previousMinuteStep; $previousMinuteStepCounter++ ){
				prev($activityArray);
				$beforePreviousActivity = prev($activityArray);
				array_push($cssArrayTime, generateCSS( $beforePreviousActivity, $MIDDLE, $previousHour, $previousMinute - ($previousMinuteStepCounter * 15 )));
				next($activityArray);next($activityArray);
			}
		}


		//  If minute is not set to 0, fill the top line of each quarter hour AFTER each activities
		$previousMinuteGap = 60 - $previousMinute;
		if( $previousMinuteGap < 60 ){
			$previousMinuteStep = $previousMinuteGap / 15;
			for( $previousMinuteStepCounter = 0; $previousMinuteStepCounter <= $previousMinuteStep; $previousMinuteStepCounter++ ){
				$beforePreviousActivity = prev($activityArray);
				array_push($cssArrayTime, generateCSS( $beforePreviousActivity, $MIDDLE, $previousHour, $previousMinute + ($previousMinuteStepCounter * 15 )));
				next($activityArray);
			}
		}

		//  Fill the top line of each hour BETWEEN each activities
		$hourCount = $actualHour - $previousHour;
		if( $hourCount > 0 ){
			for( $hourCounter = 1; $hourCounter < $hourCount; $hourCounter++ ){
				array_push($cssArrayTime, generateCSS( $previousActivity, $MIDDLE, $previousHour + $hourCounter, 0));
				array_push($cssArrayTime, generateCSS( $previousActivity, $MIDDLE, $previousHour + $hourCounter, 15 ));
				array_push($cssArrayTime, generateCSS( $previousActivity, $MIDDLE, $previousHour + $hourCounter, 30 ));
				array_push($cssArrayTime, generateCSS( $previousActivity, $MIDDLE, $previousHour + $hourCounter, 45 ));
				//				}
			}
		}
	}
//	generateLeftBoldCSS($cssArrayActivities);
//	generateTopBoldCSS($cssArrayTime);
	addjQueryToHTMLContent( $cssArrayActivities, $cssArrayTime );
//	displayArray( $cssArrayActivities );
//	echo '-----------------------------------------' . '<br>';
//	displayArray( $cssArrayTime );
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
	$OFFDUTTY = 1;
	$SLEEPER = 2;
	$DRIVING = 3;
	$ONDUTY = 4;
	$EMPTY = 1;
	$PADDING = 2;
	$MIDDLE = 3;
	$BOTTOM = 4;

	if( $activity == $OFFDUTTY ){
		$cssActivity = 'offduty';
	}else if( $activity == $SLEEPER ){
		$cssActivity = 'sleeper';
	}else if( $activity == $DRIVING ){
		$cssActivity = 'driving';
	}else if( $activity == $ONDUTY ){
		$cssActivity = 'onduty';
	}
	if( $section == $EMPTY ){
		$cssSection = 'empty';
	}else if( $section == $PADDING ){
		$cssSection = 'padding';
	}else if( $section == $MIDDLE ){
		$cssSection = 'middle';
	}else if( $section == $BOTTOM ){
		$cssSection = 'bottom';
	}

	$cssHour = $hour . 'h';

	if( $minute < 10 ){
		$cssMinute = '0' . $minute . 'm';
	}else{
		$cssMinute = $minute . 'm';
	}
	// #offduty #00h #padding #00m
	return '#' . $cssActivity . ' #' . $cssHour . ' #' . $cssSection . ' #' . $cssMinute;
}

function generateLeftBoldCSS( $classArray ){
	$jQueryLeftBold = implode(", ", $classArray);
	echo '$(\'' . $jQueryLeftBold . '\').addClass(\'template_size left_bold_template\');';
	//	return '$(\'' . $jQueryLeftBold . '\').addClass(\'template_size left_bold_template\')';

}

function generateTopBoldCSS( $classArray ){
	$jQueryLeftBold = implode(", ", $classArray);
	echo '$(\'' . $jQueryLeftBold . '\').addClass(\'template_size top_bold_template\');';
	//	return '$(\'' . $jQueryLeftBold . '\').addClass(\'template_size top_bold_template\')';
}

function addjQueryToHTMLContent( $cssArrayActivities, $cssArrayTime ){
	echo '<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" type="text/css" href="css/fichejournaliere.css" /><script src="js/jquery-3.2.0.js"></script><script src="js/constructionGrid.js"></script>';
	echo '<script>jQuery(document).ready(function(){';
	generateLeftBoldCSS($cssArrayActivities);
	generateTopBoldCSS($cssArrayTime);
	echo '	});</script>';
	echo '</head><body  onload="iterationGrid()"><div id="idGrid"  style="margin-top: 5%"></div></body></html>';
	//  . generateLeftBoldCSS($arrayLeftBold) .

}

?>




