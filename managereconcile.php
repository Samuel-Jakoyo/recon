<?php
include 'DBConfig.php';

if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusMsgClass = 'alert-success';
            $statusMsg = 'Statement has been uploaded successfully.';
            break;
        case 'err':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg = '';
    }
}
		
?>
<html lang="en">
    <head>
        <title>Reconciliation</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/style1.css">
        <link rel="stylesheet" type="text/css" href="css/style2.css">
        <script src="js/js1.js"></script>
        <script src="js/js2.js"></script>
        <script src="js/js3.js"></script>
		<script src="js/js4.js"></script>
		<script src="jquery.js" type="text/javascript"></script>
		<script src="js-script.js" type="text/javascript"></script>
		
		
        <script>
            x = 0;
            function myFunction(a)
            {
                if (x==0)
                {
                    document.getElementById(a).innerHTML = a;
                    x = 1;
                }
                else
                {
                    b = a.substring(0, 8);
                    document.getElementById(a).innerHTML = b;
                    x = 0;
                }
            }
        </script>
	
  
        <style>
            table, td, th
            {
                font-size: 11px;
            }
            td 
            {
                text-align: center;
                vertical-align: middle;
            }
        </style>
        
        <style>
            /* The Modal (background) */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 52; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
                background-color: #fefefe;
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
            }

            /* The Close Button */
            .close {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }
        </style>
        
        <style>
            a:link, a:visited, a:active, a:hover{
                color: #fff;
                text-decoration: none;
            }
            li a, .dropbtn {
                display: inline-block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }
            li a:hover, .dropdown:hover .dropbtn {
                background-color: #1A5276;
            }
            #n{
                color: black;
            }
            #fixButton{
                position: fixed;
                z-index: 50;
                top: 40px;
                left: 0px;
                background-color: white;
                height: 80px;
                width: 100%;
			}
        </style>
    </head>
    
    <body>
        <?php include"navigation.php"; ?>
       
        <div id="myModal" class="modal">

          <!-- Modal content -->
            <div class="modal-content">
                <script language="JavaScript">
                    function toggle(source) {
                        checkboxes = document.getElementsByName('cashEntry[]');
                        for(var i=0, n=checkboxes.length;i<n;i++) {
                            checkboxes[i].checked = source.checked;
                        }
                    }
                </script>
                <input type="checkbox" onClick="toggle(this)" />Check/ Uncheck all<br/>
                <span class="close">&times;</span>
            </div>
        
        </div>

        <script>
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal 
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
        
        <form name="form1" action="recon.php" method="post" id="manage">
            <div class="container-fluid" style="margin-top: 5%">
                <?php
                if(!empty($statusMsg))
                {
                    echo '<div class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
                }
                ?>
              
              <div class="row" style="margin-top: 3%; padding-top:25px; margin-right:1px; margin-left:1px">

                <div class="col-sm-6" style="background-color:#FCF3CF" style="padding-top: 10px;">
                        <h3 align="center">Bank Statement Records</h3><br />
                        <div class="table-responsive">
                          <label> <input type="checkbox" class="all" value="all"/>Check / Uncheck all</label>
                            <table  id="preTable" class="table table-striped">
                                
                                <thead>
                                    
                                    <tr>
                                        <th>Date</th>
                                        <th>Cheque/Ref.</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
										<th>Account No.</th>
                                        <th>Rec.</th>
                                    </tr>
                                    
                                </thead>
                                
                                <tbody>
                                    <?php
                                    //require("filedata.php");
                                    $sql = "SELECT * FROM bankstatement";
                                    $result  = mysqli_query($db,$sql);
                                    if($result->num_rows > 0)
                                    {
                                        while($row=mysqli_fetch_array($result))
                                        {
                                            if($row['status'] == 0)
                                            {
                                    ?>
                                    
                                    <tr>
                                        <td>
                                            <?php
                                                $bdate = $row[1];
                                                echo substr("$bdate", 0, 10);
                                            ?>
                                        </td>
                                        <?php $referenceno = $row[3];?>
                                        <td onclick="myFunction('<?php echo $referenceno; ?>');">
                                            <span id="<?php echo $referenceno; ?>">
                                                <?php
                                                echo substr("$referenceno", 0, 18);
                                                ?>
                                            </span>
                                        </td>
                                        <td><?php echo $row[4]; ?></td>
                                        <td><?php echo $row[5]; ?></td>
										<td><?php echo $row[6];?></td>
                                        <td>
										<input type="checkbox" name="reconciled[]" value="<?php echo $row['referenceno'] ?>"><br><label for="reconcile bank stmt"></label>
                                        </td>
                                    </tr>
                                    
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
								
                            </table>
                        </div>
                    </div>

					<script>
					
					</script>
                    <div class="col-sm-6" style="background-color:lavenderblush;">
                        <h3 align="center">Internal Statement Records</h3><br />
                        <div class="table-responsive">
                            
                            <table  id="preTable2" class="table table-striped" >
                                
                                <thead>
                                    
                                    <tr>
                                        <th>Rec.</th>
                                        <th>Date</th>
                                        <th>Cheque/Ref.</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
										<th>Account No.</th>
										<th>Branch Code</th>
                                       
                                    </tr>
                                </thead>
						  
                                <tbody>
                                    <?php
                                    //require("filedata.php");
                                    $sql = "SELECT * FROM cashbook";
                                    $result  = mysqli_query($db,$sql);
                                    if($result->num_rows > 0)
                                    {
                                        while($row=mysqli_fetch_array($result))
                                        {
                                            if($row['status'] == 0)
                                            {
                                    ?>
                                    
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="reconciled2[]" value="<?php echo $row['referenceno'] ?>"><br>
                                            <label for="reconcile cashbook record"></label>
                                        </td>
                                        
                                        <td>
                                            <?php
                                                $cdate = $row[1];
                                                echo substr("$cdate", 0, 10);
                                            ?>
                                        </td>                                        
                                        <?php $referenceno = $row[3];?>
                                        <td onclick="myFunction('<?php echo $referenceno; ?>');">
                                            <span id="<?php echo $referenceno; ?>">
                                                <?php
                                                echo substr("$referenceno", 0, 18);
                                                ?>
                                            </span>
                                        </td>
                                        
                                        <td><?php echo $row[4]; ?></td>
                                        <td><?php echo $row[5]; ?></td>
										<td><?php echo $row[6]?></td>
										<td><?php echo $row[7]?></td>
                                    </tr>
                                    
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
									<input type="submit" id="btn1" class="btn btn-primary" name="Submit" value="Reconcile Checked"style="float: right;">
                                </tbody>
								 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
              
                <script>
				$(document).ready(function(){
                    $('#preTable').dataTable({
                        "order": [[ 1, "desc" ]],
                        responsive: true
                    });
                    
                    $('#preTable2').dataTable({
                        "order": [[ 1, "desc" ]],
                        responsive: true
                    });
                });
				</script>
        </form>
    </body>
</html>
