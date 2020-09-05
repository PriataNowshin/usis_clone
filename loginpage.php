<!DOCTYPE html>
<html>
<head>
  <title>Login :: USIS ::</title>
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
                <li class="nav-item active">
                  <a class="nav-link" href="#">Login<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="signuppage.php">Sign Up</a>
                </li>
              </ul>
            </div>
          </nav>

  <h1 class="welcome">Welcome to Brac University USIS</h1>

  <div class="login-box">
    <form method="POST">
    <h1>Login</h1>
  <div class="textbox">
    <input name="id" type="text" placeholder="ID">
  </div>

  <div class="textbox">
    <input name="password" type="password" placeholder="Password">
  </div>

  <input class="btn" type="submit" value="Sign in" name="signin">
    </form>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php 

session_start();

if (isset($_POST['signin'])) {
  //variable declaration
    $id = $_POST['id'];
    $password = $_POST['password'];

    //To prevent MYSQL injection

    $id = stripcslashes($id);
    $password = stripcslashes($password);
    
     //Database Connection
    $conn = mysqli_connect("localhost", "root" , "", "usis");
     
    if(!$conn){
     die("Connection failed: " . $conn->connect_error);
    }

    //Empty checking
    $errors = array();
    if(empty($id)){
         array_push($errors, "ID is required");
    }
    if(empty($password)){
      array_push($errors, "Password is required");
    }

    //database check
    if(count($errors)==0){
  // $password = md5($password);
      $check_query = "SELECT * FROM student WHERE std_id = '$id' AND std_password = '$password'";
      $result = mysqli_query($conn,$check_query);

      if(!$result || mysqli_num_rows($result) == 1){
        $_SESSION['id'] = $id;
        // $_SESSION['success'] = "Logged in successfully";
        // echo $_SESSION['id'];
        // echo $_SESSION['success'];
        header('location: profilepage.php');
      }else{
        array_push($errors,"wrong id/password combination. Please try again");
        echo array_pop($errors);
      }
    }else if(count($errors) > 0){
    foreach ($errors as $error) {
      echo $error , " <br><br>";
    }
  }

}
?>