<!-- Include header -->
<?php 
	require_once("./header.php");
?>


<!--INSERT EXPENDITURE VALUES IN DATABASE-->
<?php 
	if (isset($_POST["expn_submit"])) {
		$db = new mysqli();
		$test = $db->connect("localhost","root","budget_123","moneycontribution");
		$grp_id = "SELECT * FROM `groups`
				   WHERE `Grpname`='{$_POST["expn_groups"]}'";
		$grp_id = $db->query($grp_id);
		$grp_id = $grp_id->fetch_array();
		$select = "SELECT friends_added.friends_id
				   FROM `friends_added`
				   WHERE  friends_added.Grpname_id = '{$grp_id["Group_id"]}'";
		$select = $db->query($select);
		$select = $select->num_rows;   
		$amount = (($_POST["expn_paid"])/($select + 1));

		$insert = "INSERT INTO `expenditure` SET 
			`Date`='{$_POST["expn_date"]}',
			`Description`='{$_POST["expn_description"]}',
			`Group_select`='{$grp_id["Group_id"]}',
			`Paid_by_id`='{$_POST["expn_radio"]}',
			`Amount_paid`='{$_POST["expn_paid"]}'";
		$insert = $db->query($insert);
		$db->close();
	}
?>

<!-- Form section -->
<section class-"expn_section_form">
<form action="./expenditure.php" method="POST">
 	<div>Date: <input class="expn_date" type="date" name="expn_date"></div>
 	<div>Description:<input class="expn_description" type="text" name="expn_description"></div>
 	<div>
 		<!--PUT GROUPS NAME IN DROP DOWN-->
 		<?php
			$db = new mysqli();
			$test = $db->connect("localhost","root","budget_123","moneycontribution");
			$sql = "SELECT * FROM `groups` WHERE `Grp_crtd_by` = '{$_SESSION["loginid"]}'";
			$fetch = $db->query($sql);
			$count_group = $fetch->num_rows;
			$db->close();
		?>

		Groups: <select class="expn_groups" name="expn_groups" onchange="request()">	
		<option value="Select_Group">Select Group</option>

		<?php 

			$grp_name = array();
			while ( $count_group>0) {
				$grp_data = $fetch->fetch_array();
			?>

			<option value="<?php echo ($grp_data['Grpname']) ?>"> <?php echo ($grp_data['Grpname']); ?> </option>
			<?php
				$count_group--;
			}
		?>
 		</select>
 	</div>

 	<div class="expn_radio"></div>
 	<div> Amount Paid: <input class="expn_paid" type="text" name="expn_paid"></div>
 	<div><input class="expn_submit" type="submit" name="expn_submit" value="Add"></div>
 </form>
<script src='./js/expenditure.js' type='text/javascript'></script>


</section>
