
<?php 
$db = new mysqli();
$db->connect("localhost","root","budget_123","moneycontribution");
$select = "SELECT * FROM `friends_added` WHERE  `User`= '{$_COOKIE["loginid"]}' AND `Friends`='{$_GET["id"]}'";
$select = $db->query($select);
$check = $select->fetch_array();
if($check){
	$delete = "DELETE FROM `friends_added` WHERE `Friends` = '{$_GET["id"]}'";
	$db->query($delete);
	header('Location: ../friends_list.php');
}
else{
	echo "FAKE USER";
}
?>