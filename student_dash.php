<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: login.php");
	exit;
}
else
{
	$student_id=$_SESSION['student_id'];
}
?>

<head>
	<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>

<body style="color:blue;background-color: papayawhip">
	
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="student_dash.php">Attendance Portal</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>


<div class="card " style="vertical-align: center; width: 800px; margin: auto; margin-top: 100px;">
        <div class="card-body">
        <h4 class="card-title" style="margin-bottom: 32px; text-align: center;" >Course Attendance</h4>    
        <div class="list-group" id="accordion">


<?php
require "config.php";
$sql="select course_name from attend_register as a,courses as c where a.course_id=c.course_id and a.student_id='".$student_id."'";
$exec=mysqli_query($link,$sql);
$i=1;
while($data=mysqli_fetch_array($exec)[0])
{
	echo '<div onclick="loadDoc(this)"><a href="#collapse'.$i.'"  data-toggle="collapse" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">'.$data.' 
	<span id="loading" style="visibility:hidden; float:right;"><span class="spinner-border" role="status">
	<span class="sr-only">Loading...</span>
	</span>
	</span><span class="badge badge-success badge-pill">14</span></a>
	<div id="collapse'.($i++).'" class="collapse hide card" data-parent="#accordion">      
	<div class="card-body" id="card">
	</div>
	</div>
	</div>';
}
?>
  
	</div>
	</div>
</div>




<script>
function loadDoc(obj) {
	var content=obj.querySelector('#card');
  var loading=obj.querySelector('#loading');
  var s="shabin";
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      content.innerHTML =
              this.responseText;
	loading.style.visibility = 'hidden';
    }
    else
    {
	loading.style.visibility = '';
	    

    }

  };
  xhttp.open("POST", "con.php", true);
  xhttp.send();
}
</script>




</body>


</html>
