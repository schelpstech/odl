<?php
require "../../connect.php";  // MUST define $pdo


if (isset($_POST['createprg']) && $_POST['createprg'] === 'Create Programme') {

    $clname = trim($_POST['crclass']);

    if ($clname !== "") {
        try {
            $sql = "INSERT INTO lhpclass (classname) VALUES (:classname)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':classname', $clname, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $clmessage = 'Status: Programme successfully created.';
            } else {
                $clmessage = 'Error: Unable to create programme.';
            }

        } catch (PDOException $e) {
            $clmessage = "Database Error: " . $e->getMessage();
        }

    } else {
        $clmessage = "Error: Programme name cannot be empty.";
    }
}

$_SESSION['clmessage'] = $clmessage;
header("Location: ../program_mgr.php");
exit;

?>
