<?php
require_once "config.php";
$sql="select start_date from save_date";
$exec=mysqli_query($link,$sql) or die("Connect Error: ".mysqli_connect_error());
$start_date=date_create(mysqli_fetch_array($exec)[0]);
$sql="select attend_string from attend_register where student_id='B170173CS' and course_id=1";
$exec=mysqli_query($link,$sql);
$attend=str_split(mysqli_fetch_array($exec)[0]);
$present_count=$absent_count=0;
$days_count=-1;
$abdates=array();
foreach($attend as $a)
{
	if($a=='.')
	{
		$days_count++;
	}
	elseif($a=='0')
	{
		$absent_count++;
		date_add($start_date,date_interval_create_from_date_string($days_count." days"));
		array_push($abdates,date_format($start_date,"Y-m-d"));
                 date_format($start_date,"Y-m-d")."<br>";
                date_sub($start_date,date_interval_create_from_date_string($days_count." days"));

	}
	else
	{
		$present_count++;
	}

}
?>
