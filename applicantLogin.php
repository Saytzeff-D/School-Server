<?php 
	require 'config.php';
	$sql = "SELECT applicant_id, surname FROM applicant";
	$queryMySql = $connect->query($sql);
	echo json_encode($queryMySql->fetch_all(MYSQLI_ASSOC));
 ?>