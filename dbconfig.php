<?php
	$host = "localhost";
	$db_user = "root";
	$db_password = "";
	$db_name = "connectionus";

	mysqli_report(MYSQLI_REPORT_STRICT);
	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	$_SESSION['connection'] = $connection;
?>