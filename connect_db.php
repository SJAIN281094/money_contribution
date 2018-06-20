<?php 
	function connect(){
		$db = new mysqli();
		$test = $db->connect("localhost","root","budget_123","moneycontribution");
		return $db;
	}

	function select($query){
		$db = connect();
		$select = $query;
		$select = $db->query($query);
		$db->close();
		return $select;
	}

	function insert($query){
		$db = connect();
		$insert = $query;
		$insert = $db->query($query);
		$db->close();
		return $insert;
	}

	function delete($query){
		$db = connect();
		$delete = $query;
		$delete = $db->query($query);
		$db->close();
		return $delete;
	}

	function update($query){
		$db = connect();
		$update = $query;
		$update = $db->query($query);
		$db->close();
		return $update;
	}
?>

