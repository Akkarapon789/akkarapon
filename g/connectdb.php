<meta charset="utf-8">

<?php
	$host = "localhost";
	$user = "root";
	$pwd = "";
	$dbaname = "msu";
	$conn = mysqli_connect($host,$user,$pwd,$dbaname);
	mysqli_query($conn,"SET NAMES utf8");
?>