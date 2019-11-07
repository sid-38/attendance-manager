<?php
require_once "config.php";
$data=$_POST['absent'];
$students=array_keys($_POST['absent']);
if(isset($students))
{
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
else
{
	echo "Successfully updated";
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style type="text/css">
	.btn-primary.active{
		background: red !important;
	}
</style>

</head>

<body>

<h1 style="text-align: center;"> Attendance Register </h1>
<div class="container" style="margin-top: 124px; font-size: 24px;"> 


<form style="text-align: center;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class='col-lg-12' data-toggle='buttons'>



<?php
require_once "config.php";
//$course=$_POST['course'];
$course=4;
$sql="select distinct(student_name),s.student_id from attend_register as a,student as s where a.student_id=s.student_id and course_id=".$course;
$exec=mysqli_query($link,$sql);
if(!exec)
{
        die("Something went wrong");
}
while($result=mysqli_fetch_array($exec))
{
	echo 
	"<div class='row btn-group btn-group-toggle col-lg-12'>
			<p class='col-lg-3 col-lg-offset-4' style='text-align: center;'>".$result[0]."</p>
			<input type='hidden' name='absent[".$result[1]."]' value=0>
			<label class='btn btn-primary  col-lg-1' onclick='this.previousSibling.value=1-this.previousSibling.value'>
			<input type='checkbox' name='options' autocomplete='off'><span> Present </span>
			</label>
			</div>";
}
?>
</div>


	<script>

	$('label').click(function() {
		var checked = $('input',this).is(':checked');
		$('span',this).text(checked ? 'Present':'Absent');

		});

	</script>


    
    <input type="submit" name="submit" Value="Submit" style="margin: 32px;" />
    </div>
</form>




	

	
</body>

</html>
