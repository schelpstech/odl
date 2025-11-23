<?php
require "../../connect.php";  // MUST define $pdo

if (isset($_POST['createsb']) && $_POST['createsb'] === 'Create Course') {

  // Collect form inputs
  $sbclass = $_POST['sbjclass'] ?? null;
  $courseId  = trim($_POST['sbjcode'] ?? '');
  $sbname  = trim($_POST['sbjname'] ?? '');

  try {
    // Validate required fields
    if (empty($sbclass) || empty($courseId) || empty($sbname)) {
      throw new Exception("All fields are required.");
    }


    // 2. Insert new course
    $insert = $pdo->prepare("
            INSERT INTO lhpsubject (sbjname, classid, courseId) 
            VALUES (:sbjname, :classid, :courseId)
        ");

    $insert->execute([
      ':sbjname'   => $sbname,
      ':classid'   => $sbclass,
      ':courseId' => $courseId
    ]);

    $clmessage = "Status: Course successfully created.";
  } catch (Exception $e) {
    // Handle errors gracefully
    $clmessage = "Error creating course: " . $e->getMessage();
  }
}

$_SESSION['clmessage'] = $clmessage;
header("Location: ../course_mgr.php");
exit;
