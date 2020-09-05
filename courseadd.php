<?php
session_start();
      
  	$conn = mysqli_connect("localhost", "root", "", "usis");
    $course_code = $_POST["course_code"];
    $course_section = $_POST["course_section"];
    $faculty_initial = $_POST["faculty_initial"];
    
    $course_prereq = $_POST["course_prereq"];


//split into course and section
	// $split = explode(" - ", $course);
      
$query = "SELECT * FROM courses_taken WHERE "$_SESSION['id']" = std_id";
$result = mysqli_query($conn,$query);
$user = mysqli_fetch_assoc($result);


$sql = "INSERT INTO advised_course VALUES ('$course_code', '$course_section', ' $faculty_initial', "$_SESSION['id']" )";
mysqli_query($conn,$sql);



$resultarray = array();

if($user['course_taken'] === $course_prereq){

	$result["status"] = true;

}
else{
        $result["status"] = false;
}

echo json_encode($result);
            

?>