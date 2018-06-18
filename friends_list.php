<?php 
	session_start();
	if(isset($_SESSION["loginid"]) && isset($_SESSION["security"])){
?>

<!-- Header -->
<?php
 	require_once("header.php"); 
 	require_once("connect_db.php"); 
 	$friends_message = "";

	// COUNT NUMBER OF REGISTERED ACCOUNT
	$query = "SELECT user_profile_required.Upr_id,
				     user_profile_required.Name,
				     user_profile_required.Email_id
			  FROM `user_profile_required` WHERE NOT user_profile_required.Upr_id = '{$_SESSION["loginid"]}'";
	$data = select($query);
	$count = $data->rowCount();
?>

<!-- FRIENDS SEARCHING SECTION -->
<section id="mc_section_search">
	<form action="./friends_list.php" method="POST">

		<!-- ADD GROUP NAME IN DROP DOWN-->
		<?php
			$select = "SELECT * FROM `groups` WHERE `Grp_crtd_by`='{$_SESSION["loginid"]}'";
		 	$fetch = select($select);
		 	$count_group = $fetch->rowCount();
			?>

			<select name="select_group" class="mc_select_group">
			
				<option>SELECT GROUP</option>

				<?php 
					$grp_name = array();
					while ( $count_group>0) {
						$grp_data = $fetch->fetch(PDO::FETCH_ASSOC);
				?>

				<option value="<?php echo ($grp_data['Grpname']) ?>"> <?php echo ($grp_data['Grpname']); ?> </option>;

					<?php
						$count_group--;
					}
				 ?>
			</select>	 

			<!--ADD FRIENDS IN SEARCH DROP DOWN-->
			<select name="friend_search" class="mc_friend_search">
			
				<option>Search</option>
				<?php 
					while($count>0){ 
						$upr_data = $data->fetch(PDO::FETCH_ASSOC);
				?> 
				<option value="<?php  echo ($upr_data['Name']);?>"> <?php  echo ($upr_data['Name']."(".$upr_data['Email_id']).")"; ?> </option>		
					<?php
						$count--;
					} 
					?>
			</select>

		<input type="submit" name="submit" class="mc_add_friends" value="Add">

	</form>
</section>

<!--SECTION TO SHOW FRIENDS NAME IN EACH GROUP-->
<section id="mc_section_friends_name">
	
	<!--ADD FRIENDS NAME AND UID INTO DATABASE-->
	<?php 	
		if(isset($_POST["friend_search"]) && isset($_POST["select_group"])) {

			$query = "SELECT groups.Group_id FROM `groups` WHERE `Grpname`='{$_POST["select_group"]}'";
			$grp_id = select($query);
			$grp_id = $grp_id->fetch(PDO::FETCH_ASSOC); 

			$query = "SELECT * FROM `user_profile_required` WHERE `Name`='{$_POST["friend_search"]}'";
			$friends = select($query);
			$friends = $friends->fetch(PDO::FETCH_ASSOC);

			$query = "SELECT friends_added.Friends_id,friends_added.Grpname_id FROM `friends_added` WHERE friends_added.Friends_id = '{$friends["Upr_id"]}' AND friends_added.Grpname_id = '{$grp_id["Group_id"]}'";
			$friend_exist = select($query);
			$count_friend_exist =  $friend_exist->rowCount();
			
			if ($count_friend_exist == 0) {
			$query = "INSERT INTO `friends_added` SET `Friends_id`='{$friends["Upr_id"]}',`Grpname_id`='{$grp_id["Group_id"]}'";
			insert($query);
			$friends_message = "Friend added !!";
			}
			else{
				$friends_message =  "Friend already exist in ".$_POST["select_group"]." group";
			}

    	}
	?>
	<span>
		<?php
			$friends_message = isset ($_GET['status']) ? $_GET['status'] : $friends_message;
			echo $friends_message; 
		?>	
	</span>

	<span>
		 <?php
			 // FETCH FRIENDS NAME WITH RESPECT TO THEIR UID.
			 $query = "SELECT DISTINCT `Grpname`,`Group_id`,`Grp_crtd_by` FROM `groups` WHERE `Grp_crtd_by`='{$_SESSION["loginid"]}'";
			 $grp_select = select($query);
			 $count_group = $grp_select->rowCount();
			 
		
			 while($count_group>0){
				 $grp_name = $grp_select->fetch(PDO::FETCH_ASSOC);
		 ?>

		<!--PUT ADDED FRIENDS IN GROUP -->
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
				 $query = "SELECT user_profile_required.Name
				 				 FROM `user_profile_required`
				 				 INNER JOIN `friends_added` ON user_profile_required.Upr_id = friends_added.Friends_id 
				 				 WHERE friends_added.Grpname_id = '{$grp_name["Group_id"]}' 
				 				 AND '{$grp_name["Grp_crtd_by"]}' = '{$_SESSION["loginid"]}'";
				 $grp_friends = select($query);
				 $count =  $grp_friends->rowCount();

				 while ($count>0) {
					 $friends_show =  $grp_friends->fetch(PDO::FETCH_ASSOC);
					 echo ($friends_show['Name']);
			 ?>
			 
			 <?php
				 //TAKE UID VALUE FOR DELETE FRIEND NAME
				 $query = "SELECT `Upr_id` FROM `user_profile_required` WHERE `Name`='{$friends_show['Name']}'";
				 $id = select($query);
				 $id = $id->fetch(PDO::FETCH_ASSOC);
			 ?>

			 <a class="mc_friends_delete" href="./friends_list_delete.php/?id=<?php echo ($id['Upr_id']);?>&gid=<?php echo ($grp_name["Group_id"]) ?>">Delete</a>
		 </div>

				 <?php
				 $count--;
				 }
				 $count_group--;
				 }
				 ?>	

	</span>
	
</section>	

<?php 
	}
	else{
		header("Location: login.php");
	}
?>