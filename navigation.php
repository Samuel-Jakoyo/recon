<?php
//include 'DBConfig.php';
include 'functions.php';

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}	
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.navbar {
    overflow: hidden;
    background-color: #ccccb3;
    font-family: Arial, Helvetica, sans-serif;
}

.navbar a {
    float: left;
    font-size: 16px;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.dropdown {
    float: left;
    overflow: hidden;
}

.dropdown .dropbtn {
    cursor: pointer;
    font-size: 16px;    
    border: none;
    outline: none;
    color: black;
    padding: 14px 16px;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn, .dropbtn:focus {
    background-color: #66a3ff;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

.show {
    display: block;
}
</style>
</head>
<body>

<div class="navbar">
  <?php
if($_SESSION['user']['user_type']=== "admin" && ($_SESSION['user']['user_role']=== "admin")){?>
  <a href="bank_statement.php" id="n" class="w3-bar-item w3-button w3-border-right">Bank Statement</a>
  <a href="internal_statement.php" id="n" class="w3-bar-item w3-button w3-border-right">Internal Statement</a>
   <a href="managereconcile.php" id="n" class="w3-bar-item w3-button w3-border-right">Reconciliation</a>
  <a href="viewreconcile.php" id="n" class="w3-bar-item w3-button w3-border-right">Reconciled records</a>
  <a href="viewunreconcile.php" id="n" class="w3-bar-item w3-button w3-border-right">Unreconciled Records</a>		
  <?php
 }elseif($_SESSION['user']['user_type']==="user" && ($_SESSION['user']['user_role']=== "financedept")){?>
  <a href="user.php" id="n" class="w3-bar-item w3-button w3-border-right">Back</a>
  <a href="bank_statement.php" id="n" class="w3-bar-item w3-button w3-border-right">Bank Statement</a>
  <a href="internal_statement.php" id="n" class="w3-bar-item w3-button w3-border-right">Internal Statement</a>
  <a href="managereconcile.php" id="n" class="w3-bar-item w3-button w3-border-right">Reconciliation</a>
  <a href="viewreconcile.php" id="n" class="w3-bar-item w3-button w3-border-right">Reconciled records</a>
  <a href="viewunreconcile.php" id="n" class="w3-bar-item w3-button w3-border-right">Unreconciled Records</a>
  <a href="changepassword.php" id="n" class="w3-bar-item w3-button w3-border-right">Change Information</a>
 <?php
}
 elseif($_SESSION['user']['user_type']==="user" && ($_SESSION['user']['user_role']=== "guest")){?>
	<a href="user.php" id="n" class="w3-bar-item w3-button w3-border-right">Back</a>
    <a href="viewreconciled.php" id="n" class="w3-bar-item w3-button w3-border-right">Reconciled Records</a>
    <a href="viewunreconciled.php" id="n" class="w3-bar-item w3-button w3-border-right">Unreconciled Records</a>
	<a href="changepassword.php" id="n" class="w3-bar-item w3-button w3-border-right">Change Information</a>
			<?php
			}
			?>
</div>


<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {
    var myDropdown = document.getElementById("myDropdown");
      if (myDropdown.classList.contains('show')) {
        myDropdown.classList.remove('show');
      }
  }
}
</script>
</body>
</html>
