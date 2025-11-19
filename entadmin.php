<?php
require_once "connect.php";   // includes $pdo and session_start()

$type = "Administrator";

function getUserIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$uip = getUserIpAddr();

if (!isset($_POST['but_admn'])) {
    $_SESSION['messagef'] = "Unauthorized Access";
    header("Location: admin.php");
    exit();
}

$uname    = trim($_POST['aaname'] ?? "");
$password = trim($_POST['aapwd'] ?? "");

if ($uname == "" || $password == "") {
    $_SESSION['messagef'] = "Invalid Login Credentials";
    header("Location: admin.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| CHECK IF USERNAME EXISTS
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("SELECT dpwd FROM 123admin WHERE dname = ?");
$stmt->execute([$uname]);
$user = $stmt->fetch();

if (!$user) {
    // Username does not exist
    $log = $pdo->prepare("INSERT INTO log (uname, utype, stat, uip) VALUES (?, ?, 4, ?)");
    $log->execute([$uname, $type, $uip]);

    $_SESSION['messagef'] = "Invalid Username - Contact School";
    header("Location: admin.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| CHECK PASSWORD
|--------------------------------------------------------------------------
*/
if ($password !== $user['dpwd']) {
    // Incorrect password
    $log = $pdo->prepare("INSERT INTO log (uname, utype, stat, uip) VALUES (?, ?, 3, ?)");
    $log->execute([$uname, $type, $uip]);

    $_SESSION['messagef'] = "Incorrect Password - Contact School";
    header("Location: admin.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| SUCCESSFUL LOGIN
|--------------------------------------------------------------------------
*/
$log = $pdo->prepare("INSERT INTO log (uname, utype, stat, uip) VALUES (?, ?, 1, ?)");
$log->execute([$uname, $type, $uip]);

$_SESSION['unamed'] = $uname;
header("Location: admin/dashboard.php");
exit();
?>
