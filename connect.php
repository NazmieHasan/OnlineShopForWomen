<?php

$conn= mysqli_connect($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);



if (mysqli_connect_error()) {
    die("Database connection failed: " . mysqli_connect_error());
} else {
	// echo 'connected';
}

?>