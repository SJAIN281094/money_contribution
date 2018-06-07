
<?php 
require_once("./header.php");

?>

 <form action="./expenditure.php" method="POST">
 	<div>Date: <input class="expn_date" type="date" name="expn_date"></div>
 	<div>Description:<input class="expn_description" type="text" name="expn_description"></div>
 	<div>
 			<!--PUT GROUPS NAME IN DROP DOWN-->
 			<?php
			$db = new mysqli();
			$test = $db->connect("localhost","root","budget_123","moneycontribution");
			$sql = "SELECT * FROM `groups`";
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
	<span class="select_checkboxes">Select Friends:</span>
 	<div class="expn_checkboxes"></div>

 	<!--<div>Contributor Name:<input class="expn_contributor" type="text" name="expn_contributor"></div>-->
 	<div>Amount Paid: <input class="expn_paid" type="text" name="expn_paid"></div>
 	<div><input class="expn_submit" type="submit" name="expn_submit" value="Add"></div>
 </form>
 <script src='./js/expenditure.js' type='text/javascript'></script>
	
