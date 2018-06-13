<?php 
    session_start();
	if(isset($_SESSION["loginid"]) && isset($_SESSION["security"])){
?>

<?php  
	// Connect to databse to fetch group names
	require_once("connect_db.php"); 
	$query = "SELECT user_profile_required.Name FROM `user_profile_required` WHERE user_profile_required.Upr_id = '{$_SESSION["loginid"]}'";
	$user = select($query);
	$user_name = $user->fetch_array();

	$query = "SELECT * FROM `groups` WHERE `Grpname`='{$_POST["grp_name"]}'";
	$grpid = select($query);
	$grp_id = $grpid->fetch_array();

	$query = "SELECT
			   	user_profile_required.Name,user_profile_required.Upr_id 
			   FROM `user_profile_required` INNER JOIN `friends_added`
			   WHERE '{$grp_id["Grp_crtd_by"]}' = '{$_SESSION["loginid"]}'
			   AND friends_added.Grpname_id = '{$grp_id["Group_id"]}' 
			   AND friends_added.Friends_id = user_profile_required.Upr_id";
	$select = select($query); 
	$count_check = $select->num_rows;

	while ($count_check > 0) {
		$friends_check[] = $select->fetch_assoc();
		$count_check--;
	}

	$friends_array = json_encode($friends_check);
	echo ($friends_array);
?>

<?php 
	}
	else{
		header("Location: login.php");
	}
?>