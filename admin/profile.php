<?php
// connect.php should start the session and create a PDO instance in $conn (or $pdo aliased to $conn)
include '../connect.php';

// Check user login
if (!isset($_SESSION['unamed'])) {
    header('Location: ../index.php');
    exit();
}

// Fetch School Information (use prepared statement even though no params — consistent practice)
try {
    $stmt = $pdo->prepare("SELECT * FROM lhpschool LIMIT 1");
    $stmt->execute();
    $school = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // In production you may want to log this and show a friendly message instead
    die("Database error: " . $e->getMessage());
}

// Provide safe defaults if table empty
$schname    = $school['schname']    ?? '';
$schmotto   = $school['motto']      ?? '';
$schyear    = $school['founded']    ?? '';
$schphone   = $school['phone']      ?? '';
$schemail   = $school['email']      ?? '';
$schweb     = $school['website']    ?? '';
$schaddress = $school['address']    ?? '';
$schlogo    = $school['logo']       ?? '';
$schowner   = $school['proprietor'] ?? '';
?>

<?php include "nav.php"; ?>

<!-- Main Menu area End-->
<!-- Breadcomb area Start-->
<div class="form-element-area">
    <div class="container">
        <div class="row">

            <div class="col-lg-12">
                <div class="form-element-list">
                    <div class="basic-tb-hd">
                        <h2>Manage School Profile</h2>
                        <p>Use the form below to modify your school Profile</p>

                        <h2>
                            <?php
                            if (!empty($_SESSION['eds'])) {
                                echo '<b>' . htmlspecialchars($_SESSION['eds']) . '</b>';
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
            <form method="POST" action="./app/schprofile.php" id="fupload" enctype="multipart/form-data" class="form-element-area">

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>Name of School</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="text" required class="form-control" name="schname" value="<?php echo htmlspecialchars($schname); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>Proprietor's Full Name</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="text" required class="form-control" name="schowner" value="<?php echo htmlspecialchars($schowner); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>School Motto</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="text" required class="form-control" name="schmotto" value="<?php echo htmlspecialchars($schmotto); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>School Address</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="text" required class="form-control" name="schaddress" value="<?php echo htmlspecialchars($schaddress); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>School Phone number</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="tel" required class="form-control" name="schphone" value="<?php echo htmlspecialchars($schphone); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>School Email</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="email" required class="form-control" name="schemail" value="<?php echo htmlspecialchars($schemail); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>School Website</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="url" class="form-control" name="schweb" value="<?php echo htmlspecialchars($schweb); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>Year School Founded</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="number" required class="form-control" name="schyear"
                                   min="1900" max="<?php echo date('Y'); ?>" value="<?php echo htmlspecialchars($schyear); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>Current School Logo</label>
                    <div class="form-group ic-cmp-int">
                        <div class="nk-int-st">
                            <?php if (!empty($schlogo) && file_exists(__DIR__ . "/../learn/asset/img/school/{$schlogo}")): ?>
                                <img src="<?php echo '../learn/asset/img/school/' . rawurlencode($schlogo); ?>" width="150" height="150" alt="School logo">
                            <?php else: ?>
                                <div class="text-muted">No logo uploaded</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <label>Upload School Logo</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="file" class="form-control" name="schlogo" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <br>

                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group ic-cmp-int">
                        <div class="nk-int-st">
                            <input type="submit" class="form-control btn-success" name="sch" value="Modify School Profile"/>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include "foot.html"; ?>
