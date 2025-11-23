<?php
include "./inc/nav.php";
// Fetch programme list with PDO
try {
  $stmt = $pdo->query("SELECT * FROM lhpclass ORDER BY classname ASC");
  $programmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Database error: " . $e->getMessage());
}
?>

<!-- Breadcomb area Start-->
<div class="breadcomb-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="breadcomb-list">
          <div class="row">
            <div class="col-lg-6">
              <div class="breadcomb-wp">
                <div class="breadcomb-icon">
                  <i class="notika-icon notika-support"></i>
                </div>
                <div class="breadcomb-ctn">
                  <h2>Welcome Administrator</h2>
                  <h2>
                    <?php
                    if (isset($_SESSION['clmessage']) && $_SESSION['clmessage']) {
                      echo "<b>{$_SESSION['clmessage']}</b>";
                      unset($_SESSION['clmessage']);
                    }
                    ?>
                  </h2>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="breadcomb-report">
                <button type="button" onclick="generatePDF()" title="Download PDF" class="btn">
                  <i class="notika-icon notika-sent"></i>
                </button>
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
      <div class="col-lg-12">
        <div class="form-element-list">
          <div class="basic-tb-hd">
            <h2>Create Course</h2>
            <p>Use the form below to create a new course under any programme.</p>
          </div>
        </div>
      </div>
    </div>

    <br><br><br>

    <div class="row">
      <form method="POST" action="./app/createCourse.php" id="fupload" enctype="multipart/form-data">

        <div class="col-lg-3">
          <label>Select Programme</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>
            <div class="nk-int-st">
              <select required class="form-control" name="sbjclass">
                <option value="">Select Programme</option>

                <?php foreach ($programmes as $p) { ?>
                  <option value="<?= $p['classid']; ?>">
                    <?= htmlspecialchars($p['classname']); ?>
                  </option>
                <?php } ?>

              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-3">
          <label>Course Code</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>
            <div class="nk-int-st">
              <input type="text" required class="form-control" name="sbjcode" placeholder="Enter Course Code">
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <label>Course Name</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-support"></i>
            </div>
            <div class="nk-int-st">
              <input type="text" required class="form-control" name="sbjname" placeholder="Enter Course Name">
            </div>
          </div>
        </div>

        <br><br>

        <div class="col-lg-6">
          <div class="form-group ic-cmp-int">
            <div class="nk-int-st">
              <input type="submit" class="form-control btn-success" name="createsb" value="Create Course">
            </div>
          </div>
        </div>

      </form>
    </div>

  </div>
</div>

<!-- Data Table area Start-->
<div id="doc" class="data-table-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="data-table-list">
          <div class="basic-tb-hd">
            <h2>Course List</h2>
            <p>A list of all courses created under the university programmes.</p>
          </div>

          <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Programme</th>
                  <th>Course</th>
                  <th>Delete</th>
                </tr>
              </thead>

              <tbody>
                <?php
                try {
                  $stmt = $pdo->query("
                        SELECT s.sbjid, s.sbjname, c.classname
                        FROM lhpsubject s
                        LEFT JOIN lhpclass c ON s.classid = c.classid
                        ORDER BY c.classname ASC
                    ");

                  $courses = $stmt->fetchAll(PDO::FETCH_OBJ);
                } catch (PDOException $e) {
                  die("Database error: " . $e->getMessage());
                }

                $count = 1;
                foreach ($courses as $row) {
                ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($row->classname); ?></td>
                    <td><?= htmlspecialchars($row->sbjname); ?></td>
                    <td>
                      <a href="delsubject.php?id=<?= $row->sbjid ?>&sbjref=<?= urlencode($row->sbjname) ?>&classref=<?= urlencode($row->classname) ?>"
                        class="btn btn-danger">
                        Delete Course
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>

              <tfoot>
                <tr>
                  <th>S/N</th>
                  <th>Programme</th>
                  <th>Course</th>
                  <th>Delete</th>
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

<?php include "foot.html"; ?>