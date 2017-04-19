<?php

session_start();

require_once( './db/connexion.php' );
require_once( 'session.php' );

if( $_GET['sessionid'] != null && $_GET['dispatchid'] != null ){
	if(sessionExist( $_GET['sessionid'] ) ){
		// Return all active drivers linked for a dispatch id passed in parameter in URL
		if( $_GET['getdriveridof'] != null ) {
			$sql = "SELECT d.userid as userid, u.username as usertype, u.firstname as firstname, u.secondname as secondname FROM git_users u, git_dispatch d WHERE u.active = 1 AND u.active = 1 AND d.dispatchid = u.id AND u.usertype = 1 AND u.id = " . $_GET['getdriveridof'];
			echo getJSONFormat(getSQLResult( $sql ));
		// Create driver and link him to a dispatch if all parameters are passed in URL	are not null
		}else if( $_GET['createdriver'] != null ){
			if( $_GET['username'] != null && $_GET['password'] != null && $_GET['usertype'] != null && $_GET['active'] != null ){
				$sql = "INSERT git_users ( username, userpassword, usertype, active ) VALUES ( " . $_GET['username'] . ", " . $_GET['password'] . ", " . $_GET['usertype'] . ", " . $_GET['active'] . ")";
				//  Create user in database
				if (executeSQL($sql) == true) {
					$sql = "SELECT id FROM git_users WHERE username = " . $_GET['username'];
					// Get the user id for the user name passed in parameter in URL
					$driverid = getSingleRecordForColumn( getSQLResult($sql), 'id' );
					$sql = "INSERT git_dispatch ( userid, dispatchid ) VALUES ( " . $driverid . ", " . $_GET['dispatchid'] . ")";
					//  Create link between driver and dispatch
					if (executeSQL($sql) == true) {
						echo "OK";
					}
				}
			}else{
				echo 'NOK';
			}
		// Update user datas for a specific driver linked to a dispatch id
		}else if( $_GET['updatedriver'] != null ){
			if( $_GET['username'] != null ){
				// Update usertype from his username
				if( $_GET['usertype'] != null ){
					$sql = "UPDATE git_users as u JOIN git_dispatch as d ON u.id = d.userid SET u.usertype = " . $_GET['usertype'] . " WHERE u.username = " . $_GET['username'] . " AND d.dispatchid = " . $_GET['dispatchid'];
				// Enable or disable user from his username
				} else if( $_GET['active'] != null ){
					$sql = "UPDATE git_users as u JOIN git_dispatch as d ON u.id = d.userid SET u.active = " . $_GET['active'] . " WHERE u.username = " . $_GET['username'] . " AND d.dispatchid = " . $_GET['dispatchid'];
				}
			}
			if( $_GET['userid'] != null ){
				// Update usertype from his user id
				if( $_GET['usertype'] != null ){
					$sql = "UPDATE git_users as u JOIN git_dispatch as d ON u.id = d.userid SET u.usertype = " . $_GET['usertype'] . " WHERE u.id = " . $_GET['userid'] . " AND d.dispatchid = " . $_GET['dispatchid'];
				// Enable or disable user from his username
				} else if( $_GET['active'] != null ){
					$sql = "UPDATE git_users as u JOIN git_dispatch as d ON u.id = d.userid SET u.active = " . $_GET['active'] . " WHERE u.id = " . $_GET['userid'] . " AND d.dispatchid = " . $_GET['dispatchid'];
				}
			}
			if (executeSQL($sql) == true) {
	    		echo "OK";
	    	} else {
	    		echo "Error: " . $sql . "<br>" . $conn->error;
	    	}
		}	
	}else{
		echo 'Inactive Session';
	}
}
	
		
		
?>