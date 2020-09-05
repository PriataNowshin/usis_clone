<?php
//connection and taking the value
$conn = mysqli_connect("localhost", "root", "", "usis");
$course = $_POST["course"];

//split into course and section
$split = explode(" - ", $course);

//query to database

// $query = "SELECT course_code, course_prereq, course_name, section_no, section_no_std, section_faculty_intial, section_timing FROM course INNER JOIN section ON course_code==section_course_code
// WHERE course_code = '$split[0]' AND section_no = '$split[1]'";

$query = "SELECT * FROM course INNER JOIN section ON course_code=section_course_code WHERE course_code = '$split[0]' AND section_no = '$split[1]'";
$result = mysqli_query($conn,$query);

// store values into an array called $data.

while ($row = mysqli_fetch_array($result)) {
	$data["course_code"] = $row["course_code"];
	$data["course_name"] = $row["course_name"];
	$data["course_prereq"] = $row["course_prereq"];
	$data["section_no"] = $row["section_no"];
	$data["section_faculty_intial"] = $row["section_faculty_initial"];
	$data["section_timing"] = $row["section_timing"];
	$data["section_total_seat"] = $row["section_total_seat"];
	$data["section_available_seat"] = $row["section_available_seat"];
}

//sending data to javascript

// $query = "SELECT * FROM course WHERE course_code = '$split[0]'";
// $result = mysqli_query($conn,$query);
// while ($row = mysqli_fetch_array($result)) {
// 	$data["course_prereq"] = $row["course_prereq"];
// }


echo json_encode($data);

 ?>