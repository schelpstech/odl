<?php
include "../../connect.php";   // must define $pdo

if (isset($_POST['sch']) && $_POST['sch'] === 'Modify School Profile') {

    // Collect POST data
    $schname   = $_POST['schname'];
    $schowner  = $_POST['schowner'];
    $schmotto  = $_POST['schmotto'];
    $schaddress = $_POST['schaddress'];
    $schphone  = $_POST['schphone'];
    $schemail  = $_POST['schemail'];
    $schyear   = $_POST['schyear'];
    $schweb    = $_POST['schweb'];

    $clmessage = "";

    // Check if school record exists
    $stmt = $pdo->query("SELECT COUNT(schid) AS cnt FROM lhpschool");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];

    // ======== HANDLE LOGO UPLOAD (IF ANY) ========
    $logo_uploaded = false;
    $schlogo = null;

    if (isset($_FILES['schlogo']) && $_FILES['schlogo']['error'] === UPLOAD_ERR_OK) {

        $fileTmpPath = $_FILES['schlogo']['tmp_name'];
        $fileName = $_FILES['schlogo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExt = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedExt)) {

            $schlogo = "schlogo." . $fileExtension;
            $uploadDir = '../../learn/asset/img/school/';
            $dest_path = $uploadDir . $schlogo;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $logo_uploaded = true;
            } else {
                $clmessage = "Error saving uploaded school logo.";
            }

        } else {
            $clmessage = "Uploaded logo format not allowed. Only JPG, JPEG, PNG allowed.";
        }
    }

    // Stop on upload errors
    if ($clmessage !== "") {
        $_SESSION['eds'] = $clmessage;
        header("Location: ../profile.php");
        exit();
    }

    // ==================================================
    // INSERT NEW RECORD IF NO RECORD EXISTS
    // ==================================================
    if ($count == 0) {

        if (!$logo_uploaded) {
            $_SESSION['eds'] = "School logo is required for initial setup.";
            header("Location: ../profile.php");
            exit();
        }

        $sql = "INSERT INTO lhpschool 
            (schname, address, phone, email, website, proprietor, founded, motto, logo)
            VALUES (:schname, :address, :phone, :email, :website, :proprietor, :founded, :motto, :logo)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':schname'    => $schname,
            ':address'    => $schaddress,
            ':phone'      => $schphone,
            ':email'      => $schemail,
            ':website'    => $schweb,
            ':proprietor' => $schowner,
            ':founded'    => $schyear,
            ':motto'      => $schmotto,
            ':logo'       => $schlogo
        ]);

        $clmessage = "Status: School Profile Successfully Created.";

    } 
    // ==================================================
    // UPDATE EXISTING RECORD
    // ==================================================
    else {

        if ($logo_uploaded) {
            // update with logo
            $sql = "UPDATE lhpschool SET 
                schname = :schname,
                address = :address,
                phone = :phone,
                email = :email,
                website = :website,
                proprietor = :proprietor,
                founded = :founded,
                motto = :motto,
                logo = :logo";
        } else {
            // update without logo
            $sql = "UPDATE lhpschool SET 
                schname = :schname,
                address = :address,
                phone = :phone,
                email = :email,
                website = :website,
                proprietor = :proprietor,
                founded = :founded,
                motto = :motto";
        }

        $stmt = $pdo->prepare($sql);

        $params = [
            ':schname'    => $schname,
            ':address'    => $schaddress,
            ':phone'      => $schphone,
            ':email'      => $schemail,
            ':website'    => $schweb,
            ':proprietor' => $schowner,
            ':founded'    => $schyear,
            ':motto'      => $schmotto
        ];

        if ($logo_uploaded) {
            $params[':logo'] = $schlogo;
        }

        $stmt->execute($params);

        $clmessage = "Status: School Profile Successfully Modified.";
    }

    $_SESSION['eds'] = $clmessage;
    header("Location: ../profile.php");
    exit();
}
?>
