<?php 
		if(isset($_SESSION["loginid"]) && isset($_SESSION["security"])){
?>

<div class="view_details<?php echo $i ?>">
	<div class="pvd_labels">
		<label class="pvd_status">Status</label> 
		<label class="pvd_name">Name</label>
		<label class="pvd_amount">Amount</label>
	</div>
	
	<!-- Create friends list with out (paid by user) -->
	<?php 
	 	$query = "SELECT friends_added.Friends_id
		 		  FROM `friends_added`
		 		  INNER JOIN `groups` ON friends_added.Grpname_id = groups.Group_id
		 		  WHERE groups.Grpname = '{$entry_data["Grpname"]}'";
		$friends_id = select($query);
		$owe_count = $friends_id->num_rows;

		while($owe_count>0){
			$owe = $friends_id->fetch_array();
				
			$query = "SELECT user_profile_required.Name
			 		  FROM `user_profile_required`   	 
		 		 	  WHERE user_profile_required.Upr_id =  '{$owe["Friends_id"]}'";
			$owe_name = select($query);
			$owe_name = $owe_name->fetch_array();
			
				
			if( $owe["Friends_id"] !== $entry_data['Paid_by_id']){		
	?>
	
				<div class="pvd_owe">
					<span class="pvd_owe_by">Owe by:</span>
					<span class="pvd_owe_name"><?php echo $owe_name["Name"]  ?></span>
					<span class="pvd_owe_amount"><?php  echo round($amount/($select-1),2) ?></span>
				</div>
	<?php 
			}
		$owe_count--;
		}	
	?>
</div>

<?php 
	}
	else{
		header("Location: login.php");
	}
?>