
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <img src="css/bracu.jpg" width="50px" length="50px">
   <a class="navbar-brand" href="#">Brac University</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Profile<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Advising
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="coursepage.php">Courses</a>
          <a class="dropdown-item" href="seatpage.php">Seat Status</a>
          <a class="dropdown-item" href="advisingpanelpage.php">Advising Panel</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="advisedcoursespage.php">Advised Courses</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="loginpage.php" name="logout">Logout</a>
      </li>
    </ul>    
  </div>
</nav>

<div class="user-info">
<?php 

session_start();

  $conn = mysqli_connect("localhost", "root" , "", "usis");
     
  if(!$conn){
   die("Connection failed: " . $conn->connect_error);
   }

  if(isset($_SESSION['id'])==true){
    $id = $_SESSION['id'];
    $query = "SELECT * FROM student WHERE std_id='$id'";
    $result = mysqli_query($conn,$query) or die("The query could not be completed!");
    while($row = mysqli_fetch_array($result)){
      $name = $row['std_name'];
      $contact_no = $row['std_contact_no'];
      $email = $row['std_email_address'];
      $department_name= $row['std_department_name'];
    }
    ?>
    <table>
      <tr><td><h5>Name: </h5></td><td><h5><?php echo $name ?></h5></td></tr>
      <tr><td><h5>Student ID: </h5></td><td><h5><?php echo $id ?></h5></td></tr>
      <tr><td><h5>Contact Number: </h5></td><td><h5><?php echo $contact_no ?></h5></td></tr>
      <tr><td><h5>Email Address: </h5></td><td><h5><?php echo $email ?></h5></td></tr>
      <tr><td><h5>Department Name: </h5></td><td><h5><?php echo $department_name ?></h5></td></tr>
    </table>

<?php
  }
  else {die("You need to specify an ID!");}
 ?>

</div>
	   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>



<!-- <?php

session_start();

$conn = mysqli_connect("localhost","root","","usis");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
  echo $id;
}

?> -->