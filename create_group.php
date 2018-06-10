<!-- Include header -->
<?php
	require_once("./header.php");
?>

<!--Connect to database for insert group names-->
<?php
	$db = new mysqli();
	$db->connect("localhost","root","budget_123","moneycontribution");
	if (!empty($_POST["group_name"])) {
		if (isset($_POST["add_group_name"])) {
			$insert = "INSERT INTO `groups` SET `Grpname`='{$_POST["group_name"]}',`Grp_crtd_by`='{$_SESSION['loginid']}'";
			$insert = $db->query($insert);
			$db->close();
		}
	}
?>

<!-- Add group form section -->
<section class"group_section">
	<form action="./create_group.php" method="POST">
		<input class="mc_group_name" type="text" name="group_name" placeholder="Enter group name">
		<input type="submit" name="add_group_name" value="Add Group">		
	</form>
</section>

<!-- Group details section-->
<section>
	
	<?php
		// FETCH FRIENDS NAME WITH RESPECT TO THEIR UID.
		$db = new mysqli();
		$db->connect("localhost","root","budget_123","moneycontribution");
		$grp_select = "SELECT DISTINCT `Grpname`,`Group_id`,`Grp_crtd_by` FROM `groups` WHERE `Grp_crtd_by`='{$_SESSION["loginid"]}'";
		$grp_select = $db->query($grp_select);
		$count_group = $grp_select->num_rows;
	?>
	
	<?php  	
		while($count_group>0){
			$grp_name = $grp_select->fetch_array();
	?> 

			<!-- Place friends in group -->
			<div class="mc_friends_grp">
				<!--CREATE GROUPS NAMES -->
		 		<div class="mc_grp_name">			 	
					<span>Group Name:</span>
			 		<?php 
			 		echo ($grp_name['Grpname']);
			 		?>	
			 		<div class="mc_friends_head">Friends:</div>
				</div>
			 	
				<?php
					// ADD FRIENDS NAMES IN GROUP AND DIPLAY IT
					$grp_friends = "SELECT user_profile_required.Name FROM `user_profile_required` INNER JOIN `friends_added` ON user_profile_required.Upr_id = friends_added.Friends_id WHERE friends_added.Grpname_id = '{$grp_name["Group_id"]}' AND '{$grp_name["Grp_crtd_by"]}' = '{$_SESSION["loginid"]}'";
					$grp_friends = $db->query($grp_friends);
					$count =  $grp_friends->num_rows;

					if(!$count==0){
						while($count>0){
							$friends_show = $grp_friends->fetch_array();
							echo ($friends_show['Name']);
				?>
			</div>
			<?php
				$count--;
						}
					}
					else{
						echo ("No friend added");
					}
				$count_group--;
		}
		$db->close();
			?>	
</section>