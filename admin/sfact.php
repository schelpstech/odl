<?php
// Check user login
include "../connect.php";
if (!isset($_SESSION['unamed'])) {
    header('Location: ../index.php');
    exit;
}

// Get staff username from GET
$edt = '';
if (!empty($_GET['unamd'])) {
    $edt = trim($_GET['unamd']);
}

// Fetch staff details using PDO
$editresult = [];
if ($edt !== '') {
    $stmt = $pdo->prepare("SELECT * FROM lhpstaff WHERE sname = :sname LIMIT 1");
    $stmt->execute([':sname' => $edt]);
    $editresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!-- Mobile Menu start -->
<?php include "nav.php"; ?>
<!-- Main Menu area End-->
<!-- Breadcomb area Start-->

<div class="form-element-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-element-list">
                    <div class="basic-tb-hd">
                        <h2>Change Staff Status</h2>
                        <p>Use the form below to change Staff Status</p>
                        <h2>
                            <?php
                            if (isset($_SESSION['eds']) && $_SESSION['eds']) {
                                echo '<b>' . $_SESSION['eds'] . '</b>';
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
            <form method="POST" action="./app/managestaff.php" class="form-element-area" id="fupload">

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12" hidden>
                    <label>Staff's UserName</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
                        <div class="nk-int-st">
                            <input type="text" required class="form-control" name="named" value="<?php echo htmlspecialchars($edt); ?>">
                        </div>
                    </div>
                </div>

                <?php if (!empty($editresult)) :
                    $staff = $editresult[0];
                    $statmsg = ($staff['status'] == 1) ? 'Enabled' : 'Disabled';
                ?>
                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                        <label>Staff's FullName</label>
                        <div class="form-group ic-cmp-int">
                            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
                            <div class="nk-int-st">
                                <input type="text" class="form-control" name="na" value="<?php echo htmlspecialchars($staff['staffname']); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                        <label>Current Status</label>
                        <div class="form-group ic-cmp-int">
                            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
                            <div class="nk-int-st">
                                <input type="text" class="form-control" name="current_status" value="<?php echo $statmsg; ?>" disabled>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>Change Status</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
                        <div class="nk-int-st">
                            <select class="form-control" name="status" required>
                                <option value="">Select Status</option>
                                <option value="1">Enable</option>
                                <option value="0">Disable</option>
                            </select>
                        </div>
                    </div>
                </div>

                <br><br>
                <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group ic-cmp-int">
                        <div class="nk-int-st">
                            <input type="submit" class="form-control" name="chg" value="Change Status" />
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include "foot.html"; ?>
