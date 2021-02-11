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
 
 $query ="UPDATE
    cashbook c
CROSS JOIN bankstatement b ON
    c.referenceno = b.referenceno
SET
    b.status = '1',
    c.status = '1'
WHERE
    c.referenceno = b.referenceno AND b.credit = c.debit AND b.debit = c.credit AND b.status = '0' AND c.status = '0' AND b.accountno = c.accountno
";
 $result = mysqli_query($db,$query);
 echo "<script>
		alert('Success in Reconciling Process!!!');
		window.location.href='bank_statement.php';
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
?>