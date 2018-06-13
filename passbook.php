<?php 
  	session_start();
	if(isset($_SESSION["loginid"]) && isset($_SESSION["security"])){
?>

<!-- Include header -->
<?php 
	require_once("./header.php");
?>
<?php 
	$query = "SELECT DISTINCT
			 	expenditure.Date,
				expenditure.Description,
				groups.Grpname,
				user_profile_required.Name,
				expenditure.Amount_paid,
				expenditure.Paid_by_id,
				expenditure.Group_select
			 FROM
				`expenditure`
			 INNER JOIN `groups` ON expenditure.Group_select = groups.Group_id
			 INNER JOIN `user_profile_required` ON expenditure.Paid_by_id = user_profile_required.Upr_id
			 INNER JOIN `friends_added` ON expenditure.Group_select = friends_added.Grpname_id
			 WHERE groups.Grp_crtd_by = '{$_SESSION["loginid"]}' OR friends_added.Friends_id = '{$_SESSION["loginid"]}' 
			 ORDER BY expenditure.Date";		
	$fetch = select($query);
	$count_entry = $fetch->num_rows; 
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

		$select = "SELECT friends_added.Friends_id
				   FROM `friends_added`
				   WHERE  friends_added.Grpname_id = '{$grp_id["Group_id"]}'";
		$select = $db->query($select);
		$select = $select->num_rows;   
		$amount = (($entry_data['Amount_paid'])/($select));
		$amount = $amount*($select-1);

		//Check Credit/debit status
		if($entry_data['Paid_by_id'] == $_SESSION["loginid"]) {
 			$status = "Debit";
		}
		else{
			$status = "Credit";
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
		<span class="passbook_body_amount"><?php  echo round($amount,2) ?></span>
		<?php
		 if ($select !== 1) { ?>
			<span class="passbook_body_view_details"><a onclick= "view_details(<?php echo $i ?>)">View details</a></span>
		<?php 	
			};
		?>
		<script src="js/passbook_viewdetails.js" type="text/javascript"></script>
		<script src="js/jquery.js" type="text/javascript"></script>
	</div>
		<?php
		 if ($select !== 1) { ?>
			<?php require("passbook_viewdetails.php"); ?>
		<?php 	
			};
		?>
	

	<!-- Add total amount,credit and debit -->
	<?php

		if($status =="Credit"){
			$crt += $amount;
		}

		else{
			$dbt += $amount;
		}
		$spending += $amount;
		$select = ($select>1)? $select-1 : $select;
		$crt = $crt/($select);
	} 

	?>

	<div class="passbook_credit">Total spending : <?php echo round($spending,2) ?></div>
	<div class="passbook_credit">Total Credit : <?php echo round($crt,2) ?></div>
	<div class="passbook_debit">Total Debit : <?php echo round($dbt,2) ?></div>
	<div class="passbook_balance">Balance :
		<?php
			$balance = round($dbt - $crt,2);
			if($balance>0){
				echo "You have to take ".$balance."Rs. from your friends";
			}
			if($balance<0){
				echo "You have to give ".($balance*-1)."Rs. to your friends";

			}
			if($balance==0){
				echo $balance;
			}

		?>	
	</div>

</div>

<?php 
	}
	else{
		header("Location: login.php");
	}
?>