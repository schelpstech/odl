<?php
include "../../connect.php";   // must define $pdo


if (isset($_POST['allocate']) && $_POST['allocate'] === 'Allocate Course') {

    $term       = $_POST['term'];
    $classId     = $_POST['classd'];
    $subject    = $_POST['sbj'];
    $instructor = $_POST['instructor'];


    // --- Check if already allocated ---
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM lhpalloc 
        WHERE term = ? AND classid = ? AND sbjid = ?
    ");
    $stmt->execute([$term, $classId, $subject]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $message = "Status : Subject Already Allocated, Kindly Modify.";
    } else {

        // --- Insert Allocation ---
        $stmt = $pdo->prepare("
            INSERT INTO lhpalloc 
                (term, staffid, classid, sbjid)
            VALUES (?, ?, ?, ?)
        ");

        $result = $stmt->execute([
            $term,
            $instructor,
            $classId,
            $subject
        ]);

        if ($result) {
            $message = "Status : Subject Successfully Allocated.";
        } else {
            $message = "Error Allocating Subject.";
        }
    }
}

$_SESSION['clmessage'] = $message;
header("Location: ../allocate.php");
exit;
?>
