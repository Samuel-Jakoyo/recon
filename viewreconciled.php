<?php
include 'DBConfig.php';
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
    </head>

    <body>
        <?php include"navigation.php"; ?>
        <div class="container">

            <h2 align="center" style="margin-top:55px">Bank Statement</h2>
            
        
    <div class="panel">
        
		<div class="panel-body" id="maindiv">
          <table class="table" border="1px groove" style="border-color: #85929E">
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
				$res = $db->query("SELECT * FROM reconbs");
	            $count = $res->num_rows;

	            if($count > 0){
					while($row=$res->fetch_assoc())
					{
						if($row['status'] == 1 ){
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
				}
				}
				else
				{
					?>
                    <tr><td colspan="8">No statement(s) to be displayed...</td></tr>
				<?php } ?>
                </tbody>
            </table>
        </div>
    </div>

        <div class="container">
            <h2 align="center" style="margin-top:55px">Internal Statement</h2>
            
        
    <div class="panel">
            <table class="table" border="1px groove" style="border-color: #85929E">
                <thead>
                    <tr border="1px">
                        <th>Date</th>
                        <th>Description</th>
                        <th>Cheque/Ref. No.</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Account No.</th>
                        <th>Branch Code</th>
						<th>Created By</th>
						<th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //get rows query
                    $query = $db->query("SELECT * FROM reconcb");
                    if($query->num_rows > 0){ 
                        while($row = $query->fetch_assoc()){
                            if($row['status'] == 1)
                            {
                            ?>
                    <tr style="background-color: #E8F8F5">
                        <td><?php echo $row['cdate']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['referenceno']; ?></td>
                        <td><?php echo $row['debit']; ?></td>
                        <td><?php echo $row['credit']; ?></td>
                        <td><?php echo $row['accountno']; ?></td>
						<td><?php echo $row['branchcode']; ?></td>
						<td><?php echo $row['createdby']; ?></td>
                        <td>Reconciled</td>
                    </tr>
                    <?php
                            }
                            ?>
						<?php } }else{ ?>
                    <tr><td colspan="8">No statement(s) to be displayed...</td></tr>
                    <?php } ?>
                </tbody>
            </table>
</div>
</div>
</div>
</body>
</html>
