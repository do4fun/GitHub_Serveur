<?php

define('HOST', 'sql208.byethost18.com');
define('USER', 'b18_19058939');
define('PASS', 'congobongo');
define('DB', 'b18_19058939_DB');
/*
function getJSONFromSQL( $sql ){
	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
	$result = mysqli_query($connection, $sql);
	$array = array();
//	echo $sql . "<br>";
	while($row=mysqli_fetch_assoc($result)){
	// if the query return a result(s) a JSON result is build from data(s) and session variable is set with user type.
		$array[] = $row;
	}
	$_SESSION['counter'] = count($array);
	mysqli_close($connection);
	return json_encode($array);
}

function getJSONFromSQLForColumn( $sql, $column ){
	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
	$result = mysqli_query($connection, $sql);
	$array = array();
//	echo $sql . "<br>";
	while($row=mysqli_fetch_assoc($result)){
// 		if the query return a result(s) a JSON result is build from data(s) and session variable is set with user type.
		$array[] = $row[$column];
	}
	$_SESSION['counter'] = count($row);
	mysqli_close($connection);
	return json_encode($array);
}

function getSingleRecordFromSQLForColumn( $sql, $column ){
	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
	$result = mysqli_query($connection, $sql);
	//	echo $sql . "<br>";
	while($row=mysqli_fetch_assoc($result)){
// 		if the query return a result(s) a JSON result is build from data(s) and session variable is set with user type.
		return $row[$column];
	}
	return "NOK";
}
*/

function executeSQL( $sql ){
	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
//	echo $sql . "<br>";
	if( mysqli_query($connection, $sql) === TRUE ){
		return true;
	}else {
		echo "Error: " . $sql . "<br>" . mysqli_error($connection);
		return false;
	}
}

function getSQLResult( $sql ){
	$connection = mysqli_connect(HOST, USER, PASS, DB) or die("Error " . mysqli_error($connection));
	return mysqli_query($connection, $sql);
}

function getJSONFormat( $result ){
	$array = array();
//	echo $sql . "<br>";
	mysqli_data_seek($result, 0);
	while($row=mysqli_fetch_assoc($result)){
// if the query return a result(s) a JSON result is build from data(s) and session variable is set with user type.
		$array[] = $row;
	}
	$_SESSION['counter'] = count($array);
	return json_encode($array);
}

function getJSONFormatForColumn($result, $column){
	$array = array();
	//	echo $sql . "<br>";
	mysqli_data_seek($result, 0);
	while($row=mysqli_fetch_assoc($result)){
//  if the query return a result(s) a JSON result is build from data(s) and session variable is set with user type.
		$array[] = $row[$column];
	}
	$_SESSION['counter'] = count($array);
	return json_encode($array);
}

function rowCounterOf( $result ){
	$array = array();
	mysqli_data_seek($result, 0);
	while($row=mysqli_fetch_assoc($result)){
//  if the query return a result(s) a JSON result is build from data(s) and session variable is set with user type.
		$array[] = $row;
	}
	return count($array);
}

function getSingleRecordForColumn($result, $column){
	mysqli_data_seek($result, 0);
	while($row=mysqli_fetch_assoc($result)){
// 	if the query return a result(s) a JSON result is build from data(s) and session variable is set with user type.
		return $row[$column];
	}
	return "NOK";
}

?>