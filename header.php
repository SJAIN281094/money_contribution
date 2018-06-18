<?php 
	if(isset($_SESSION["loginid"]) && isset($_SESSION["security"])){
?>

<?php 
	require_once("connect_db.php"); 
		// Connect to database and run select query
	 	$query = "SELECT user_profile_required.Name,user_profile_required.Title,title.Title_name
	 			  FROM `user_profile_required`
	 			  INNER JOIN `Title` ON user_profile_required.Title = title.Title_id
	 			  WHERE user_profile_required.Upr_id = '{$_SESSION["loginid"]}'";
	 	$select = select($query);
	 	$username = $select->fetch(PDO::FETCH_ASSOC);
 ?>

<!DOCTYPE html>
<head>
<title>Money Contribution</title>
<body>
	<header id="mc_header">
		<h1 class="mc_heading">MONEY CONTRIBUTION</h1>
		<div class="mc_logo"><a href="login.php"><img src="images/mc_ico.png" alt="mc-logo"></a></div>
		<div class="mc_username">
			<span>Hello: <?php echo $username["Title_name"]." ".$username["Name"] ?></span>
			<div class="mc_options">
				<a class="mc_add_group" href="./create_group.php"><span>Add Group</span></a>
				<a class="mc_add_friends" href="./friends_list.php"><span>Add Friends</span></a>
				<a class="mc_add_expenditure" href="./expenditure.php"><span>Add Expenditure</span></a>
				<a class="mc_passbook" href="passbook.php"><span>Passbook</span></a>
				<a class="mc_passbook" href="profile_update.php"><span> Update Profile </span></a>
				<a class="mc_logout" href="./logout.php"><span>Logout</span></a>
			</div>	
		</div>
	</header>
</body>
</head>
</html>

<?php 
	}
	else{
		header("Location: login.php");
	}
?>