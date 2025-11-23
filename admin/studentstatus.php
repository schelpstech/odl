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
            <h2>Change Learner Status</h2>
            <p>Use the form below to change Learners status </p>
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
          <label> Learner's FullName</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <input type="text" required="yes" class="form-control" name="na" disabled
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
          <label>Current Status</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <select type="text" disabled required="yes" class="form-control">
                <?php
                foreach ($editresult as $ed) {
                  $stat = $ed["status"];
                  if ($stat == 1) {
                    $statmsg = "Active";
                  } else {
                    $statmsg = "In-active";
                  }

                ?>
                  <option value="<?php echo $stat; ?>"><?php echo $statmsg; ?></option>
                <?php
                }
                ?>

              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Change Status</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <select type="text" required="yes" class="form-control" name="status">
                <option value="">Change Status</option>
                <option value="0">De-Activate</option>
                <option value="1">Activate</option>

              </select>
            </div>
          </div>
        </div>

        <br>
        <br>
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

</div>
</div>

<!-- Data Table area End-->
<!-- Start Footer area-->
<?php include "foot.html"; ?>

<!-- End Footer area-->