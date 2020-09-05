<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Advising Panel</title>
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
          <a class="dropdown-item" href="coursepage.php">Courses</a>
          <a class="dropdown-item" href="seatpage.php">Seat Status</a>
          <a class="dropdown-item active" href="advisingpanelpage.php">Advising Panel</a>
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
   <form class="search-panel" method="POST">
    <input type="text" name="search" placeholder="search">
    <button type="submit" name="submit"> Search</button>
  </form>


  <div class="panel-box">
    <?php 
      session_start();
      
      //connection

      $conn = mysqli_connect("localhost", "root" , "", "usis");
     
      if(!$conn){
        die("Connection failed: " . $conn->connect_error);
      }

      //initial
      if(!isset($_POST['submit'])){
        initial($conn);
      }

      //searched course

      else if(isset($_POST['submit'])){
        $search = mysqli_real_escape_string($conn,$_POST['search']);
        if($search == null){
          initial($conn);
        }else{
          $courses = array();
          $sections = array();
          $query2= "SELECT section_course_code, section_no from section where section_course_code like '%$search%'";
          $result2 = mysqli_query($conn,$query2) or die("The query could not be completed!");
          $queryResult2 = mysqli_num_rows($result2);
          if($queryResult2 > 0){
            while($row = mysqli_fetch_array($result2)){
              $c_code= $row['section_course_code'];
              $s_number = $row['section_no'];  
              echo "<h6><span class ='course'><b>", $c_code," - ",$s_number, "</b></span></h6><br>";

            }
          }
        }

     } 
    ?>
  </div>

  <div class="middle">

  </div>

  <div class="sidebar">

    <div><h5>Title: <b><span class="title"></span></b></h5></div>
    <div><h5>Code: <b><span class="code"></span></b></h5></div>
    <div><h5>Pre-requisite: <b><span class="prerequisite"></span></b></h5></div>
    <div><h5>Section: <b><span class="section"></span></b></h5></div>
    <div><h5>Faculty: <b><span class="faculty"></span></b></h5></div>
    <div><h5>Timing: <b><span class="timing"></span></b></h5></div>
    <div><h5>Total Seat: <b><span class="totalseat"></span></b></h5></div>
    <div><h5>Remaining Seat: <b><span class="remainingseat"></span></b></h5></div>


    <div class="buttons">
      <button class="addbutton">ADD</button>
      <button class="dropbutton">DROP</button>
    </div>

  </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous">
    </script>



    <script>
      
      $(document).ready(function(){

        $(".course").click(function(){
          // $(this).css("background-color", "#979ED4");
          var course = $(this).text();

          $.ajax({
            url : "course_click.php",
            type : "POST",
            data : {course : course},
            dataType : "JSON",
            success: function(data){
              $(".title").text(data.course_name);
              $(".code").text(data.course_code);
              $(".prerequisite").text(data.course_prereq);
              $(".section").text(data.section_no);
              $(".faculty").text(data.section_faculty_intial);
              $(".timing").text(data.section_timing);
              $(".totalseat").text(data.section_total_seat);
              $(".remainingseat").text(data.section_available_seat);
            }

          });

        });

      });

      $(document).ready(function(){
        var a = 1;
        $(".addbutton").on('click' ,function(){
          
          if(a < 5){
          var course_code = $(".code").text();
          var course_section = $(".section").text();
          var course_prereq = $(".prerequisite").text();
          var faculty_initial = $(".faculty").text();


          // var course = course_code+" - "+course_section;

          //sending the course and section to add the course as advised course.
         var x = false;
          $.ajax({
            url : "courseadd.php",
            type : "POST",
            data : {course_prereq : course_prereq , course_code : course_code , course_section : course_section , faculty_initial : faculty_initial},
            dataType : "JSON",
            success : function(data){
              var result = $.parseJSON(data);
              if (result.status===true) {
                x = true;
              }else{
                x = false;
              }

            }

          });
          
          //showing the advised course in the middlebox
          if(x=true){
            var addedCourse = "<h6><span id = c"+a+"><b>"+course_code+" - "+course_section+"</b></span></h6><br>"
            $(".middle").append(addedCourse);
             a++;
          }else{
            alert("FULFILL PREREQUISITE CONDITION");
          }
         
        
        } 
        else{
          alert("YOU CANNOT TAKE 5 courses");
          }

        });
      });

      var getID = "";
      var cr = "";

      $(".middle").on('click','h6 span',function(){
        getID = $(this).attr("id");
        var course = $(this).text();
        cr = course;
           $.ajax({
            url : "course_click.php",
            type : "POST",
            data : {course : course},
            dataType : "JSON",
            success: function(data){
              $(".title").text(data.course_name);
              $(".code").text(data.course_code);
              $(".prerequisite").text(data.course_prereq);
              $(".section").text(data.section_no);
              $(".faculty").text(data.section_faculty_intial);
              $(".timing").text(data.section_timing);
              $(".totalseat").text(data.section_total_seat);
              $(".remainingseat").text(data.section_available_seat);
            }
          });
      
      });

       $(".dropbutton").on('click',function(){

         alert(cr);
        $(".middle").remove(cr);
         //sending the course with section to drop from advised course.
         $.ajax({
         url : "coursedrop.php",
         type : "POST",
         data : {cr : cr},
         dataType : "JSON",
         success : function(data){
         alert("Course dropped!");

          }
        });
         
           
      });



    </script>

    <style type="text/css">
      .middle span{
        cursor: pointer;
      }
    </style>
</body>
</html>



<?php 
function initial($conn){
        $query1= "SELECT section_course_code,section_no from section";
        $result1= mysqli_query($conn,$query1) or die ("The query could not be completed!");
        $queryResult1 = mysqli_num_rows($result1);
        if($queryResult1 > 0){                                          
        while($row = mysqli_fetch_array($result1)){
          $c_code= $row['section_course_code'];
          $s_number = $row['section_no'];
          echo "<h6><span class ='course'><b>", $c_code," - ",$s_number, "</b></span></h6><br>";
          }
        }
      }
 ?>


<!-- NO NEED TO SEE THE BELOW SCRIPT CODE -->

 <!-- <script type="text/javascript">  
 // function fun(){
  //     $(".middle").write("<span class='a1'></span>");
  // }
      // $(document).ready(function(){
      //   $(".addbutton").click(function(){
      //     var course_code = $(".code").text();
      //     var course_section = $(".section").text();
      //     $(".a1").text(course_code+" - "+course_section);
      //   });
      // });

      // $(document).ready(function(){
      //   for(var i = 1; i<=4 ; i++){
      //     $(".middle").append("<span class=a"+i+">a"+i+"</span><br>");
      //   $(".addbutton").click(function(){
      //     $(".middle").append("<span class=a"+i+">a"+i+"</span><br>");
      //     // var course_code = $(".code").text();
      //     // var course_section = $(".section").text();
      //     // $(".a1").text(course_code+" - "+course_section);
          
      //   });}
      // });
    </script> -->