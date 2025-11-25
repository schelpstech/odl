<?php
include "connect.php"; // must contain your PDO connection as $pdo
session_start();

$type = "Instructor";

/* Get User IP */
function getUserIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
}
$uip = getUserIpAddr();

if (!isset($_POST['but_submit'])) {
    $_SESSION['messagef'] = "Unauthorized Access";
    header("Location: staff.php");
    exit();
}

$uname = trim($_POST['uname']);
$password = trim($_POST['upass']);

// Basic validation
if ($uname == "" || $password == "") {
    $_SESSION['messagef'] = "Invalid Login Credentials";
    header("Location: staff.php");
    exit();
}

try {

    // 1. Check if username exists
    $stmt = $pdo->prepare("SELECT * FROM lhpstaff WHERE sname = ?");
    $stmt->execute([$uname]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Log invalid username
        $insert = $pdo->prepare("INSERT INTO log (uname,utype,stat,uip) VALUES (?, ?, 4, ?)");
        $insert->execute([$uname, $type, $uip]);

        $_SESSION['messagef'] = "Incorrect Login Credentials - Contact School";
        header("Location: staff.php");
        exit();
    }

    // 2. Verify password (spwd is hashed!)
    if (!password_verify($password, $user['spwd'])) {

        // Log wrong password
        $insert = $pdo->prepare("INSERT INTO log (uname,utype,stat,uip) VALUES (?, ?, 3, ?)");
        $insert->execute([$uname, $type, $uip]);

        $_SESSION['messagef'] = "Incorrect Login Credentials - Contact School";
        header("Location: staff.php");
        exit();
    }

    // 3. Check if account is active
    if ($user['status'] != 1) {

        // Log deactivated account
        $insert = $pdo->prepare("INSERT INTO log (uname,utype,stat,uip) VALUES (?, ?, 2, ?)");
        $insert->execute([$uname, $type, $uip]);

        $_SESSION['messagef'] = "Your account has been deactivated. Contact the school.";
        header("Location: staff.php");
        exit();
    }

    // 4. Login success – Log success
    $insert = $pdo->prepare("INSERT INTO log (uname,utype,stat,uip) VALUES (?, ?, 1, ?)");
    $insert->execute([$uname, $type, $uip]);

    // 5. Redirect based on role
    $role = $user['role'];

    if ($role == "b") {
        $_SESSION['unamed'] = $uname;
        header("Location: bursar/profile.php");
        exit();
    }

    if ($role == "t") {
        $_SESSION['stnamed'] = $uname;
        header("Location: instructor/profile.php");
        exit();
    }

    // DEFAULT fallback
    $_SESSION['messagef'] = "Unknown role detected. Contact admin.";
    header("Location: staff.php");

} catch (Exception $e) {
    $_SESSION['messagef'] = "Login Error: " . $e->getMessage();
    header("Location: staff.php");
}
?>
