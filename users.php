<?php
// This script is used to verify if user session exist then extract which user type he is
	require_once( './db/connexion.php' );
	require_once( 'session.php' );
	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
	
	if( !($_GET['sessionid'] == null) && sessionExist( $_GET['sessionid'] ) ){
		// Verify if the isuser passed in parameter in URL is a valid user id and is active
		if( !($_GET['isuser'] == null )){
			$sql = "SELECT * FROM git_users WHERE active = 1 and id = " . $_GET['isuser'];
		// Verify if the isdispatch passed in parameter in URL is a valid dispatch id and is active
		} else if( !($_GET['isdispatch'] == null )){
			$sql = "SELECT * FROM git_users WHERE usertype = '1' AND id = " . $_GET['isdispatch'];
		// Return all active drivers linked for a dispatch id passed in parameter in URL
		}else if( !($_GET['getdriveridof'] == null) ) {
			$sql = "SELECT d.userid as id, u.usertype as usertype FROM git_users u, git_dispatch d WHERE u.active = 1 AND d.active = 1 AND d.dispatchid = u.id AND u.usertype = 1 AND u.id = " . $_GET['getdriveridof'];
	    }
		// Execute SQL Query
	    $result = mysqli_query($connection, $sql);
	    $array = array();
//	    echo $sql . "<br>";
	    while($row=mysqli_fetch_assoc($result)){
			// if the query return a result(s) a JSON result is build from data(s) and session variable is set with user type.
	    	$array[] = $row['id'];
	    	if($row['usertype'] == '1' ){
	    		$_SESSION['usertype'] = "dispatch";
	    	}else{
	    		$_SESSION['usertype'] = "driver";
	    	}
	    }
//	    echo $_SESSION['usertype'] . "<br>";
	    echo json_encode($array);
	}else{
		echo 'connection fail';
	}

    mysqli_close($connection);

?>