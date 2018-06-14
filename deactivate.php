<?php 
  	session_start();
	if (isset($_SESSION["loginid"]) && isset($_SESSION["security"])) {	
?>

<?php 
	require_once("./header.php");
	require_once("connect_db.php"); 
	$password_message = "";
?>

 <?php 
	$query = "SELECT * FROM `user_profile_required` WHERE `Upr_id`='{$_SESSION["loginid"]}'";
	$data_collect = select($query);
	$data = $data_collect->fetch_array();

	if (isset($_POST['deactivate'])) {

	$password = isset($_POST["log_password"]) ? $_POST["log_password"] : '';

	if (!empty($password)) {
		
		// VALIDATE PASSWORD
		$_POST["log_password"] = md5($_POST["log_password"]); //ENCRYPT PASSWORD

		if($_POST["log_password"]==$data["Password"]){ 

		$query = "UPDATE `user_profile_required`
				  SET `status` = 0 
				  WHERE `Upr_id`='{$_SESSION["loginid"]}'";
		update($query);
		header("Location: login.php");
		}
		else{
		$password_message = "Incorrect Password";
		}

	  }
	  else
	    {
	    $password_message = "Enter Password";
	    }
	  }

  ?>

<!-- HTML CODE -->
 <div id="login_frame">
    <div class="login"><h2 class="log_login_txt">Profile Deactivation</h2></div>

    <div class="form_login">
      <form class="form_login_fields" action="deactivate.php" method="post">
        <div class="log_int_emailid">
         <span class="log_emailid">Login id: </span>
         <input class="log_emailid_txt" type="text" name="log_emailid" value="<?php echo "{$data['Email_id']}" ?>" disabled>
        </div>
        <div class="log_int_password">
         <span class="log_password">Password: </span>
         <input class="log_password_txt" type="password" name="log_password" placeholder="Enter Password here :( "> <span> <?php echo $password_message ?></span>
        </div>
        <div class="log_int_submit">
          <input class="log_submit_clk" type="submit" name="deactivate" value="Deactivate">
        </div>
      </form>

    </div>
 </div>

<?php 
	}
	else{
		header("Location: login.php");
	}
?>