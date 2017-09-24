<!DOCTYPE html>
<html>
<head>
<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}

</style>
</head>
<body>

<!--<script src ="jquery.js"></script>

<script> 
    $(document).ready(function()
{
	$("#fetchval").on("change", function()
	{
		var value = $(this).val();
		$.ajax(
		{
			url:'fetch.php',
			type:'POST',
			data:'request='+value,
			beforeSend:function()
			{
				$("#table-container").html('Loading.... ');
			},
			success:function(data)
			{
				$("#table-container").html(data);
			};
	}) ;
});
});

</script> 
 <div id= "ab"> Filter By: </div><select id= "fetchval" value="fetchby">
<option value = "UG"> Undergraduate </option>
<option value = "GR"> Graduate </option>
</select>
<br>
<br>
<br>-->
<div id="table-container">
<?php

	
require_once 'connect.php';
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die ($conn->connect_error);


$field='id';
$sort='ASC';
if(isset($_GET['sorting']))
{
  if($_GET['sorting']=='ASC')
  {
  $sort='DESC';
  }
  else { $sort='ASC'; }
}
if(isset($_GET['field']))
{ 
if($_GET['field']=='id')
{
    $field = "id";  
}
elseif($_GET['field']=='AcademicYear')
{ 
    $field = "AcademicYear";  
}
elseif($_GET['field']=='Term')
{
   $field = "Term"; 
}
elseif($_GET['field']=='LastName')
{ 
   $field="LastName"; 
 
}
elseif($_GET['field']=='FirstName')
{
   $field = "FirstName"; 
}
elseif($_GET['field']=='Major')
{ 
   $field="Major"; 
}
elseif($_GET['field']=='LevelCode')
{ 
   $field="LevelCode"; 
}
elseif($_GET['field']=='Degree')
{ 
   $field="Degree"; 
}
}
;

$query = "SELECT * FROM wb_longpre.csdegrees ORDER BY $field $sort";
$result = $conn->query($query);
if (!$result) die($conn->error);


echo '<table id ="myTable">';
echo '<tr class = "header">';

echo '<th><a href="indexx.php?sorting=<?php echo $sort ?>&field=id">ID NO</a></th>';
echo '<th><a href="indexx.php?sorting=<?php echo $sort ?>&field=AcademicYear">Academic Year</a></th>';
echo '<th><a href="indexx.php?sorting=<?php echo $sort ?>&field=Term"> Term </th>';
echo '<th> <a href="indexx.php?sorting=<?php echo $sort ?>&field=LastName">Last Name </th>';
echo '<th> <a href="indexx.php?sorting=<?php echo $sort ?>&field=FirstName">First Name </th>';
echo '<th> <a href="indexx.php?sorting=<?php echo $sort ?>&field=Major">Major </th>';
echo '<th> <a href="indexx.php?sorting=<?php echo $sort ?>&field=LevelCode">Level Code </th>';
echo '<th> <a href="indexx.php?sorting=<?php echo $sort ?>&field=Degree">Degree </th>';
echo '</tr>';



$rows = $result->num_rows;
for ($j = 0 ; $j < $rows ; ++$j)
{
$result->data_seek($j);
$row = $result->fetch_array(MYSQLI_ASSOC);

echo '<tr>';
echo '<td>' . $row['id'] .'</td>';
echo '<td>' . $row['AcademicYear'] .'</td>';
echo '<td>' . $row['Term'] .'</td>';
echo '<td>' . $row['LastName'] .'</td>';
echo '<td>' . $row['FirstName'] .'</td>';
echo '<td>' . $row['Major'] .'</td>';
echo '<td>' . $row['LevelCode'] .'</td>';
echo '<td>' . $row['Degree'] .'</td>';
echo '</tr>';


};
echo '</table>';
$result->close();
$conn->close();


?>

</body>
</html>