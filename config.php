<?php
$server='localhost';
$user='shabin';
$pass='Shabin#msd7';
$db='phpmyadmin';

define('DB_NAME', 'phpmyadmin');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect($server,$user,$pass,$db);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
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
$diff=floor(($d2-$d1)/60/60/24);
$dots=str_repeat(".",$diff);
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
?>
