<?php

require_once( './db/connexion.php' );
require_once( 'session.php' );
	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
	
	if( !($_GET['sessionid'] == null) && sessionExist( $_GET['sessionid'] ) ){
		if( !($_GET['isuser'] == null )){
			$sql = "SELECT * FROM git_users WHERE id = " . $_GET['isuser'];
		} else if( !($_GET['isdispatch'] == null )){
			$sql = "SELECT * FROM git_users WHERE usertype = '1' AND id = " . $_GET['isdispatch'];
		}else if( !($_GET['getdriveridof'] == null) ) {
			$sql = "SELECT d.userid as id FROM git_users u, git_dispatch d WHERE d.dispatchid = u.id AND u.usertype = 1 AND u.id = " . $_GET['getdriveridof'];
		}else{
			$sql = "SELECT * FROM git_users WHERE id = " . $_GET['id'];
	    }
	    $result = mysqli_query($connection, $sql);
	    $array = array();
	    while($row=mysqli_fetch_assoc($result)){
	    	$array[] = $row['id'];
	    }
	    echo json_encode($array);
	}else{
		echo 'connection fail';
	}

    mysqli_close($connection);

?>