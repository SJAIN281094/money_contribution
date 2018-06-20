<?php
	require_once("connect_db.php"); 
// Create database signup
	$db = new mysqli();
	$db->connect("localhost","root","budget_123");
	if (!$db->connect_error){
		$database = "CREATE DATABASE `moneycontribution`";
		$dat = $db->query($database);
	$db->close();
 	} 
 	else{
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
		Up_id INT UNSIGNED AUTO_INCREMENT,
		FOREIGN KEY(Up_id) REFERENCES user_profile_required(Upr_id),
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
		Friends_id INT(5),
		Grpname_id VARCHAR(15))";
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

	// Create table to store expenditure values
	$db = new mysqli();
	$db->connect("localhost","root","budget_123","moneycontribution");
	$expenditure = "CREATE TABLE expenditure(
	Expenditure_id INT AUTO_INCREMENT PRIMARY KEY,
	Date VARCHAR(10),
	Description VARCHAR(30),
	Group_select VARCHAR(15),
	Paid_by_id INT(5),
	Amount_paid INT(8))"; 
	$expenditure = $db->query($expenditure);
	$db->close();
	

	//Title table
	$db = new mysqli();
	$db->connect("localhost","root","budget_123","moneycontribution");
	$expenditure = "CREATE TABLE title(
	Title_id INT AUTO_INCREMENT PRIMARY KEY,
	Title_name VARCHAR(6))"; 
	$expenditure = $db->query($expenditure);
	$db->close();


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


