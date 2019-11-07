<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fullname="";
$username = $password = $confirm_password = $who="";
$username_err = $password_err = $confirm_password_err = $who_err="";
$username=trim($_POST["username"]);
$fullname=$_POST['fullname'];
$who=$_POST['who'];
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT student_id FROM student WHERE student_id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username =$username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                }
	    } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
	    $sql = "INSERT INTO ".$who."(".$who."_id, password,".$who."_name) VALUES (?,?,?)";
	    echo $sql;
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password,$param_name);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_name=$fullname;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
            } else{
                echo "Something went wrong. Please try again later.";
            }
	}
	
         
	    // Close statement
	    mysqli_stmt_close($stmt);
	if($who=="student")
	{
    $sql = "INSERT INTO attend_register(student_id, course_id,attend_string) VALUES (?,?,?)";
    foreach($_POST['courses'] as $c)
    {
    if($stmt = mysqli_prepare($link,$sql))
    {
        mysqli_stmt_bind_param($stmt, "sis", $param_sid, $param_cid,$param_att);
         $param_sid=$username;
        $param_cid=$c;
        $param_att='';
         if(mysqli_stmt_execute($stmt)){
         }
         else{
                die( "Something went wrong. Please try again later");
            }

    }
    }
        mysqli_stmt_close($stmt);
        }
	else
	{

	$sql="insert into faculty_courses values(?,?)";
    foreach($_POST['courses'] as $c)
    {
    if($stmt = mysqli_prepare($link,$sql))
    {
        mysqli_stmt_bind_param($stmt, "si", $param_fid, $param_cid);
         $param_fid=$username;
        $param_cid=$c;
         if(mysqli_stmt_execute($stmt)){
         }
         else{
                die( "Something went wrong. Please try again later");
            }

    }
    }
    mysqli_stmt_close($stmt);
	}


    header("location:login.php");
}

    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	 <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" value="<?php echo $fullname; ?>">
            </div>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
	    </div>
<div>


<div class="form-group">
	<label>Courses Enrolled</label>
    <select name="courses[]" class="mdb-select colorful-select dropdown-primary md-form" multiple style = "height:200px; margin-bottom: 32px;">
<?php
$course_names=array();
require "config.php";
   $sql = "SELECT course_name FROM courses";
$result = mysqli_query($link,$sql);
   while($row = mysqli_fetch_array($result))
   {

   array_push($course_names,$row[0]);
   }
  for($i=0;$i<count($course_names);$i++)
 {
      echo '<option value="'.($i+1).'">'.$course_names[$i].'</option>';

  }
mysqli_close($link);

        ?>
</select>
</div>



</div>
<div class="form-group">
<label>Register as:</label><br>
<input type="radio" name="who" value='student'>Student&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="who" value='faculty'> Teacher<span class="help-block"><?php echo $who_err; ?></span>
</div>


            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    





</body>
</html>
