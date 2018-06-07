<?php
//-- Header --
require_once("./header.php");
$db = new mysqli();
$db->connect("localhost","root","budget_123","moneycontribution");
if(!empty($_POST["mc_group_name"]))
{
require_once("./connect_db.php");
if(isset($_POST["mc_group_name"]))
{
session_start();
$insert = "INSERT INTO `groups` SET `Grpname`='{$_POST["mc_group_name"]}',`Grp_crtd_by`='{$_SESSION['loginid']}'";
$insert = $db->query($insert);
}
$db->close();
}
else{
	echo "Enter group name";
}
?>

<form action="./create_group.php" method="POST">
<input class="mc_group_name" type="text" name="mc_group_name">
<input type="submit" name="add_group_name" value="Add Group">		
</form>



