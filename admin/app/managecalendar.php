<?php
require_once "../../connect.php"; // MUST provide $pdo

if (!isset($_POST['create_calendar'])) {
    $_SESSION['eds'] = "Invalid submission!";
    header("Location: ../mgcalendar.php");
    exit;
}

// Collect inputs
$term        = trim($_POST['term'] ?? '');
$title       = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$start_date  = $_POST['start_date'] ?? '';
$end_date    = $_POST['end_date'] ?? '';
$category    = $_POST['category'] ?? 'Other';

// Basic validation
if ($term === '' || $title === '' || $start_date === '' || $end_date === '') {
    $_SESSION['eds'] = "All required fields must be filled!";
    header("Location: ../mgcalendar.php");
    exit;
}

if ($start_date > $end_date) {
    $_SESSION['eds'] = "Start date cannot be later than end date!";
    header("Location: ../mgcalendar.php");
    exit;
}

try {
    $sql = "INSERT INTO lhpcalendar (term, title, description, start_date, end_date, category)
            VALUES (:term, :title, :description, :start_date, :end_date, :category)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':term', $term, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);

    $stmt->execute();

    $_SESSION['eds'] = "Calendar event successfully created!";
    header("Location: ../mgcalendar.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['eds'] = "Database Error: " . $e->getMessage();
    header("Location: ../mgcalendar.php");
    exit;
}
