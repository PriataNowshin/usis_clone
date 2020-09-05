<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Courses</title>
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
        <a class="nav-link" href="profilepage.php">Profile<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Advising
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item active" href="#">Courses</a>
          <a class="dropdown-item" href="seatpage.php">Seat Status</a>
          <a class="dropdown-item" href="advisingpanelpage.php">Advising Panel</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="advisedcoursespage.php">Advised Courses</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="loginpage.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

  <form class="search" method="POST">
    <input type="text" name="search" placeholder="search">
    <button type="submit" name="submit"> Search</button>
  </form>

  <div class="course-container">
    <?php 
      session_start();
      $conn = mysqli_connect("localhost", "root" , "", "usis");
     
      if(!$conn){
        die("Connection failed: " . $conn->connect_error);
      }
      if(isset($_POST['submit'])){
        $search = mysqli_real_escape_string($conn,$_POST['search']);
        if($search == null){
          echo " ";
        }
        else{
          $sql = "SELECT * FROM course WHERE course_code LIKE '%$search%'";
          $result = mysqli_query($conn,$sql) or die("The query could not be completed!");
          $queryResult = mysqli_num_rows($result);
          if($queryResult > 0){
            while($row = mysqli_fetch_array($result)){
              $c_code = $row['course_code'];
              $c_name = $row['course_name'];
              $c_prereq = $row['course_prereq'];
            }
    ?>
            <table>
              <tr><td><h3>Course code: </h3></td><td><h3><?php echo $c_code ?></h3></td></tr>
              <tr><td><h3>Course name: </h3></td><td><h3><?php echo $c_name ?></h3></td></tr>
              <tr><td><h3>Course prerequisite: </h3></td><td><h3><?php echo $c_prereq ?></h3></td></tr>
            </table>
    <?php   
          }
        
          else{
            echo "There is no result matching your search!";
          }
        
        }
      }
    ?> 
    
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>
</html>
<!-- 'course_code','course_name','course_prereq' -->