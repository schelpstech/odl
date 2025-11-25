<?php
require "../../connect.php";  // must define $pdo

$lsmessaged = '';

if (isset($_POST['createlearner']) && $_POST['createlearner'] === 'Create Learner Account') {

    // Collect form inputs (PDO will handle escaping)
    $stname  = $_POST['lname'];
    $stuname = strtoupper($_POST['luname']);
    $stpwd   = $_POST['lpwd'];
    $stmail  = strtolower($_POST['lmail']);
    $stclass = $_POST['lclass'];
    $gender  = $_POST['gender'];
    $dob     = $_POST['dob'];

    try {
        // Check if username exists
        $stmt = $pdo->prepare("SELECT COUNT(uname) FROM lhpuser WHERE uname = ?");
        $stmt->execute([$stuname]);
        $exist = $stmt->fetchColumn();

        if ($exist == 0) {

			$hashedPwd = password_hash($stpwd, PASSWORD_DEFAULT);
            // Insert learner record
            $stmt = $pdo->prepare("
                INSERT INTO lhpuser (fname, uname, upwd, email, classid, gender, dob, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, 1)
            ");

            if ($stmt->execute([$stname, $stuname, $hashedPwd, $stmail, $stclass, $gender, $dob])) {
                $lsmessaged = 'Status : Learner account successfully created.';
            } else {
                $lsmessaged = 'Status : Error creating learner account.';
            }

        } else {
            $lsmessaged = 'Status : Error creating learner account. Username already exists.';
        }

    } catch (PDOException $e) {
        $lsmessaged = 'Status : Database error occurred while creating learner account.';
    }

}

// ========== MODIFY LEARNER DETAILS ==========
elseif (isset($_POST['edstdt']) && $_POST['edstdt'] === 'Modify Learner Details') {

    $uname   = $_POST['named'];
    $fname   = $_POST['nname'];
    $email   = $_POST['nemail'];
    $classid = $_POST['nclass'];
    $gender  = $_POST['gender'];
    $dob     = $_POST['dob'];

    try {
        $stmt = $pdo->prepare("
            UPDATE lhpuser 
            SET 
                email = ?, 
                classid = ?, 
                fname = ?, 
                gender = ?, 
                dob = ?
            WHERE uname = ?
        ");

        $stmt->execute([$email, $classid, $fname, $gender, $dob, $uname]);

        if ($stmt->rowCount() > 0) {
            $lsmessaged = "Status : Successfully modified learner record.";
        } else {
            $lsmessaged = "Status : No changes made or learner not found.";
        }

    } catch (PDOException $e) {
        $lsmessaged = "Status : Unable to modify learner record.";
    }
}



// ========== DELETE LEARNER RECORD ==========
elseif (isset($_POST['del']) && $_POST['del'] === 'Delete Learner Details') {

    $uname = $_POST['named'];

    try {
        $stmt = $pdo->prepare("DELETE FROM lhpuser WHERE uname = ?");
        $stmt->execute([$uname]);

        if ($stmt->rowCount() > 0) {
            $lsmessaged = "Status : Successfully DELETED learner record.";
        } else {
            $lsmessaged = "Status : Learner not found or already deleted.";
        }

    } catch (PDOException $e) {
        $lsmessaged = "Status : Unable to DELETE learner record.";
    }
}



// ========== CHANGE LEARNER STATUS ==========
elseif (isset($_POST['chg']) && $_POST['chg'] === 'Change Status') {

    $uname   = $_POST['named'];
    $status  = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE lhpuser SET status = ? WHERE uname = ?");
        $stmt->execute([$status, $uname]);

        if ($stmt->rowCount() > 0) {
            $lsmessaged = "Status : Successfully changed learner status.";
        } else {
            $lsmessaged = "Status : Learner not found or no status change.";
        }

    } catch (PDOException $e) {
        $lsmessaged = "Status : Unable to change learner status.";
    }
}


// ========== RESET PASSWORD TO DEFAULT123 ==========
elseif (isset($_POST['rst']) && $_POST['rst'] === 'Reset Password') {

    $uname = $_POST['named'];
    $defaultPassword = "Default123";  // plain text OR hash if preferred

    try {
        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE lhpuser SET upwd = ? WHERE uname = ?");
        $stmt->execute([$hashedPassword, $uname]);

        if ($stmt->rowCount() > 0) {
            $lsmessaged = "Status : Password reset to Default123.";
        } else {
            $lsmessaged = "Status : Failed to reset password or user not found.";
        }

    } catch (PDOException $e) {
        $lsmessaged = "Status : Unable to reset password.";
    }
}




// ========== FINISH ==========

else {
    $lsmessaged = 'Status : Unknown request denied by firewall.';
}

// Save message and redirect
$_SESSION['lsmessaged'] = $lsmessaged;
header("Location: ../mglearners.php");
exit;

?>
