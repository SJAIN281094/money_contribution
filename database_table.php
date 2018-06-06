<?php
// CREATE DATABASE SIGNUP
	$db = new mysqli();
	$db->connect("localhost","root","budget_123");
		if(!$db->connect_error)
		{
			$database = "CREATE DATABASE `moneycontribution`";
			$dat = $db->query($database);
	$db->close();
 		}
		else
 		{
	 		exit("connection failure");
 		}


// CREATE TABLE WITH REQUIRED FIELD IN SIGNUP
	$db = new mysqli();
	$db->connect("localhost","root","budget_123","moneycontribution");
	$table = "CREATE TABLE  user_profile_required (
		Upr_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		Title VARCHAR(5),
		Name VARCHAR(60),
		Email_id VARCHAR(50),
		Password VARCHAR(32),
		status INT(1))";
	$tab = $db->query($table);
	$db->close();
	
	// CREATE TABLE WITH FIELD EXCEPT REQUIRED IN SIGNUP
	$db = new mysqli();
	$db->connect("localhost","root","budget_123","moneycontribution");
	$table = "CREATE TABLE  user_profile (
		Up_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		Date_of_birth VARCHAR(10),
		Contact_No BIGINT(10),
		Address VARCHAR(200))";
	$tab = $db->query($table);
	$db->close();

	// CREATE TABLE WITH FRIENDS ADDED IN ACCOUNT
	$db = new mysqli();
	$db->connect("localhost","root","budget_123","moneycontribution");
	$table = "CREATE TABLE  friends_added (
		Frdadded_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		User INT(5),
		Friends INT(5),
		Grpname VARCHAR(15))";
	$tab = $db->query($table);
	$db->close();

	// CREATE TABLE WITH GROUP NAME
	$db = new mysqli();
	$db->connect("localhost","root","budget_123","moneycontribution");
	$group = "CREATE TABLE  groups(
		Group_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		Grpname VARCHAR(15),
		Grp_crtd_by INT(5))";
	$group = $db->query($group);
	$db->close();
	?>

