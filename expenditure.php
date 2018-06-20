<?php 
  	session_start();
	if(isset($_SESSION["loginid"]) && isset($_SESSION["security"])){
?>

<!-- Include header -->
<?php 
	require_once("./header.php");
	$expn_date = isset($_POST["expn_date"]) ? $_POST["expn_date"] : "";
	$expn_description = isset($_POST["expn_description"]) ? $_POST["expn_description"] : "";
	$expn_radio = isset($_POST["expn_radio"]) ? $_POST["expn_radio"] : "";
	$expn_paid = isset($_POST["expn_paid"]) ? $_POST["expn_paid"] : "";
	$date_message = "";
	$description_message = "";
	$Amount_paid_message = "";
	$expn_radio_message = ""; 
	$message = "";
?>

<!--INSERT EXPENDITURE VALUES IN DATABASE-->
<?php 
	if (isset($_POST["expn_submit"])) {
		$query = "SELECT * FROM `groups`
				   WHERE `Grpname`='{$_POST["expn_groups"]}'";
		$grp_id = select($query);
		$grp_id = $grp_id->fetch(PDO::FETCH_ASSOC);

		$query = "SELECT friends_added.friends_id
				   FROM `friends_added`
				   WHERE  friends_added.Grpname_id = '{$grp_id["Group_id"]}'";
		$select = select($query);
		$select = $select->rowCount(); 

		$amount = (($expn_paid)/($select + 1));

		//Date validation
		$today = date("Y-m-d");
  		$expn_date = strtotime($expn_date);
  		$today = strtotime($today);
  		$td = gmdate("m-d-y",$expn_date);  
  		$date_message = ($expn_date>$today) ? "Invalid Date "."(".$td.")" : "";
  		$date_message =  empty($expn_date) ? "Select date": $date_message ;

  		//Description validation
  		$name_pattern = "/[a-zA-Z0-9]+/"; 
		preg_match_all($name_pattern,$expn_description,$charc);
		$charc = implode(" ",$charc[0]);
  		$description_message = !($charc == $expn_description) ? "Invalid name (Only use alphabets)" :"";
  		$description_message =  empty($expn_description) ? "Enter description": $description_message ;

  		//Group validation
  		$expn_radio_message = empty($expn_radio) ?  "Select friend" : "";

  		//Amount_paid_validation
  		$name_pattern = "/[0-9]+/"; 
  		$Amount_paid_message = !(preg_match($name_pattern,$expn_paid,$empty)) ? "Invalid amount (Only use Numeric value)" :"";
  		$Amount_paid_message = empty($expn_paid) ? "Enter amount" : $Amount_paid_message ;


  		if(empty($date_message) && empty($name_message) && empty($Amount_paid_message) && empty($expn_radio_message)){
		$query = "INSERT INTO `expenditure` SET 
			`Date`='{$expn_date}',
			`Description`='{$expn_description}',
			`Group_select`='{$grp_id["Group_id"]}',
			`Paid_by_id`='{$expn_radio}',
			`Amount_paid`='{$expn_paid}'";
		$insert = insert($query);
		}
		else{
		$message =  "Fill all details";		
		}
	}
?>

<!-- Form section -->
<section id="expn_section_form">
	<form action="./expenditure.php" method="POST">
	 	<div>Date: <input class="expn_date" type="date" name="expn_date">  <span> <?php echo $date_message ?> </span> </div>
	 	<div>Description:<input class="expn_description" type="text" name="expn_description"> <span> <?php echo $description_message ?> </span> </div>
	 	<div>
	 		<!--PUT GROUPS NAME IN DROP DOWN-->
	 		<?php
				$query = "SELECT * FROM `groups` WHERE `Grp_crtd_by` = '{$_SESSION["loginid"]}'";
				$fetch = select($query);
				$count_group = $fetch->rowCount();
			?>

		Groups: <select class="expn_groups" name="expn_groups" onchange="request()">
					<option value="Select_Group">Select Group</option>

					<?php 
						$grp_name = array();
						while ( $count_group>0) {
							$grp_data = $fetch->fetch(PDO::FETCH_ASSOC);
					?>

					<option value="<?php echo ($grp_data['Grpname']) ?>"> <?php echo ($grp_data['Grpname']); ?> </option>
						
						<?php
							$count_group--;
						}
					?>
			 	</select> <span> <?php echo $expn_radio_message ?> </span>
	 	</div>

	 	<div class="expn_radio"></div>
	 	<div> Amount Paid: <input class="expn_paid" type="text" name="expn_paid" placeholder="0"> <span> <?php echo $Amount_paid_message ?> </span> </div>
	 	<span> <?php echo $message ?></span>
	 	<div><input class="expn_submit" type="submit" name="expn_submit" value="Add"></div>

	</form>
	<script src='./js/expenditure.js' type='text/javascript'></script>
</section>

<?php 
	}
	else{
		header("Location: login.php");
	}
?>