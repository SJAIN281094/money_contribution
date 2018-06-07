<?php  

session_start();
$db = new mysqli();
$db->connect("localhost","root","budget_123","moneycontribution");
$select = "SELECT user_profile_required.Name FROM `user_profile_required` INNER JOIN `friends_added` WHERE friends_added.User = '{$_SESSION["loginid"]}' AND friends_added.Grpname = '{$_POST["grp_name"]}' AND user_profile_required.Upr_id = friends_added.Friends";
$select = $db->query($select); 
$count_check = $select->num_rows;

while($count_check>0){
$friends_check[] = $select->fetch_assoc();
$count_check--;
}

$friends_array = json_encode($friends_check);
echo ($friends_array);

$db->close();
?>

