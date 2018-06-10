<?php 
 function select($query){
 	$db = new mysqli();
	$test = $db->connect("localhost","root","budget_123","moneycontribution");
	$select = $query;
	$select = $db->query($query);
	$db->close();
 	return $select;
 }

  function insert($query){
 	$db = new mysqli();
	$test = $db->connect("localhost","root","budget_123","moneycontribution");
	$insert = $query;
	$insert = $db->query($query);
	$db->close();
 	return $insert;
 }

  function delete($query){
 	$db = new mysqli();
	$test = $db->connect("localhost","root","budget_123","moneycontribution");
	$fetch = $query;
	$fetch = $db->query($query);
	$db->close();
 	return $fetch;
 }

  function update($query){
 	$db = new mysqli();
	$test = $db->connect("localhost","root","budget_123","moneycontribution");
	$fetch = $query;
	$fetch = $db->query($query);
	$db->close();
 	return $fetch;
 }
 ?>