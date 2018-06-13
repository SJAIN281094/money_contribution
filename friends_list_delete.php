<?php 
	require_once("./header.php");
	session_start();
	$query = "DELETE FROM `friends_added`
			   WHERE `Friends_id` = '{$_GET["id"]}'
			   AND `Grpname_id`= '{$_GET["gid"]}'";
	$delete =  delete($query);
	header('Location: ../friends_list.php?status="Friend deleted"');
?>