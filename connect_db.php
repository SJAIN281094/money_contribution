<!--<?php
function connect_db()
{
$db = new mysqli();
$test = $db->connect("localhost","root","budget_123","moneycontribution");
$sql = "SELECT * FROM `user_profile_required`";
$data = $db->query($sql);
$count = $data->num_rows;
$db->close();
}
?>-->