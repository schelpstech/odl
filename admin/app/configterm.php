<?php
require "../../connect.php";  // must define $pdo
$message = "no action";

if (isset($_POST['configterm']) && $_POST['configterm'] === 'Create Term Record') {

    $term = trim($_POST['term']);
    $actSession = trim($_POST['actSession']);

    $termname = $term . " " . $actSession;

    // Check if term exists
    $stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM lpterm WHERE term = ?");
    $stmt->execute([$termname]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Insert new term
        $insert = $pdo->prepare("INSERT INTO lpterm (term, status) VALUES (?, ?)");
        if ($insert->execute([$termname, 0])) {
            $remessage = 'Status : Term configuration record successfully saved.';
        } else {
            $remessage = 'Status : There was an error creating the new term record.';
        }
    } else {
        $remessage = 'Status : Duplicate Record :: A configuration record already exists for this term.';
    }

} elseif (isset($_POST['modifyTerm']) && $_POST['modifyTerm'] === 'Change Semester Status') {

    if (!isset($_SESSION['termref'])) {
        $_SESSION['remessage'] = "Error: No term reference found.";
        header("Location: ../mgterm.php");
        exit();
    }

    $term = $_SESSION['termref'];
    $action = intval($_POST['action']); // must be 0 or 1

    // Confirm term record exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM lpterm WHERE tid = ?");
    $stmt->execute([$term]);
    $count = $stmt->fetchColumn();

    if ($count == 1 && $action == 1) {

        // Deactivate all terms
        $deactivate = $pdo->prepare("UPDATE lpterm SET status = 0");
        if ($deactivate->execute()) {

            // Activate selected term
            $activate = $pdo->prepare("UPDATE lpterm SET status = 1 WHERE tid = ?");
            if ($activate->execute([$term])) {
                $remessage = 'Status : Selected term has been successfully activated.';
            } else {
                $remessage = 'Status : Error activating selected term.';
            }

        } else {
            $remessage = 'Status : Error deactivating other terms.';
        }

    } else {
        $remessage = 'Status : Error :: Term record not found.';
    }
}

$_SESSION['remessage'] = $remessage;
header("Location: ../mgterm.php");
exit();
