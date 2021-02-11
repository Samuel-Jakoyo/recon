<?php 
session_start();

// connect to database
include 'DBConfig.php';

// variable declaration
$id = 0;
$update = false;
$username = "";
$user_type = "";
$user_role = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
	
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  mysqli_real_escape_string($db,$_POST['username']);
	$user_type   =  mysqli_real_escape_string($db,$_POST['user_type']);
	$user_role   =  mysqli_real_escape_string($db,$_POST['user_role']);
	$password_1  =  mysqli_real_escape_string($db,$_POST['password_1']);
	$password_2  =  mysqli_real_escape_string($db,$_POST['password_2']);
	$password    = password_hash($password_1, PASSWORD_DEFAULT);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
	
	$sql_u = "SELECT * FROM users WHERE username='$username'";
  	$sql_e = "SELECT * FROM users WHERE email='$email'";
  	$res_u = mysqli_query($db, $sql_u);
  	$res_e = mysqli_query($db, $sql_e);

  	if (mysqli_num_rows($res_u) > 0) {
  	  array_push($errors, "Sorry... username already taken"); 	
  	}else if(isset($_POST['user_type'])) {
			$user_type = mysqli_real_escape_string($db,$_POST['user_type']);
			$query = "INSERT INTO users (username,user_type,user_role, password) 
					  VALUES('$username','$user_type','$user_role', '$password')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: admin/create_user.php');
		}else{
			$query = "INSERT INTO users (username,user_type,user_role,password) 
					  VALUES('$username','admin','admin','$password')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: login.php');				
		}
	}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE userid=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}


function userTypes()
{
	include 'DBConfig.php';
$username = mysqli_real_escape_string($db,$_POST['username']);
$query = "select * from users where username = '$username'";
$results = mysqli_query($db,$query);
if(mysqli_num_rows($results) == 1){
	
	//user found
	//check if user is admin or user
	$logged_in_user = mysqli_fetch_assoc($results);
	if ($logged_in_user['user_type'] == 'admin'){
		
		$_SESSION['user'] = $logged_in_user;
		$_SESSION['success'] = "You are now logged in";
		header('location: admin/home.php');
	}else{
		$_SESSION['user'] = $logged_in_user;
		$_SESSION['success'] = "You are now logged in";
		header('location: user.php');
	}
 }else{
	 array_push($errors, "Wrong username/password combination");
 }
}

// LOGIN USER
function login(){
	global $db,$username,$errors;
	
	// grap form values
	$username = mysqli_real_escape_string($db,$_POST['username']);
	$password = mysqli_real_escape_string($db,$_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}
	
	// attempt login if no errors on form
	if (count($errors) == 0) {

		$query = "SELECT * FROM users WHERE username='$username'";
		$results = mysqli_query($db, $query);
		if(mysqli_num_rows($results) > 0)
		{
			while($row = mysqli_fetch_array($results))
			{
				if(password_verify($password,$row['password']))
				{
					userTypes();
					 $_SESSION['user_id']=$row["userid"];
				}
			}
		}
}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

function userRoles()
{
	if (count($errors) == 0) {

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['user_role']  == "$admin";		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['user_role']  == "$financedept";
			}
		}else {
		        $_SESSION['user'] = $logged_in_user;
				$_SESSION['user_role']  == "$guest";
		}
}
}

if(isset($_POST['bank_btn']))
{
		$query = "insert into reconbs
	          select bankstatement.*
			  from bankstatement
			  where status = '1'";
	$result = mysqli_query($db,$query);
	if($result){
		$sql = "delete from bankstatement where status = '1'";
		$exe = mysqli_query($db,$sql);
	}
	header("location: bank_statement.php");
}

if(isset($_POST['cash_btn']))
{
	$query = "insert into reconcb
	          select cashbook.*
			  from cashbook
			  where status = '1'";
	$result = mysqli_query($db,$query);
	if($result){
		$sql = "delete from cashbook where status = '1'";
		$exe = mysqli_query($db,$sql);
	}
	header("location: internal_statement.php");
}

if(isset($_POST['clear_bank']))
{
	$query = "insert into unreconbs
	          select bankstatement.*
			  from bankstatement
			  where status = '0'";
	$result = mysqli_query($db,$query);
	if($result){
		$sql = "delete from bankstatement";
		$exe = mysqli_query($db,$sql);
	}
header("location: bank_statement.php");
}

if(isset($_POST['unreconbs']))
{
	 $query = "insert into bankstatement (cdate,description,referenceno,debit,credit,accountno,branchcode)
               select unreconbs.cdate,unreconbs.description,unreconbs.referenceno,unreconbs.debit,unreconbs.credit,unreconbs.accountno,unreconbs.branchcode
                from unreconbs
                where status = '0';
                 delete from unreconbs
                 where status = '0';";
	   $result = mysqli_query($db,$query);
	   if($result){
		   header("location: bank_statement.php");
	   }
}

if(isset($_POST['clear_cash']))
{
	$query = "insert into unreconcb
	          select cashbook.*
			  from cashbook
			  where status = '0'";
	$result = mysqli_query($db,$query);
	if($result){
		$sql = "delete from cashbook";
		$exe = mysqli_query($db,$sql);
	}
header("location: internal_statement.php");
}

if(isset($_POST['unreconcb']))
{
	 $uncb = $_SESSION['cash'];
	 $query = "insert into cashbook (cdate,description,referenceno,debit,credit,accountno,branchcode,created)
               select unreconcb.cdate,unreconcb.description,unreconcb.referenceno,unreconcb.debit,unreconcb.credit,unreconcb.accountno,unreconcb.branchcode,unreconcb.created
                from unreconcb
                where accountno = '$uncb'";        
	   $result = mysqli_query($db,$query);
	   if($result){
		    $sql = "delete from unreconcb
                 where accountno = '$uncb';";
		    $exe = mysqli_query($db,$sql);
	   }
	   header("location: internal_statement.php");
}

if(isset($_POST['unreconbs']))
{
	 $unbs = $_SESSION['bank'];
	 $query = "insert into bankstatement (bdate,description,referenceno,debit,credit,accountno)
               select unreconbs.bdate,unreconbs.description,unreconbs.referenceno,unreconbs.debit,unreconbs.credit,unreconbs.accountno
                from unreconbs
                where accountno = '$unbs'";
	$result = mysqli_query($db,$query);
	if($result){
		 $sql = "delete from unreconbs
                 where accountno = '$unbs';";
	     $exe = mysqli_query($db,$sql);
	}
               header("location: bank_statement.php");    
	   }
	

if(isset($_POST['update']))
{
	$id = $_POST['id'];
	$username = mysqli_real_escape_string($db,$_POST['username']);
	$user_role = mysqli_real_escape_string($db,$_POST['user_role']);
	$user_type = mysqli_real_escape_string($db,$_POST['user_type']);
	$password_1 = mysqli_real_escape_string($db,$_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db,$_POST['password_2']);
	$password = password_hash($password_1,PASSWORD_DEFAULT);
	
	mysqli_query($db, "update users set username='$username', user_role='$user_role', user_type = '$user_type', password = '$password' where userid = '$id'");
	echo "<script>
		alert('User info successfully updated!!!');
		window.location.href='admin/create_user.php';
		</script>
        ";
    header("location:admin/create_user.php");
	}

if(isset($_GET['del']))
{
	$id = $_GET['del'];
	
	mysqli_query($db,"delete from users where userid = $id");
	echo "<script>
		alert('User info successfully deleted!!!');
		window.location.href='admin/create_user.php';
		</script>
        ";
	header("location:admin/create_user.php");
}


if(isset($_POST['update_user']))
{
	$id = mysqli_real_escape_string($db,$_POST['id']);
	$username = mysqli_real_escape_string($db,$_POST['username']);
	$password_1 = mysqli_real_escape_string($db,$_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db,$_POST['password_2']);
	$password = password_hash($password_1,PASSWORD_DEFAULT);
	mysqli_query($db, "update users set password = '$password' where userid = '$id'");
	header("location:user.php");
}
?>