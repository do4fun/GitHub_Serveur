<?php
session_start();
// This script is used to verify if user session exist then extract which user type he is
	require_once( './db/connexion.php' );
	require_once( 'session.php' );
//	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
	if(( $_GET['sessionid'] != null) && sessionExist( $_GET['sessionid'] ) ){
		// Verify type of user passed in parameter in URL is a valid user id and is active
		if( $_GET['usertype'] != null ){
			if( $_GET['userid'] != null ){
				$sql = "SELECT * FROM git_users WHERE active = 1 and id = " . $_GET['userid'];
			} 
		    
		    $result = getSQLResult($sql);
		    if(rowCounterOf( $result ) >= 1){
		    	if(getSingleRecordForColumn( $result, 'usertype' ) == '1' ){
		    		$_SESSION['usertype'] = "dispatch";
		    	}else{
		    		$_SESSION['usertype'] = "driver";
		    	}
		    	echo getJSONFormat( $result ) . "<br>";
		    }
		// Update driver's data from user id, username and password passed in URL parameters
		}else if( $_GET['updatedriver'] != null && $_GET['userid'] != null){
	    	if( $_GET['username'] != null ){
	    		$sql = "UPDATE git_users SET username = " . $_GET['username'] . " WHERE id = " . $_GET['userid'] ;
	    	} else if( $_GET['password'] != null ){
	    		$sql = "UPDATE git_users SET password = " . $_GET['username'] . " WHERE id = " . $_GET['userid'] ;
	    	} 
	    	if (executeSQL($sql) == true) {
	    		echo "OK";
	    	} else {
	    		echo "Error: " . $sql . "<br>" . $conn->error;
	    	}
	    }else{
	    	echo 'userid is required';
	    }
	}else {
		echo 'Unavailable session id for this user ';
	}

	
	/*
	 echo getJSONFormat( $result ) . '<br>';
	 echo getJSONFormatForColumn( $result, 'usertype' ) . '<br>';
	 echo getSingleRecordForColumn( $result, 'usertype' ) . '<br>';
	 echo rowCounterOf( $result );
	 */
	
?>