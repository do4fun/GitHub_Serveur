<?php

    $connection = mysqli_connect('127.0.0.1', 'root', '', 'github') or die("Error " . mysqli_error($connection));
    $sql = "SELECT * FROM git_users";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
    $emparray = array();
    while($row =mysqli_fetch_assoc($result)){
        $emparray[] = $row;
    }
    echo json_encode($emparray);
    mysqli_close($connection);

?>