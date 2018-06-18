<?php 
	function connect(){
		$db = new PDO("mysql:host=localhost;dbname=moneycontribution","root","budget_123");
		return $db;
	}

	function select($query){
		$db = connect();
		$select = $db->query($query);
		$db = null;
		return $select;
	}

	function insert($query){
		$db = connect();
		$insert = $db->query($query);
		$db = null;
		return $insert;
	}

	function delete($query){
		$db = connect();
		$delete = $db->query($query);
		$db = null;
		return $delete;
	}

	function update($query){
		$db = connect();
		$update = $db->query($query);
		$db = null;
		return $update;
	}
?>

