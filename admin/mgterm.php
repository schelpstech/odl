<?php
include "./inc/nav.php";

try {
  // Fetch active academic session
  $stmt = $pdo->query("SELECT * FROM lhpSession WHERE status = 1 ORDER BY session DESC");
  $activeSession = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Fetch semesters
  $stmt = $pdo->query("SELECT tid, term, status FROM lpterm ORDER BY tid DESC");
  $semesterList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Database error: " . $e->getMessage());
}
?>


<!-- Main Menu area End-->
<!-- Breadcomb area Start-->
<div class="breadcomb-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="breadcomb-list">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="breadcomb-wp">
                <div class="breadcomb-icon">
                  <i class="notika-icon notika-support"></i>
                </div>
                <div class="breadcomb-ctn">
                  <h2>Welcome Admin</h2>
                  <p>.<span class="bread-ntd"></span></p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
              <div class="breadcomb-report">
                <button type="button" onclick="generatePDF()" title="Download PDF" class="btn"><i class="notika-icon notika-sent"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="form-element-area">
  <div class="container">
    <div class="row">

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-element-list">
          <div class="basic-tb-hd">
            <h2>Semester Configuration</h2>
            <p>Use the form below to configure a term </p>
            <h2> <?php

                  if (isset($_SESSION['remessage']) && $_SESSION['remessage']) {
                    printf('<b>%s</b>', $_SESSION['remessage']);
                    unset($_SESSION['remessage']);
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
      <form method="POST" action="./app/configterm.php" class="form-element-area" id="fupload" enctype="multipart/form-data">
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Select New Semester</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <select type="text" required="yes" class="form-control" name="term">
                <option value=""> Select Semester</option>
                <option value="1st Semester"> 1st Semester</option>
                <option value="2nd Semester"> 2nd Semester</option>
                <option value="3rd Semester"> 3rd Semester</option>
              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Active Academic Session</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>

            <div class="nk-int-st">
              <select type="text" required="yes" class="form-control" name="actSession">
                <?php
                foreach ($activeSession as $actSession) {
                ?>
                  <option value="<?php echo $actSession["session"]; ?>"><?php echo $actSession["session"]; ?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <br>
        <br>
        <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">

          <div class="form-group ic-cmp-int">

            <div class="nk-int-st">
              <input type="submit" class="form-control" name="configterm" value="Create Term Record" />
            </div>
          </div>
        </div>


      </form>

    </div>
  </div>
</div>

</div>
</div>

<!-- Breadcomb area End-->
<!-- Data Table area Start-->
<div id="doc" class="data-table-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="data-table-list">
          <div class="basic-tb-hd">
            <h2>
              Semester Configurations
            </h2>

          </div>
          <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Semester</th>
                  <th>Semester Status</th>
                  <th>Modify Semester Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $count = 1;

                foreach ($semesterList as $row) {
                  $termId = $row['tid'];
                  $term = $row['term'];
                  $status = $row['status'];

                  if ($status == 1) {
                    $statusBadge = '<a disabled class="btn btn-success">Current Semester</a>';
                    $actionBtn = '<a class="btn btn-warning" disabled>Active Semester</a>';
                  } else {
                    $statusBadge = '<a disabled class="btn btn-primary">Inactive / Previous Semester</a>';
                    $actionBtn = '<a href="modifyTerm.php?termref=' . $termId . '" class="btn btn-info">Activate Semester</a>';
                  }
                ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo htmlspecialchars($term); ?></td>
                    <td><?php echo $statusBadge; ?></td>
                    <td><?php echo $actionBtn; ?></td>
                  </tr>
                <?php } ?>
              </tbody>


              </tbody>
              <tfoot>
                <tr>
                  <th>S/N</th>
                  <th>Semester</th>
                  <th>Semester Status</th>
                  <th>Modify Semester Status</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Data Table area End-->
<!-- Start Footer area-->
<?php include "foot.html"; ?>
<!-- End Footer area-->