<?php 
	require_once("./header.php");
	session_start();
	$query = "DELETE FROM `groups`
			   WHERE `Group_id` = '{$_GET["gid"]}'";
	$delete =  delete($query);
	header('Location: ../create_group.php');
?>