<?php 
	session_start();
	if(isset($_SESSION["loginid"]) && isset($_SESSION["security"])){
?>

<?php 
	require_once("connect_db.php"); 
	$query = "DELETE FROM `groups`
			   WHERE `Group_id` = '{$_GET["gid"]}'";
	$delete =  delete($query);
	header('Location: ../create_group.php');
?>

<?php 
	}
	else{
		header("Location: login.php");
	}
?>