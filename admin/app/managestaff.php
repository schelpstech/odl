<?php
require "../../connect.php";  // MUST define $pdo

$ssmessaged = "";

/**
 * Helper function for PDO prepared updates
 */

function runUpdate($pdo, $sql, $params, $msgSuccess, $msgFail, &$ssmessaged)
{
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $ssmessaged = $msgSuccess;
    } catch (Exception $e) {
        $ssmessaged = $msgFail . " :: " . $e->getMessage();
    }
}


/* =====================================================================
   1. CREATE STAFF ACCOUNT
   ===================================================================== */
if (isset($_POST['createst']) && $_POST['createst'] === 'Create Instructor Account') {

    $stname  = trim($_POST['stname']);
    $stuname = trim($_POST['stuname']);
    $stpwd   = trim($_POST['stpwd']);
    $stmail  = trim($_POST['stmail']);
    $stfone  = trim($_POST['stfone']);
    $role    = trim($_POST['role']);

    try {
        $hashedPwd = password_hash($stpwd, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO lhpstaff (sname, staffname, spwd, semail, sfone, role)
            VALUES (:sname, :staffname, :password, :email, :phone, :role)
        ");

        $stmt->execute([
            ':sname'     => $stname,
            ':staffname' => $stuname,
            ':password'  => $hashedPwd,
            ':email'     => $stmail,
            ':phone'     => $stfone,
            ':role'      => $role
        ]);

        $ssmessaged = "Status : Staff Account successfully created.";
    } catch (Exception $e) {
        $ssmessaged = "Error Creating Staff Account: " . $e->getMessage();
    }
}

/* =====================================================================
   2. MODIFY STAFF DETAILS
   ===================================================================== */
if (isset($_POST['edstf']) && $_POST['edstf'] == 'Modify Instructor Details') {

    $sql = "
        UPDATE lhpstaff 
        SET  semail = :email, sfone = :phone, staffname = :staffname
        WHERE sname = :sname
    ";

    runUpdate(
        $pdo,
        $sql,
        [
            ':email'     => $_POST['stemail'],
            ':phone'     => $_POST['stfone'],
            ':staffname' => $_POST['stname'],
            ':sname'     => $_POST['stnamed']
        ],
        "Status : Successfully modified Staff record.",
        "Status : Unable to modify Staff record",
        $ssmessaged
    );
}

/* =====================================================================
   3. CHANGE STATUS
   ===================================================================== */
if (isset($_POST['chg']) && $_POST['chg'] == 'Change Status') {

    $sql = "
        UPDATE lhpstaff 
        SET status = :status 
        WHERE sname = :sname
    ";

    runUpdate(
        $pdo,
        $sql,
        [
            ':status' => $_POST['status'],
            ':sname'  => $_POST['named']
        ],
        "Status : Successfully changed Staff status.",
        "Status : Unable to change Staff status.",
        $ssmessaged
    );
}

/* =====================================================================
   4. DELETE STAFF
   ===================================================================== */
if (isset($_POST['del']) && $_POST['del'] == 'Delete Staff Details') {

    $sql = "DELETE FROM lhpstaff WHERE sname = :sname";

    runUpdate(
        $pdo,
        $sql,
        [
            ':sname' => $_POST['stnamed']
        ],
        "Status : Successfully DELETED Staff record.",
        "Status : Unable to DELETE Staff record.",
        $ssmessaged
    );
}

/* =====================================================================
   5. RESET PASSWORD TO default123
   ===================================================================== */
if (isset($_POST['resetpwd']) && $_POST['resetpwd'] === "Reset Instructor Password") {

    $defaultPassword = "default123";
    $hashedDefault = password_hash($defaultPassword, PASSWORD_DEFAULT);

    $sql = "
        UPDATE lhpstaff 
        SET spwd = :pwd 
        WHERE sname = :sname
    ";

    runUpdate(
        $pdo,
        $sql,
        [
            ':pwd'   => $hashedDefault,
            ':sname' => $_POST['stnamed']
        ],
        "Status : Password reset to default123 successfully.",
        "Status : Unable to reset password.",
        $ssmessaged
    );
}

/* =====================================================================
   REDIRECT WITH SESSION MESSAGE
   ===================================================================== */
$_SESSION['ssmessaged'] = $ssmessaged;
header("Location: ../mgstaff.php");
exit;

?>
