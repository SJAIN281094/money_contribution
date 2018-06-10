<?php
	//Database connection and queries
	require_once("connect_db.php"); 
	
	// Take all $_POST[] values in variables
	$title = isset($_POST["title"]) ? $_POST["title"] : " ";
	$name = isset($_POST["name"]) ? $_POST["name"] : " ";
	$dob = isset($_POST["dob"]) ? $_POST["dob"] : " ";
	$emailid = isset($_POST["emailid"]) ? $_POST["emailid"] : " ";
	$contact_number = isset($_POST["contact_number"]) ? $_POST["contact_number"] : " ";
	$address = isset($_POST["address"]) ? $_POST["address"] : " ";
	$password = isset($_POST["password"]) ? $_POST["password"] : " ";
	$message = "";
	$email_message = "";
	$contact_message = "";
	$date_message = "";
	 
	if (isset($_POST['submit'])) {

		//Create databse and table
		$upload  = require_once("database_table.php");
  	
	  	// Fiels should not be empty !!
	  	if (!empty($name)
	  		&& !empty($dob)
	  		&& !empty($emailid)
	  		&& !empty($contact_number)
	  		&& !empty($address) 
	  		&& !empty($password)) {

	  		// Fields validation

			//Name
	  		$name = addslashes($name);

	  		// DOB
	  		date_default_timezone_set("Asia/Calcutta");
	  		$today = date("Y-m-d");
	  		$dob = strtotime($dob);
	  		$today = strtotime($today);
	  		$td = gmdate("m-d-y",$today);  
	  		$date_message = ($dob>$today) ? "Invalid Date "."(".$td.")" : "";
	  		
	 		//Emailid
	  		$email_pattern = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";
	  		if (preg_match ($email_pattern,$emailid)) {
	  					
				// Connect to database and run select query
				$query = "SELECT user_profile_required.Email_id
						  FROM `user_profile_required` 
						  WHERE `Email_id` = '{$emailid}'";
				$fetch = select($query);	
				$email_count = $fetch->num_rows;

				$email_message =  (!$email_count == 0) ? "Email address already exist!" : "";

			}
			else {
				$email_message = "Incorrect email address";
			}

			//CONTACT_NO
			if(strlen($contact_number) == 10) {
	  			$contact_pattern = "/^[7-9][0-9]{9}$/";
				$contact_message = (!preg_match($contact_pattern,$contact_number)) ? "Use only numeric values in contact number" : "" ;  		
	  		}
			else {
				$contact_message = "Incorrect Contact No.";
			}

			//PASSWORD
			$password = md5($password);

			//INSERT FIELD VALUE IN DATABASE
			if (empty($email_message) && empty($contact_message) && empty($date_message)) {
				
				// Connect to database and run insert query 
				$query = "INSERT INTO `user_profile_required` SET
					`Title`= '{$title}',
					`Name`='{$name}',
					`Email_id` = '{$emailid}',
					`Password` = '{$password}',	
					`status` = 1";
				$check = insert($query);
				
				// Connect to database and run insert query
				$query = "INSERT INTO `user_profile` SET
					`Date_of_birth`= '{$dob}',
					`Contact_No` = '{$contact_number}',
					`Address`= '{$address}'";
				insert($query);
				$message = "Registration Successfull..!";

				// Reset values.
				$name = "";
				$emailid = "";
				$contact_number = "";
				$address = "";
				}

		}
		else {
				$message = "Fill all details."; 
		}

	}
   
 ?>
 

<!DOCTYPE html>
	<head>
		<title>Money Contribution</title>
	<body>
		<div id="signup">
			<h1 class="mc_heading">MONEY CONTRIBUTION</h1>
		    <div class="mc_logo"><a href="#"><img src="./images/logo.jpg" alt="mc-logo"></a></div>
		    <div class="sign_up"><h2  class="sign_up_txt">SIGNUP</h2></div>

		   	<div class="form_sinup">
		    	<form class="form_signup_fields" action="./signup.php" method="POST" enctype="multipart/form-data">
		     		<div class="int_name">
		      			<span class="name">Name*: </span>
		      			<select class="title_selc" name="title">
		         			<option value="Mr.">Mr.</option>
		         			<option value="Mrs.">Mrs.</option>
		         			<option value="Mrs.">Miss.</option>
		         			<option value="other">Other</option>
		       			</select>
		      			<input class="name_txt" type="text" name="name" value=<?php echo $name ?>>
		  			</div>

			     	<div class="int_dob">
		    	 		<span class="dob">Date of birth*:</span>
		     			<input class="dob_selc" type="date" name="dob" value=<?php echo $dob ?>> <span ><?php  echo ($date_message); ?></span>  
		     		</div>

			     	<div class="int_emailid" >
		   		  		<span class="emailid">Email-id*:</span> 
		     			<input class="emailid_txt" type="text" name="emailid" value=<?php echo $emailid;?> > <span ><?php  echo ($email_message); ?></span>
		     		</div>

			     	<div class="int_contact_number">
		   		  		<span class="contact_number">Contact No.*:</span> 
		     			<input class="contact_number_txt" type="text" name="contact_number" value=<?php echo $contact_number ?> > <span><?php echo $contact_message;  ?></span>
		     		</div>
		    	 
		     		<div class="int_address">
		     			<span class="address">Address*:</span>
		     			<textarea class="address_txt" name="address"><?php echo $address ?></textarea >
		     		</div>
		       	
		      	 	<div class="int_password">
		       			<span class="password">Password*:</span>
		       			<input class="password_txt" type="password" name="password">
		       		</div>
		       	
		       		<div class="signup_message">
		       			<p class="message">
		       				<?php 
		       					echo $message;
		       				?>		
		       			</p>
		       		</div>
		       	
		       		<div class="int_submit">
		       			<input class="submit" type="submit" name="submit" value="Signup">
		       		</div>
		     	</form>
		    </div>
		   
		    <div class="signup_log">
		   	 	<span class="reg_user">Registered User</span> <a class="log_login_link" href="./login.php">Login</a>
		    </div>
		</div>
	</body>
	</head>
</html>