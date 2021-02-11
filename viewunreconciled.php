<?php
include 'DBConfig.php';
//include 'navigation.php';

$sql = "select * 
        from bankstatement
		where status = '0'";

$query = "select *
         from cashbook
		 where status = '0'";

// Grab the records
$res = mysqli_query($db,$sql);
$result = mysqli_query($db,$query);

//  Default the type to HTML
$type = 'html';
if (isset($_GET['type']) && $_GET['type'] == 'csv') {
	// If the type is set to csv, then override to csv.
	$type = 'csv';
}


// Determine if the file should be shown as a table, or saved to excel.
if (isset($_GET['download']) && $type == 'csv') {
	$filename = "file_" . date("Y-m-d") . ".csv";

	// Send HTTP headers to tell the browser what type of file this is for download.
	header("Content-type: text/csv");
	header("Content-disposition: attachment; filename=$filename");

} elseif (isset($_GET['download']) && $type == 'html') {
	// Fake an Excel file by sending HTML data to Excel.
	// Excel will import it after a warning.
	$filename = "file_" . date("Y-m-d") . ".xls";

	// Send HTTP headers to tell the browser what type of file this is for download.
	header("Content-type: application/vnd.excel");
	header("Content-disposition: attachment; filename=$filename");

} else {

 // if Download is not set, display an HTML form to help demo this.
 ?>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
		Select type of format: 
			<select name="type">
				<option value="excel" <?php echo $type == 'html' ? 'selected="selected"' : ''?>>excel</option>
				<option value="csv"  <?php echo $type == 'csv'  ? 'selected="selected"' : ''?>>csv</option>
			</select>
		Download a file? <input type="checkbox" name="download" value="yes"> Yes
		<input type="submit" value="Download">
	</form>
	Currently: <?php echo $type ?>
	<hr>
	<!-- Output of actual file starts here. Delete everything above including this line if you want to save the data. -->
 <?php
 }


if ($type == 'csv') {
	// If the type is CSV, first print out the headers
	echo "Date,Description,Cheque/Ref No,Debit,Credit\n";
	
	// Then loop over the results, keeping commas in between the records.
	// Something to consider: 
	// 		What do you do when the data for the synopsis has a comma in it??
	while ($row = $res->fetch_assoc()) {
		echo $row['date'] . ",";
		//echo $row['description'] . ",";
		echo $row['referenceno'] . ",";
		echo $row['debit'];
		echo $row['credit'] . ",";
		echo "\n";
	}

} else {
	// Otherwise, print out some HTML tables for the content.
	// Excel will read this table and auto-import it into rows and columns.
	?>
	<style>
	table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

tr:hover {background-color:#f5f5f5;}
	</style>
		<table>
		<tr>
		    <h2>Bank Statement</h2>
			<th>Date</th>
			<th>Description</th>
			<th>Cheque/Ref no</th>
			<th>Debit</th>
			<th>Credit</th>
		</tr>
		<?php 
			while ($row = $res->fetch_assoc()) {
			?>
				<tr>
					<td><?php echo $row['bdate'];?></td>
					<td><?php echo $row['description'];?></td>
					<td><?php echo $row['referenceno'];?></td>
					<td><?php echo $row['debit'];?></td>
					<td><?php echo $row['credit'];?></td>
				</tr>	
			<?php
			}
		?>
		</table>
	<?php
 }
?>
      <table>
		<tr>
		    <h2>Internal Statement</h2>
			<th>Date</th>
			<th>Description</th>
			<th>Cheque/Ref no</th>
			<th>Debit</th>
			<th>Credit</th>
			<th>Created By</th>
		</tr>
		<?php 
			while ($row1 = $result->fetch_assoc()) {
			?>
				<tr>
					<td><?php echo $row1['cdate'];?></td>
					<td><?php echo $row1['description'];?></td>
					<td><?php echo $row1['referenceno'];?></td>
					<td><?php echo $row1['debit'];?></td>
					<td><?php echo $row1['credit'];?></td>
					<td><?php echo $row1['created'];?></td>
				</tr>	
			<?php
			}
		?>
		</table>
<a href="viewreconciled.php"><button class="btn-primary">Back</button></a>