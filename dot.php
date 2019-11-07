<?php
require_once "config.php";
$sql="select date_string from save_date";
$exec=mysqli_query($link,$sql);
if(!exec)
{
	die("Something went wrong.");
}
$row=mysqli_fetch_array($exec);
$d1=strtotime($row[0]);
$today=date("Y-m-d");
$d2=strtotime($today);
$diff=floor(abs($d1-$d2)/60/60/24);
$dots=str_repeat(".",$diff);
echo $dots;
$sql="update attend_register set attend_string=concat(attend_string,'".$dots."')";
$exec=mysqli_query($link,$sql);
if(!$exec)
{
	die("error updating database");
}
$sql="update save_date set date_string='".$today."'";
$exec=mysqli_query($link,$sql);
if(!exec)
{
	die("error updating database");
}
else
{
	echo "success";
}



?>
