<?php  

session_start();

// Connect to databse to fetch group names
$db = new mysqli();
$db->connect("localhost","root","budget_123","moneycontribution");
$user_name = "SELECT user_profile_required.Name FROM `user_profile_required` WHERE user_profile_required.Upr_id = '{$_SESSION["loginid"]}'";
$user_name = $db->query($user_name);
$user_name = $user_name->fetch_array();
$grp_id = "SELECT * FROM `groups` WHERE `Grpname`='{$_POST["grp_name"]}'";
$grp_id = $db->query($grp_id);
$grp_id = $grp_id->fetch_array();
$select = "SELECT
		   	user_profile_required.Name,user_profile_required.Upr_id 
		   FROM `user_profile_required` INNER JOIN `friends_added`
		   WHERE '{$grp_id["Grp_crtd_by"]}' = '{$_SESSION["loginid"]}'
		   AND friends_added.Grpname_id = '{$grp_id["Group_id"]}' 
		   AND friends_added.Friends_id = user_profile_required.Upr_id";
$select = $db->query($select); 
$count_check = $select->num_rows;

while ($count_check > 0) {
	$friends_check[] = $select->fetch_assoc();
	$count_check--;
}

$friends_array = json_encode($friends_check);
echo ($friends_array);

$db->close();
?>

