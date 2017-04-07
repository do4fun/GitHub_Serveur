<?php
//	$connection = mysqli_connect('127.0.0.1', 'root', '', 'github') or die("Error " . mysqli_error($connection));
	$connection = mysqli_connect('sql208.byethost18.com', 'b18_19058939', 'congobongo', 'b18_19058939_DB') or die("Error " . mysqli_error($connection));

	if( !($_GET['isuser'] == null )){
		$sql = "SELECT * FROM git_users WHERE id = " . $_GET['isuser'];
//		echo $sql . "<br>";
	    $result = mysqli_query($connection, $sql);
	    $array = array();
	    while($row=mysqli_fetch_assoc($result)){
	        $array[] = $row['id'];
	    }
	    echo json_encode($array);
	} else if( !($_GET['isdispatch'] == null )){
		$sql = "SELECT * FROM git_users WHERE usertype = '1' AND id = " . $_GET['isdispatch'];
//		echo $sql . "<br>";
	    $result = mysqli_query($connection, $sql);
	    $array = array();
	    while($row=mysqli_fetch_assoc($result)){
	        $array[] = $row['id'];
	    }
	    echo json_encode($array);
	}else if( !($_GET['getdriveridof'] == null) ) {
		$sql = "SELECT d.userid as id FROM git_users u, git_dispatch d WHERE d.dispatchid = u.id AND u.usertype = 1 AND u.id = " . $_GET['getdriveridof'];
//		echo $sql . "<br>";
	    $result = mysqli_query($connection, $sql);
	    $array = array();
	    while($row=mysqli_fetch_assoc($result)){
	        $array[] = $row['id'];
	    }
	    echo json_encode($array);
	}else{
		$sql = "SELECT * FROM git_users WHERE id = " . $_GET['id'];
	    $result = mysqli_query($connection, $sql);
	    $emparray = array();
	    while($row=mysqli_fetch_assoc($result)){
	        $emparray[] = $row;
	    }
	
	    echo json_encode($emparray);
    }
	    mysqli_close($connection);
?>