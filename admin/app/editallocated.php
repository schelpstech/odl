<?php
require "../../connect.php";  // must define $pdo

$message = "";

if (isset($_POST['editalloc'])) {

    if (!empty($_SESSION['ref'])) {
        $ref = $_SESSION["ref"];
    }

    $instructor = $_POST['newinstructor'];

    try {
        // Update allocation
        $stmt = $pdo->prepare("UPDATE lhpalloc SET staffid = ? WHERE aid = ?");
        $stmt->execute([$instructor, $ref]);

        if ($stmt->rowCount() > 0) {
            $message = "Status : Course Allocation Successfully Updated.";
        } else {
            $message = "No changes were made or the record was not found.";
        }
    } catch (PDOException $e) {
        $message = "Database Error: Failed to update course allocation.";
    }

} elseif (isset($_GET['ref'])) {

    $ref = $_GET['ref'];

    try {
        $stmt = $pdo->prepare("DELETE FROM lhpalloc WHERE aid = ?");
        $stmt->execute([$ref]);

        if ($stmt->rowCount() > 0) {
            $message = "Status : Successfully deleted Subject Allocation.";
        } else {
            $message = "Record not found or already deleted.";
        }
    } catch (PDOException $e) {
        $message = "Error deleting Subject Allocation.";
    }
}

$_SESSION['clmessage'] = $message;
header("Location: ../allocate.php");
exit;
