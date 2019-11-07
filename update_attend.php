<?php
require_once "config.php";
$data=$_POST['absent'];
$students=array_keys($_POST['absent']);
$sql1="update attend_register set attend_string=concat(attend_string,1) where student_id in (";
$sql2="update attend_register set attend_string=concat(attend_string,0) where student_id in (";
foreach($students as $s)
{
	if($data[$s]==1)
	{
		$sql2.="'".$s."',";
	}
	else
	{
		$sql1.="'".$s."',";
	}
}
$sql1=substr($sql1, 0, -1);
$sql2=substr($sql2, 0, -1);
$sql1.=")";
$sql2.=")";
$exec1=mysqli_query($link,$sql1);
if(!$exec)
{
	die("Error updating database");
}
$exec2=mysqli_query($link,$sql2);
if(!$exec)
{
	die("Error updating database");
}
echo "Success!";
?>

