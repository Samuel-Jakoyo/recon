<?php
//DB details
$host = "localhost";
$username = "root";
$password = "";
$db = mysqli_connect($host,$username,$password);

//creating the database
$query = "create database if not exists bankrecon";
//running the query
$result = mysqli_query($db,$query);


//selecting the database
$select = mysqli_select_db($db,"bankrecon");

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}
?>