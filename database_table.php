<?php
	require_once("connect_db.php"); 
// Create database signup
	$db = connect();
	$database = "CREATE DATABASE `moneycontribution`";
	$dat = $db->query($database);
	$db = null;

// CREATE TABLE WITH REQUIRED FIELD IN SIGNUP
	$db = connect();
	$table = "CREATE TABLE  user_profile_required (
		Upr_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		Title VARCHAR(5),
		Name VARCHAR(60),
		Email_id VARCHAR(50),
		Password VARCHAR(32),
		status INT(1))";
	$tab = $db->query($table);
	$db = null;
	
	// CREATE TABLE WITH FIELD EXCEPT REQUIRED IN SIGNUP
	$db = connect();
	$table = "CREATE TABLE  user_profile (
		Up_id INT UNSIGNED AUTO_INCREMENT,
		FOREIGN KEY(Up_id) REFERENCES user_profile_required(Upr_id),
		Date_of_birth VARCHAR(10),
		Contact_No BIGINT(10),
		Address VARCHAR(200))";
	$tab = $db->query($table);
	$db = null;

	// CREATE TABLE WITH FRIENDS ADDED IN ACCOUNT
	$db = connect();
	$table = "CREATE TABLE  friends_added (
		Frdadded_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		Friends_id INT(5),
		Grpname_id VARCHAR(15))";
	$tab = $db->query($table);
	$db = null;

	// CREATE TABLE WITH GROUP NAME
	$db = connect();
	$group = "CREATE TABLE  groups(
		Group_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		Grpname VARCHAR(15),
		Grp_crtd_by INT(5))";
	$group = $db->query($group);
	$db = null;

	// Create table to store expenditure values
	$db = connect();
	$expenditure = "CREATE TABLE expenditure(
	Expenditure_id INT AUTO_INCREMENT PRIMARY KEY,
	Date VARCHAR(10),
	Description VARCHAR(30),
	Group_select VARCHAR(15),
	Paid_by_id INT(5),
	Amount_paid INT(8))"; 
	$expenditure = $db->query($expenditure);
	$db = null;
	

	//Title table
	$db = connect();
	$expenditure = "CREATE TABLE title(
	Title_id INT AUTO_INCREMENT PRIMARY KEY,
	Title_name VARCHAR(6))"; 
	$expenditure = $db->query($expenditure);
	$db = null;


	$query = "INSERT INTO `title` SET
					`Title_id`= 1,
					`Title_name`='Mr.'";
	insert($query);
	$query = "INSERT INTO `title` SET
					`Title_id`= 2,
					`Title_name`='Mrs.'";
	insert($query);
	$query = "INSERT INTO `title` SET
					`Title_id`= 3,
					`Title_name`='Miss.'";
	insert($query);
	$query = "INSERT INTO `title` SET
					`Title_id`= 4,
					`Title_name`='Other'";
	insert($query);
	?>


