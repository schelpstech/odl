<?php
include "./inc/nav.php";

// Fetch programme list with PDO
try {
    $stmt = $pdo->query("SELECT * FROM lhpclass ORDER BY classname ASC");
    $classresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

?>
<!-- Breadcomb area -->
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
                        printf('<b>%s</b>', $_SESSION['clmessage']);
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


<!-- Create Programme Section -->
<div class="form-element-area">
  <div class="container">
    <div class="row">

      <div class="col-lg-12">
        <div class="form-element-list">
          <div class="basic-tb-hd">
            <h2>Create Academic Programme</h2>
            <p>Use this form to create a new programme under the University ODL platform.</p>
          </div>
        </div>
      </div>

    </div>

    <br><br><br>

    <div class="row">
      <form method="POST" action="./app/createprog.php" id="fupload">

        <div class="col-lg-6">
          <label>Programme Name</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp">
              <i class="notika-icon notika-edit"></i>
            </div>

            <div class="nk-int-st">
              <input type="text" class="form-control" required name="crclass" placeholder="e.g. B.Sc Information Technology (ODL)">
            </div>
          </div>
        </div>

        <div class="col-lg-6"></div>

        <div class="col-lg-6">
          <div class="form-group ic-cmp-int">
            <div class="nk-int-st">
              <input type="submit" class="form-control btn-success" name="createprg" value="Create Programme" />
            </div>
          </div>
        </div>

      </form>
    </div>

  </div>
</div>


<!-- Programme List -->
<div id="doc" class="data-table-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">

        <div class="data-table-list">
          <div class="basic-tb-hd">
            <h2>Programme List</h2>
            <p>A list of all approved academic programmes under the University ODL model.</p>
          </div>

          <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Programme Name</th>
                  <th>Enrolled Students</th>
                  <th>Programme Adviser</th>
                  <th>Modify Adviser</th>
                </tr>
              </thead>

              <tbody>
                <?php
                // Get active term with PDO
                $stmt = $pdo->query("SELECT term FROM lpterm WHERE status = 1 LIMIT 1");
                $term = $stmt->fetchColumn();

                // Fetch all programmes (classes)
                $stmt = $pdo->prepare("SELECT * FROM lhpclass ORDER BY classname ASC");
                $stmt->execute();
                $programmes = $stmt->fetchAll(PDO::FETCH_OBJ);

                $count = 1;

                foreach ($programmes as $row):
                    $classid = $row->classid;
                    $cname   = $row->classname;

                    // Get programme population
                    $stmt = $pdo->prepare("SELECT COUNT(id) FROM lhpuser WHERE classid = ?");
                    $stmt->execute([$classid]);
                    $population = $stmt->fetchColumn();

                    // Get Adviser allocation
                    $stmt = $pdo->prepare("SELECT * FROM lhpclassalloc WHERE classid = ? AND term = ? LIMIT 1");
                    $stmt->execute([$classid, $term]);
                    $alloc = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($alloc && $alloc['tutorid'] != "") {

                        // Get adviser name
                        $stmt = $pdo->prepare("SELECT staffname FROM lhpstaff WHERE sname = ? LIMIT 1");
                        $stmt->execute([$alloc['tutorid']]);
                        $tutor = $stmt->fetchColumn();

                        $assign = '<a href="deltutor.php?refid=' . $alloc['classlocid']
                                . '" class="btn btn-danger"><strong>Remove Adviser</strong></a>';

                    } else {

                        $tutor = "Not Assigned";
                        $assign = '<a href="allocateclass.php?classid=' . $classid
                                . '" class="btn btn-success"><strong>Assign Adviser</strong></a>';

                    }
                ?>
                <tr>
                  <td><strong><?= $count++ ?></strong></td>
                  <td><strong><?= $cname ?></strong></td>
                  <td><strong><?= $population ?></strong></td>
                  <td><strong><?= $tutor ?></strong></td>
                  <td><?= $assign ?></td>
                </tr>

                <?php endforeach; ?>
              </tbody>

              <tfoot>
                <tr>
                  <th>S/N</th>
                  <th>Programme Name</th>
                  <th>Enrolled Students</th>
                  <th>Programme Adviser</th>
                  <th>Modify Adviser</th>
                </tr>
              </tfoot>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include "foot.html"; ?>
