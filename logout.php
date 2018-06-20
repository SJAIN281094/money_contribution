<?php 
	session_start();
	if(isset($_SESSION["loginid"]) && isset($_SESSION["security"])){
?>

<?php 
	session_start();
	$_SESSION = array();
	setcookie("PHPSESSID","",time()-1,"./");
	session_destroy();
	header("Location: ./login.php");
 ?>

 <?php 
	}
	else{
		header("Location: login.php");
	}
?>