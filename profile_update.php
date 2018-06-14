<?php 
  	session_start();
	if (isset($_SESSION["loginid"]) && isset($_SESSION["security"])) {	
?>

<?php 
	
	require_once("connect_db.php");
	$title = isset($_POST["title"]) ? $_POST["title"] : " ";
	$name = isset($_POST["name"]) ? $_POST["name"] : " ";
	$contact_number = isset($_POST["contact_number"]) ? $_POST["contact_number"] : " ";
	$address = isset($_POST["address"]) ? $_POST["address"] : " ";
	$password_message = "";
	$password_updated = "";
	$contact_message = "";
	$name_message = "";
?>

<?php 
	$query = "SELECT user_profile_required.Password FROM `user_profile_required`
			  INNER JOIN `user_profile` ON user_profile_required.Upr_id = user_profile.Up_id
			  INNER JOIN `title` ON user_profile_required.Title = title.Title_id
			  WHERE user_profile_required.Upr_id = '{$_SESSION["loginid"]}'";
	$profile = select($query);		 
	$profile = $profile->fetch_array();
	if (isset($_POST["submit"])) {

		//Name
		$name_pattern = "/[a-zA-Z]+/"; 
		preg_match_all($name_pattern,$name,$charc);
		$charc = implode(" ",$charc[0]);
  		$name_message = !($charc == $name) ? "Invalid name (Only use alphabets)" :"";

		//CONTACT_NO
		if(strlen($contact_number) == 10 || strlen($contact_number) == 0) {
  			$contact_pattern = "/^[6-9][0-9]{9}$/";
			$contact_message = (!preg_match($contact_pattern,$contact_number)) ? "Use only numeric values in contact number" : "" ;  		
  		}
		else {
			$contact_message = "Incorrect Contact No.";
		}

		$old_password = md5($_POST["old_password"]);
		$new_password = md5($_POST["new_password"]);
  
		if (!empty($_POST["old_password"]) || empty($_POST["new_password"])) {
			
			if (!empty($_POST["old_password"]) && !empty($_POST["new_password"])) {
			
				if ($old_password == $profile["Password"]) {
					$password = $new_password;
					$password_updated =  "Password updated";
				}
				else{
					$password_message =  "Incorrect password";
					$password = $profile["Password"];
				}
			}
			else{
				$password = $profile["Password"];
			}
		}
		else{
				$password_message =  "Enter password";
		}			

		if (empty($contact_message) && empty($name_message) && empty($password_message)) {
			$query = "UPDATE `user_profile_required`
					  INNER JOIN `user_profile` ON user_profile_required.Upr_id = user_profile.Up_id
					  SET `Title` = '{$title}',
					  `Name` = '{$name}',
					  `Contact_No` = '{$contact_number}',
					  `Address` = '{$address}',
					  `Password` = '$password'
					  WHERE user_profile_required.Upr_id = '{$_SESSION["loginid"]}'";
			update($query); 
		} 
	}

	$query = "SELECT * FROM `user_profile_required`
			  INNER JOIN `user_profile` ON user_profile_required.Upr_id = user_profile.Up_id
			  INNER JOIN `title` ON user_profile_required.Title = title.Title_id
			  WHERE user_profile_required.Upr_id = '{$_SESSION["loginid"]}'";
	$profile = select($query);		 
	$profile = $profile->fetch_array();

	require_once("./header.php");
?>

<?php 
	}
	else{
		header("Location: login.php");
	}
?>


<div id="update_profile">
    <div class="sign_up"> <h2 class="sign_up_txt">Profile Update</h2> </div>

   	<div class="form_sinup">
    	<form class="form_signup_fields" action="profile_update.php" method="POST" enctype="multipart/form-data">
     		<div class="int_name">
      			<span class="name">Name: </spa n>   		
      			<select class="title_selc" name="title">
					<option value="<?php echo ($profile["Title_id"])?>"> <?php echo ($profile["Title_name"])?> </option>
					<?php  if ($profile["Title_id"] !== '1' ) { ?>      			
					<option value="1">Mr.</option>
					<?php } ?>
					<?php  if ($profile["Title_id"] !== '2' ) { ?>
					<option value="2.">Mrs.</option>
					<?php } ?>
					<?php  if ($profile["Title_id"] !== '3' ) { ?>
					<option value="3">Miss.</option>
					<?php } ?>
					<?php  if ($profile["Title_id"] !== '4' ) { ?>
					<option value="4">Other</option>
					<?php }; ?>
   				</select>

      			<input class="name_txt" type="text" name="name" value=<?php echo "'{$profile["Name"]}'" ?>> <span ><?php echo ($name_message); ?></span> 
  			</div>

	     	<div class="int_contact_number">
   		  		<span class="contact_number">Contact No.:</span> 
     			<input class="contact_number_txt" type="text" name="contact_number" value="<?php echo "{$profile["Contact_No"]}" ?>" > <span><?php echo $contact_message;  ?></span>
     		</div>
    	 
     		<div class="int_address">
     			<span class="address">Addres:</span>
     			<textarea class="address_txt" name="address"><?php echo "{$profile["Address"]}" ?></textarea >
     		</div>
       	
      	 	<div class="int_password">
       			<span class="old_password">Old Password:</span>
       			<input class="password_txt" type="password" name="old_password">
       			<span> <?php echo $password_message ?> </span>
       		</div>

       		<div class="int_password">
       			<span class="new_password">New Password:</span>
       			<input class="password_txt" type="password" name="new_password">
       		</div>
       	
       		<div class="signup_message">
       			<p class="message">
       				<?php 
       					echo $password_updated;
       				?>		
       			</p>
       		</div>
       	
       		<div class="int_submit">
       			<input class="submit" type="submit" name="submit" value="Update">
       		</div>
     	</form>
    </div>
</div>