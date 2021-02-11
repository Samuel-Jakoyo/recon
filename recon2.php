<?php
session_start();
include 'DBConfig.php';

if(isset($_POST['Submit']))
{
	reconcile();
}



function reconcile(){
include 'DBConfig.php';	
	
if(isset($_POST['reconciled']) && (isset($_POST['reconciled2']))){	

	
 $recon1 = ($_POST['reconciled']);
	
 $recon2 = ($_POST['reconciled2']);
 
 $result = array_intersect($recon1,$recon2);
 
 ($result);

 if($result){
 $bank = implode(",",$result);
 $cash = implode(",",$result);

 $query="SELECT  bankstatement.referenceno,bankstatement.debit,bankstatement.credit,bankstatement.status,cashbook.referenceno,
		cashbook.debit,cashbook.credit,cashbook.status
            FROM   bankstatement CROSS JOIN
                         cashbook
						where '$bank' = '$cash' and cashbook.credit = bankstatement.debit and cashbook.debit = bankstatement.credit and bankstatement.status = '0' and cashbook.status = '0' ";
						
 $res= mysqli_query($db,$query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error(),E_USER_ERROR);
 

	if($res){
	// The back account numbers to update
$bank_accounts= explode(',',$bank);

// Preparing the parameters for the prepared statement
$clause = implode(',', array_fill(0, count($bank_accounts), '?'));

$types = implode('', array_fill(0, count($bank_accounts), 's'));
$bank_accounts = array_merge([$types], $bank_accounts);

$to_prepare = [];
foreach($bank_accounts as $key => $value) {
   $to_prepare[$key] = &$bank_accounts[$key];
}

// Preparing the statement
$stmt = $db->prepare("update bankstatement 
                     set status='1' 
                     where 
                        status='0' 
                     and 
                        referenceno in($clause)
                     ");

// always check whether the prepare() succeeded 
if ($stmt === false) {
  trigger_error($db->error, E_USER_ERROR);
  return;
}

// bind the bank accounts to the parameters
call_user_func_array(array($stmt, 'bind_param'), $to_prepare );

// Update all the rows
$stmt->execute();

// The cash record numbers to update
$cash_accounts= explode(',',$cash);

// Preparing the parameters for the prepared statement
$clause = implode(',', array_fill(0, count($cash_accounts), '?'));

$types = implode('', array_fill(0, count($cash_accounts), 's'));
$cash_accounts = array_merge([$types], $cash_accounts);

$to_prepare = [];
foreach($cash_accounts as $key => $value) {
   $to_prepare[$key] = &$bank_accounts[$key];
}

// Preparing the statement
$stmt = $db->prepare("update cashbook 
                     set status='1' 
                     where 
                        status='0' 
                     and 
                        referenceno in($clause)
                     ");

// always check whether the prepare() succeeded 
if ($stmt === false) {
  trigger_error($db->error, E_USER_ERROR);
  return;
}

// bind the bank accounts to the parameters
call_user_func_array(array($stmt, 'bind_param'), $to_prepare );

// Update all the rows
$stmt->execute();
	
	echo "<script>
		alert('Success in Reconciling Process!!!');
		window.location.href='viewreconcile.php';
		</script>
        ";
	}else{
		echo "<script>
		alert('Error in Reconciling Process!!!');
		window.location.href='managereconcile.php';
		</script>
        ";
	}
	}
 }
}

 ?>