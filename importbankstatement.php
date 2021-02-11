<?php

include("DBConfig.php"); 
  //connect to database
if(isset($_POST['importSubmit']))
{
	if($_FILES['file']['name'])
	{
		$filename = explode(".", $_FILES['file']['name']);
		if($filename[1]=='csv')
		{
			if ($_FILES['file']['size'] > 5000000)  //filesize greater than MB
			{
				$size = $_FILES['file']['size'];
				$calc = ($size/1000);
				echo 'Sorry, the file '.$_FILES['file']['name'].' is too large! ('.$calc.'KB)<br><br>';
				return;
			}
		
			$handle = fopen($_FILES['file']['tmp_name'], "r");
			while ($data = fgetcsv($handle))
			{
				 //insert into database
		        $bdate = mysqli_real_escape_string($db,$data[0]);
				$description = mysqli_real_escape_string($db,$data[1]);
				$referenceno = mysqli_real_escape_string($db,$data[2]);
				$debit = mysqli_real_escape_string($db,$data[3]);
				$credit = mysqli_real_escape_string($db,$data[4]);
				$accountno = mysqli_real_escape_string($db,$data[5]);
				$query = "insert into bankstatement(bdate, description, referenceno,debit,credit,accountno) values('$bdate','$description','$referenceno','$debit','$credit','$accountno')";
				//echo "<br>$sql";
				$result = mysqli_query($db,$query) or die(mysqli_error($db)."...at line- ". __LINE__);
				
			}
			}
			fclose($handle);
			echo "IMPORT DONE!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
		}
		else
		{
			echo 'Kindly upload a csv file only!';
		}
	}
mysqli_close($db);

header("location:bank_statement.php");
?>
