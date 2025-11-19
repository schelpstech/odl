<?php
session_start();
require "../connect.php"; // Must define $pdo

// Enforce login
if (!isset($_SESSION['unamed'])) {
    header("Location: ../index.php");
    exit;
}

// Validate instructor username from GET
if (!empty($_GET['un'])) {
    $edt = $_GET['un'];
} else {
    die("Invalid request.");
}

// Fetch staff details using PDO prepared statement
$stmt = $pdo->prepare("SELECT * FROM lhpstaff WHERE sname = :sname LIMIT 1");
$stmt->execute([':sname' => $edt]);
$staff = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$staff) {
    die("Instructor record not found.");
}

include "nav.php";
?>

<div class="form-element-area">
    <div class="container">
        <div class="row">        
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-element-list">
                    <div class="basic-tb-hd">
                        <h2>Edit Instructor Details</h2>
                        <p>Use the form below to modify Instructor account.</p>

                        <h2>
                            <?php
                                if (isset($_SESSION['eds']) && $_SESSION['eds']) {
                                    echo "<b>" . $_SESSION['eds'] . "</b>";
                                    unset($_SESSION['eds']);
                                }
                            ?>
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <br><br><br>

        <div class="row">
            <form method="POST" action="./app/managestaff.php" enctype="multipart/form-data">

                <!-- Hidden Username -->
                <input type="hidden" name="stnamed" value="<?= htmlspecialchars($staff['sname']); ?>">

                <!-- Password -->
                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>Instructor Username</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="text" required class="form-control" name="stpwd" disabled
                                   value="<?= htmlspecialchars($staff['sname']); ?>">
                        </div>
                    </div>
                </div>

                <!-- Full Name -->
                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>Instructor Fullname</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="text" required class="form-control" name="stname"
                                   value="<?= htmlspecialchars($staff['staffname']); ?>">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>Instructor Email Address</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="email" required class="form-control" name="stemail"
                                   value="<?= htmlspecialchars($staff['semail']); ?>">
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>Instructor Phone Number</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="text" required class="form-control" name="stfone"
                                   value="<?= htmlspecialchars($staff['sfone']); ?>">
                        </div>
                    </div>
                </div>

                <br><br>

                <!-- Modify button -->
                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group ic-cmp-int">
                        <div class="nk-int-st">
                            <input type="submit" class="form-control" name="edstf"
                                   value="Modify Instructor Details">
                        </div>
                    </div>
                </div>

                <!-- Delete button -->
                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group ic-cmp-int">
                        <div class="nk-int-st">
                            <input type="submit" class="form-control" name="resetpwd"
                                   value="Reset Instructor Password"
                                   onclick="return confirm('Are you sure you want to reset this instructor\'s password to default123?');">
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

<?php include "foot.html"; ?>

