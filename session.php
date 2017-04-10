<?php

require_once( './db/connexion.php' );

function sessionExist( $session ){
	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
	$sql = "SELECT * FROM git_session WHERE id = " . $session;
	$result = mysqli_query($connection, $sql) or die("Impossible de se connecter : " . mysql_error());
	$array = array();
	while( $row=mysqli_fetch_assoc($result) ){
		$array[] = $row['id'];
		return true;
	}
	return false;
}

function generateSessionId(){
	$sessionid = time();
	return $sessionid;
}

?>