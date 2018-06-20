<?php 
   	session_start();
	if(isset($_SESSION["loginid"]) && isset($_SESSION["security"])){
 ?>

<?php
	// Include header 
	require_once("header.php");
	$group_message = "";
?>

<!-- Take all $_POST[] values in variables -->
<?php  
	$group_name = isset($_POST["group_name"]) ? $_POST["group_name"] : "";
	$add_group_name = isset($_POST["add_group_name"]) ? $_POST["add_group_name"] : "";
?>

<!-- Group name validation -->
<?php 
	$group_name_pattern = "/[a-zA-Z0-9]+/"; 
	preg_match_all($group_name_pattern,$group_name,$charc);
	$charc = implode(" ",$charc[0]);
 ?>

<!-- Connect to database for insert group names -->
<?php

	if (!empty($add_group_name)) { 
		if (!empty($group_name)) {
			if ($charc == $group_name) {

				$query = "SELECT DISTINCT `Grpname`,`Grp_crtd_by`
						  FROM `groups` WHERE `Grpname` = '{$group_name}'
						  AND `Grp_crtd_by`='{$_SESSION['loginid']}'";
				$grp_name = select($query);
				$count_group_name = $grp_name->num_rows;
				if($count_group_name == 0){	
				
				$query = "INSERT INTO `groups` SET `Grpname`='{$group_name}',`Grp_crtd_by`='{$_SESSION['loginid']}'";
				$insert = insert($query);

				// Add user into each group
				$query = "SELECT groups.Group_id FROM `groups` WHERE groups.Grpname = '{$group_name}'";
				$curr_grp_id = select($query);
				$curr_grp_id = $curr_grp_id->fetch_array();

				$query = "SELECT friends_added.Friends_id,friends_added.Grpname_id 
					  FROM `friends_added` WHERE 
					  friends_added.Friends_id = '{$_SESSION["loginid"]}' AND friends_added.Grpname_id = '{$curr_grp_id["Group_id"]}'";
				$user_exist = select($query);
				$count_user_exist =  $user_exist->num_rows;

				if(!$count_user_exist) {
					$query = "INSERT INTO `friends_added` SET `Friends_id`='{$_SESSION["loginid"]}',`Grpname_id`='{$curr_grp_id["Group_id"]}'";
					insert($query);	
				}

				}
				else{
					$group_message = "Group already exist !!";
				}
			}
			else{

				$group_message = "Invalid group name (No special character)";
			}
		}
		else{
			 $group_message = "Enter group name !!";
		}
	}	
?>

<!-- Add group form section -->
<section id="group_section_form">
	<form class = "group_form" action="create_group.php" method="POST">
		<input class="mc_group_name" type="text" name="group_name" placeholder="Enter group name">
		<input type="submit" name="add_group_name" value="Add Group"><span><?php echo $group_message ?></span>		
	</form>
</section>

<!-- Group details section-->
<section id="group_section_display">
	
	<!--Fetch friends name with respect to uid-->
	<?php
		$query = "SELECT `Grpname`,`Group_id`,`Grp_crtd_by` 
				  FROM `groups`
				  WHERE `Grp_crtd_by`='{$_SESSION["loginid"]}'";
		$grp_select = select($query);
		$count_group = $grp_select->num_rows;
	?>
	
	<?php  	
		while($count_group>0){
			$grp_name = $grp_select->fetch_array();
	?> 

	<!-- Place friend's name in group -->
	<div class="mc_friends_grp">
		<!--CREATE GROUPS NAMES -->
 		<div class="mc_grp_name">			 	
			<label>Group Name:</label>
	 		<?php 
	 		echo ($grp_name['Grpname']);
	 		?>
	 		 <a class="mc_groups_delete" href="groups_delete.php/?gid=<?php echo ($grp_name["Group_id"]) ?>">Delete</a>
	 		<div class="mc_friends_head">Friends:</div>
		</div>
			 	
	<!--Add friend's name in group and display it -->
	<?php
		$query = "SELECT user_profile_required.Name
				  FROM `user_profile_required`
				  INNER JOIN `friends_added` ON user_profile_required.Upr_id = friends_added.Friends_id
				  WHERE friends_added.Grpname_id = '{$grp_name["Group_id"]}' 
				  AND '{$grp_name["Grp_crtd_by"]}' = '{$_SESSION["loginid"]}'";
		$grp_friends = select($query);
		$count =  $grp_friends->num_rows;

		if(!$count==0){
			while($count>0){
				$friends_show = $grp_friends->fetch_array();
				?>
				
				<span> <?php echo ($friends_show['Name']); ?> </span>

				<?php
				$count--;
			}
		}
		else{
			echo ("No friend added");
		}
		$count_group--;
		}
	?>
	</div>	
</section>

<?php 
	}
	else{
		header("Location: login.php");
	}
?>