<?php
include 'DBConfig.php';

$msg= '';
if(!empty($_GET['st']))
{
    if($_GET['st'] == 'success')
    {
        $msg = 'Statement has been uploaded successfully.';
    }
    else if($_GET['st'] == 'error')
    {
        $msg = 'Some problem occurred. Please try again.';
    }
    else if($_GET['st'] == 'invalid_file')
    {
        $msg = 'Please upload a valid CSV file.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bank Reconciliation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style1.css">

    <script src="js/js1.js"></script>
    <script src="js/js2.js"></script>
    <style type="text/css">
        a:link, a:visited, a:active{
            color: #4C14FC;
        }
        a:hover{
            color: #8816E1  ;
        }
        #importFrm{
            margin-bottom: 20px;
            display: none;
        }
        #importFrm input[type=file] {
            display: inline;
        }
        #n{
            color: black;
            text-decoration: none;
        }
    </style>
	<style>
	.button{
		 background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
	}
	</style>
    </head>

    <body>
        <?php include"navigation.php"; ?>
        <div class="container">

            <h2 align="center" style="margin-top:55px">Bank Statement</h2>
            
        
    <div class="panel">
        
        <?php
        if($msg == '')
        {
            
        }
        else if($msg=='Statement has been uploaded successfully.'){ ?>
            <div id="deletesuccess" style="display:inline-block; float:right; background-color: #ABEBC6; padding: 10px 40px 10px 40px; width: 100%; border: 0px solid; border-radius=10%;">
                <?php echo $msg; ?>
            </div>
            <?php }
            else{?>
            <div id="deletesuccess" style="display:inline-block; float:right; background-color: #F5B7B1; padding: 10px 40px 10px 40px; width: 100%; border-radius=5%;">
                <?php echo $msg; ?>
            </div>
            <?php } ?>
        
        <div class="panel-body" id="maindiv">
            <a href="javascript:void(0);" onclick="$('#importFrm').slideToggle();" style="font-size:18px; text-decoration:none;">Import Bank Statement</a>

            <form action="importbankstatement.php" method="post" enctype="multipart/form-data" id="importFrm">
                Select the Bank Statement you wish to upload:<br/>
               <br />
                <input type="file" name="file" />
                <input type="submit" class="btn btn-warning btn-small" name="importSubmit" value="Import">
            </form>

                        <p style="visibility:hidden"> This is for new line</p>            
            <script type="text/javascript"> 
                $(document).ready( function() {
                    $('#deletesuccess').delay(2000).fadeOut();
                });
            </script>
			<form action="functions.php" method="post">
          <table class="table" border="1px groove" style="border-color: #85929E">
		  <button type="submit" style="float:right" class="button" name="clear_bank">Clear Records</button>
		  <button type="submit" style="float:right" class="button" name="bank_btn">Move Records</button>
		  <button type="submit" style="float:right"  class="button" name="unreconbs">Bring Unreconciled</button>
                <thead>
                    <tr border="1px">
                        <th>Date</th>
                        <th>Description</th>
                        <th>Cheque/Ref. No.</th>
                        <th>Debit</th>
                        <th>Credit</th>
						<th>Account No.</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //get rows query
                    $query = $db->query("SELECT * FROM bankstatement");
                    if($query->num_rows > 0){ 
                        while($row = $query->fetch_assoc()){
                            if($row['status'] == 0)
                            {
								$_SESSION['bank']= $row["accountno"];
                        ?>
                    <tr style="background-color: #FDEDEC">
                        <td><?php echo $row['bdate']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['referenceno']; ?></td>
                        <td><?php echo $row['debit']; ?></td>
                        <td><?php echo $row['credit']; ?></td>
						<td><?php echo $row['accountno']; ?></td>
                        <td>Unreconciled</td>
                    </tr>
                    <?php
                            }
                            else
                            {
                            ?>
                    <tr style="background-color: #E8F8F5">
                        <td><?php echo $row['bdate']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['referenceno']; ?></td>
                        <td><?php echo $row['debit']; ?></td>
                        <td><?php echo $row['credit']; ?></td>
                        <td><?php echo $row['accountno']; ?></td>
						<td>Reconciled</td>
                    </tr>
                    <?php
                            }
                            ?>
                    <?php } }else{ ?>
                    <tr><td colspan="8">No statement(s) to be displayed...</td></tr>
                    <?php } ?>
					<?php  ?>
                </tbody>
            </table>
        </form>
		</div>
    </div>
</div>

</body>
</html>
