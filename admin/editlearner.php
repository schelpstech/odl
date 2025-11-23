<?php
include "./inc/nav.php";

if (!empty($_GET['unam'])) {
  $edt = $_GET["unam"];
}
// Fetch class list
try {
  $stmt = $pdo->query("SELECT * FROM lhpuser WHERE uname = '$edt'");
  $editresult = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = $pdo->query("SELECT * FROM lhpclass ORDER BY classname ASC");
  $classresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Database error: " . $e->getMessage());
}
?>
<div class="form-element-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-element-list">
          <div class="basic-tb-hd">
            <h2>Edit Learners Details</h2>
            <p>Use the form below to modify Learners account </p>
            <h2> <?php

                  if (isset($_SESSION['eds']) && $_SESSION['eds']) {
                    printf('<b>%s</b>', $_SESSION['eds']);
                    unset($_SESSION['eds']);
                  }
                  ?></h2>
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
      <form method="POST" action="./app/managelearner.php" class="form-element-area" id="fupload" enctype="multipart/form-data">

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12" hidden>
          <label> Learner's UserName</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <input type="text" required="yes" class="form-control" name="named" value="<?php echo $edt; ?>">
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label> Learner's Fullname</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <input type="text" required="yes" class="form-control" name="nname"
                <?php
                foreach ($editresult as $ed) {
                ?>
                value="<?php echo $ed["fname"]; ?>">
            <?php
                }
            ?>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label> Learner's Date of Birth</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <input type="date" required="yes" class="form-control" name="dob"
                <?php
                foreach ($editresult as $ed) {
                ?>
                value="<?php echo $ed["dob"]; ?>">
            <?php
                }
            ?>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Select Gender</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <select type="text" required="yes" class="form-control" name="gender">
                <?php
                foreach ($editresult as $ed) {
                  $gender = $ed["gender"]
                ?>
                <?php
                }
                ?>

                <option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>

              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label> Learner's Email Address</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <input type="text" required="yes" class="form-control" name="nemail"
                <?php
                foreach ($editresult as $ed) {
                ?>
                value="<?php echo $ed["email"]; ?>">
            <?php
                }
            ?>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Select Class</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <select type="text" required="yes" class="form-control" name="nclass">
                <?php
                foreach ($editresult as $ed) {
                  $cname = $ed["classid"]
                ?>
                <?php
                }
                ?>
                <?php
                // Fetch selected class name
                $stmt = $pdo->prepare("SELECT classname FROM lhpclass WHERE classid = ?");
                $stmt->execute([$cname]);
                $classname = $stmt->fetchColumn();
                ?>
                <option value="<?php echo $cname; ?>"><?php echo $classname; ?></option>
                <option disabled>-------Select Programme-------</option>
                <?php
                foreach ($classresult as $classed) {
                ?>
                  <option value="<?php echo $classed["classid"]; ?>"><?php echo $classed["classname"]; ?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>
        </div>

        <br>
        <br>
        <div class="row">
          <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group ic-cmp-int">
              <div class="nk-int-st">
                <input type="submit" class="form-control btn-success" name="edstdt" value="Modify Learner Details" />
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group ic-cmp-int">
              <div class="nk-int-st">
                <input
                  type="submit"
                  class="form-control btn-warning"
                  name="rst"
                  value="Reset Password"
                  onclick="return confirm('Are you sure you want to reset this learner\'s password to Default123?');" />
              </div>
            </div>
          </div>

        </div>
      </form>

    </div>
  </div>
</div>

</div>
</div>

<!-- Data Table area End-->
<!-- Start Footer area-->
<?php include "foot.html"; ?>

<!-- End Footer area-->