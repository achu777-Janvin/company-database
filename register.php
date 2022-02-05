<?php 

  session_start();

  require 'connect.php';
  require 'functions.php';


  if(isset($_POST['register'])) {

    $uname = clean($_POST['username']); 
    $pword = clean($_POST['password']); 
    $studno = clean($_POST['studentno']); 
    $fname = clean($_POST['firstname']); 
    $lname = clean($_POST['lastname']); 
    $course = clean($_POST['course']); 
    $yrlevel = clean($_POST['yrlevel']); 

    $query = "SELECT username FROM students WHERE username = '$uname'";
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) == 0) {

      $query = "SELECT studentno FROM students WHERE studentno = '$studno'";
      $result = mysqli_query($con,$query);

      if(mysqli_num_rows($result) == 0) {

        $query = "INSERT INTO students (username, password, studentno, firstname, lastname, course, yrlevel, date_joined)
        VALUES ('$uname', '$pword', '$studno', '$fname', '$lname', '$course', '$yrlevel', NOW())";

        if(mysqli_query($con, $query)) {

          $_SESSION['prompt'] = "Account registered. You can now log in.";
          header("location:index.php");
          exit;

        } else {

          die("Error with the query");

        }

      } else {

        $_SESSION['errprompt'] = "That student number already exists.";

      }

    } else {

      $_SESSION['errprompt'] = "Username already exists.";

    }

  } 

?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Register - Student Information System</title>

	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>
<body>

  <?php include 'header.php'; ?>

  <section class="center-text">
    
    <strong>Register</strong>

    <div class="registration-form box-center clearfix">

    <?php 
        if(isset($_SESSION['errprompt'])) {
          showError();
        }
    ?>

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        
        <div class="row">
          <div class="account-info col-sm-6">
          
            <fieldset>
              <legend>Account Info</legend>
              
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username (must be unique)" required>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>

            </fieldset>
            

          </div>

          <div class="personal-info col-sm-6">
            
            <fieldset>
              <legend>Personal Info</legend>
              
              <div class="form-group">
                <label for="studentno">Student Number</label>
                <input type="text" class="form-control" name="studentno" placeholder="Student Number (must be unique)" required>
              </div>

              <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
              </div>

              <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
              </div>

              <div class="form-group">
                <label for="course">Course</label>

                <select class="form-control" name="course">
                  <option value="BSBA">BSBA</option>
                  <option value="BSOA">BSOA</option>
                  <option value="BSIT">BSIT</option>
                  <option value="BSCS">BSCS</option>
                  <option value="BSCE">BSCE</option>
                  
                </select>

              </div>

              <div class="form-group">
                <label for="yrlevel">Year Level</label>

                <select class="form-control" name="yrlevel">
                  <option>1st year</option>
                  <option>2nd year</option>
                  <option>3rd year</option>
                  <option>4th year</option>
                </select>

              </div>

            </fieldset>
            

          </div>
        </div>

        
        
        <a href="index.php">Go back</a>
        <input class="btn btn-primary" type="submit" name="register" value="Register">



      </form>
    </div>

  </section>


	<script src="assets/js/jquery-3.1.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>

<?php 

  unset($_SESSION['errprompt']);
  mysqli_close($con);

?>