<?php 
	session_start();
	$db = new mysqli();
	$db->connect("localhost","root","budget_123","moneycontribution");
	$delete = "DELETE FROM `friends_added`
			   WHERE `Friends_id` = '{$_GET["id"]}'
			   AND `Grpname_id`= '{$_GET["gid"]}'";
	$db->query($delete);
	header('Location: ../friends_list.php');
	$db->close();
?>