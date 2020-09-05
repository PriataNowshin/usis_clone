<!DOCTYPE html>
<html>
<head>
	<title>Sign Up :: USIS ::</title>
	 <meta charset="utf-8">
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
                <li class="nav-item">
                  <a class="nav-link" href="loginpage.php">Login<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="#">Sign Up</a>
                </li>
              </ul>
            </div>
          </nav>
    
		   <div class="login-box">
		    <form method="POST">
		    <h1>Sign Up</h1>
		  <div class="textbox">
		    <input name="name" type="text" placeholder="Name">
		  </div>
		  <div class="textbox">
		    <input name="id" type="text" placeholder="ID">
		  </div>
		  <div class="textbox">
		    <input name="email" type="email" placeholder="Email Address">
		  </div>
		  <div class="textbox">
		    <input name="contact" type="text" placeholder="Contact no.">
		  </div>
		  <div class="textbox">
		    <input name="department" type="text" placeholder="Department">
		  </div>
		 <div class="textbox">
		    <input name="signUpPassword" type="password" placeholder="Create Password">
		  </div>

		  <input class="btn" type="submit" value="Sign Up" name="signup">
		    </form>
		  </div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php 
session_start();

if(isset($_POST['signup'])){

	/*Variable Declaration*/
	
	$name = $_POST['name'];
	$id = $_POST['id'];
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$department = $_POST['department'];
	$password = $_POST['signUpPassword'];

	/* Database Connection*/

	$conn = mysqli_connect("localhost", "root" , "", "usis");

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	/*EmptyFields check*/

	$errors = array();

	if (empty($name)) {
		array_push($errors, "Name is required");
	}
	if (empty($id)) {
		array_push($errors, "Id is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($contact)) {
		array_push($errors, "Contact is required");
	}
	if (empty($department)) {
		array_push($errors, "Department is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}
	
	/*Duplicate Check*/

	$check_query = "SELECT * FROM student WHERE std_id = '$id' OR std_email_address = '$email' OR std_contact_no = '$contact' LIMIT 1";

	$result = mysqli_query($conn , $check_query);
	$user = mysqli_fetch_assoc($result);

	if($user){
		if ($user['std_id'] === $id) {
			array_push($errors, "Id already exists");
		}else if ($user['std_contact_no'] === $contact) {
			array_push($errors, "Contact number already exists");
		}else if ($user['std_contact_no'] === $email) {
			array_push($errors, "Email address already exists");
		}
	}

	// Inserting values

	if (count($errors) == 0) {
		// $password = md5($password); //Encrypting the password
		$insert_query = "INSERT INTO student VALUES('$name', '$id' , '$contact', '$email' , '$department' , '$password')";
	
		mysqli_query($conn,$insert_query);
		header('location: loginpage.php');
	}
	//If there are any errors, Echo IT!
	else if(count($errors) > 0){
		foreach ($errors as $error) {
			echo $error , " <br><br>";
		}
	}
}

?>