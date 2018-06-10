<!-- Include header -->
<?php 
	require_once("./header.php");
?>
<?php 
	 $db = new mysqli();
	$test = $db->connect("localhost","root","budget_123","moneycontribution");
	$fetch = "SELECT DISTINCT
			 	expenditure.Date,
				expenditure.Description,
				groups.Grpname,
				user_profile_required.Name,
				expenditure.Amount_paid,
				expenditure.Group_select
			 FROM
				`expenditure`
			 INNER JOIN `groups` ON expenditure.Group_select = groups.Group_id
			 INNER JOIN `user_profile_required` ON expenditure.Paid_by_id = user_profile_required.Upr_id
			 INNER JOIN `friends_added` ON expenditure.Group_select = friends_added.Grpname_id
			 WHERE groups.Grp_crtd_by = '{$_SESSION["loginid"]}' OR friends_added.Friends_id = '{$_SESSION["loginid"]}' 
			 ORDER BY expenditure.Date";

			
	$fetch = $db->query($fetch);
	$count_entry = $fetch->num_rows; 
	$db->close();
 ?>

<div class="passbook_frame">

	<div class="passbook_entry_head">
		<span class="passbook_head_sn">S.No.</span>
		<span class="passbook_head_date">Date</span>
		<span class="passbook_head_description">Description</span>
		<span class="passbook_head_group">Group</span>
		<span class="passbook_head_paid">Paid by</span>
		<span class="passbook_head_amount_paid">Amount paid</span>
		<span class="passbook_head_status">Status</span>
		<span class="passbook_head_amount">Amount</span>
	</div>


	<?php  
	$spending = 0;
	$crt = 0;
	$dbt = 0;
	for ($i=1;$i<=$count_entry;$i++) {
		$entry_data = $fetch->fetch_array();
	?>
	
	<!-- Passbook status and amount -->
	<?php
		$db = new mysqli();
		$test = $db->connect("localhost","root","budget_123","moneycontribution");
		$grp_id = "SELECT * FROM `groups`
				   WHERE `Grpname`='{$entry_data['Grpname']}'";
		$grp_id = $db->query($grp_id);
		$grp_id = $grp_id->fetch_array();

		$select = "SELECT friends_added.friends_id
				   FROM `friends_added`
				   WHERE  friends_added.Grpname_id = '{$grp_id["Group_id"]}'";
		$select = $db->query($select);
		$select = $select->num_rows;   
		$amount = (($entry_data['Amount_paid'])/($select + 1));


		//Check Credit/debit status
		if($entry_data['Group_select'] == $_SESSION["loginid"]) {
 			$status = "D";
		}
		else{
			$status = "C";
		}
	?>

	<div class="passbook_entry_body">
		<span class="passbook_body_sn"><?php  echo $i ?></span>
		<span class="passbook_body_date"><?php  echo $entry_data['Date'] ?></span>
		<span class="passbook_body_description"><?php echo $entry_data['Description'] ?></span>
		<span class="passbook_body_group"><?php echo $entry_data['Grpname'] ?></span>
		<span class="passbook_body_paid"><?php  echo $entry_data['Name'] ?></span>
		<span class="passbook_body_amount_paid"><?php  echo $entry_data['Amount_paid'] ?></span>
		<span class="passbook_body_status"><?php  echo $status ?></span>
		<span class="passbook_body_amount"><?php  echo $amount ?></span>
	</div>

	<!-- Add total amount,credit and debit -->
	<?php

		if($status =="C"){
			$crt += $amount;
		}
		else{
			$dbt += $amount;
		}
		$spending += $amount;
	} 
	?>

	<div class="passbook_credit">Total spending : <?php echo $spending ?></div>
	<div class="passbook_credit">Total Credit : <?php echo $crt ?></div>
	<div class="passbook_debit">Total Debit : <?php echo $dbt ?></div>
	<div class="passbook_balance">Balance :
		<?php
			$balance = ($dbt - $crt);
			if($balance>0){
				echo "You have to take ".$balance."Rs. from your friends";
			}
			if($balance<0){
				echo "You have to give ".$balance."Rs. to your friends";
			}
			if($balance=0){
				echo "Nil";
			}

		?>	
	</div>

</div>