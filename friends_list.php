<!-- Header -->
<?php
 require_once("./header.php"); 
 
 // CONNECT DATABASE
 //require_once("./connect_db.php");

// COUNT NUMBER OF REGISTERED ACCOUNT
$db = new mysqli();
$test = $db->connect("localhost","root","budget_123","moneycontribution");
$sql = "SELECT * FROM `user_profile_required`";
$data = $db->query($sql);
$count = $data->num_rows;
$db->close();
?>

<!-- FRIENDS SEARCHING SECTION -->
<section class="mc_section_search">

	<form action="./friends_list.php" method="POST">

		<!-- ADD GROUP NAME IN DROP DOWN-->

		 <?php
			$db = new mysqli();
			$test = $db->connect("localhost","root","budget_123","moneycontribution");
			$sql = "SELECT * FROM `groups`";
			$fetch = $db->query($sql);
			$count_group = $fetch->num_rows;
			$db->close();
			?>

		<select name="select_group" class="mc_select_group"> 
			
			<option>SELECT GROUP</option>

			<?php 
			 $grp_name = array();
			 while ( $count_group>0) {
			 	$grp_data = $fetch->fetch_array();
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
				$upr_data = $data->fetch_array();
				 ?> 
				<option value="<?php  echo ($upr_data['Name']);?>"> <?php  echo ($upr_data['Name']."(".$upr_data['Email_id']).")"; ?> </option>		
				<?php   $count-- ; } 
				$db->close();
			 ?>
		</select>
		<input type="submit" name="submit" class="mc_add_friends" value="Add">		
	</form>
</section>

<!--SECTION TO SHOW FRIENDS NAME IN EACH GROUP-->
<section class="mc_section_friends_name">
	
	<!--ADD FRIENDS NAME UID INTO DATABASE-->
	<?php 
	session_start();
	$db = new mysqli();
	$db->connect("localhost","root","budget_123","moneycontribution");
	if(isset($_POST["friend_search"])){
	$select = "SELECT * FROM `user_profile_required` WHERE `Name`='{$_POST["friend_search"]}'";
	$friends = $db->query($select);
	$friends = $friends->fetch_array();
	$insert = "INSERT INTO `friends_added` SET `User`='{$_SESSION["loginid"]}',`Friends`='{$friends["Upr_id"]}',`Grpname`='{$_POST["select_group"]}'";
	$db->query($insert);
	$db->close(); 
    }
	?>
		<span>

			 <?php

			 // FETCH FRIENDS NAME WITH RESPECT TO THEIR UID.
			 $db = new mysqli();
			 $db->connect("localhost","root","budget_123","moneycontribution");
			 //$select = "SELECT user_profile_required.Name FROM `user_profile_required` INNER JOIN `friends_added` ON user_profile_required.Upr_id = friends_added.Friends WHERE friends_added.User = '{$_COOKIE["loginid"]}'";
			 $grp_select = "SELECT DISTINCT `Grpname` FROM `friends_added`";
			 //$friend_show = $db->query($select);
			 $grp_select = $db->query($grp_select);
			 //$count =  $friend_show->num_rows;
			 $count_group = $grp_select->num_rows;
			 
		
			 while($count_group>0){
			 $grp_name = $grp_select->fetch_array();
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

			 $grp_friends = "SELECT user_profile_required.Name FROM `user_profile_required` INNER JOIN `friends_added` ON user_profile_required.Upr_id = friends_added.Friends WHERE friends_added.Grpname = '{$grp_name["Grpname"]}' AND friends_added.User = '{$_SESSION["loginid"]}'";
			 $grp_friends = $db->query($grp_friends);
			 $count =  $grp_friends->num_rows;

			 while($count>0){

			 $friends_show =  $grp_friends->fetch_array();
			 echo ($friends_show['Name']);

			 ?>
			 
			 
			 <?php

			 //TAKE UID VALUE FOR DELETE FRIEND NAME
			 $id = "SELECT `Upr_id` FROM `user_profile_required` WHERE `Name`='{$friends_show['Name']}'";
			 $id = $db->query($id);
			 $id = $id->fetch_array();
			 ?>

			 <a class="mc_friends_delete" href="./friends_list_delete.php/?id=<?php echo ($id['Upr_id']); ?>">Delete</a>

			 </div>

			 <?php
			 $count--;
			 }

			 $count_group--;
			 }
			 $db->close();
			 ?>	

		</span>
</section>