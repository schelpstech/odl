<?php
include './inc/nav.php';

try {
  // Fetch all programmes (classes)
  $stmt = $pdo->query('SELECT classid, classname FROM lhpclass ORDER BY classname ASC');
  $programmes = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Fetch instructors
  $stmt = $pdo->query('SELECT sname, staffname FROM lhpstaff WHERE status = 1 ORDER BY staffname ASC');
  $instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Fetch active terms
  $stmt = $pdo->query('SELECT term FROM lpterm WHERE status = 1');
  $terms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die('Database error: ' . $e->getMessage());
}
?>

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
                  <h2> <?php
                        if (isset($_SESSION['clmessage']) && $_SESSION['clmessage']) {
                          printf('<b>%s</b>', $_SESSION['clmessage']);
                          unset($_SESSION['clmessage']);
                        }
                        ?></h2>
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
            <h2>Allocate Course to Instructor</h2>
            <p>Select a programme, course, instructor, and supervisor.</p>
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    <br>


    <form method="POST" action="doallocate.php">
      <!-- TERM -->
      <div class="row">
        <div class="col-lg-6">
          <label>Select Academic Semester</label>
          <select class="form-control" name="term" required>
            <?php foreach ($terms as $t): ?>
              <option value="<?= $t['term'] ?>"><?= $t['term'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- PROGRAMME -->
        <div class="col-lg-6">
          <label>Select Programme</label>
          <select class="form-control" name="classd" id="class-list" required onchange="getclass();">
            <option value="">Select Programme</option>
            <?php foreach ($programmes as $p): ?>
              <option value="<?= $p['classid'] ?>"><?= $p['classname'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <br>
      <!-- COURSE -->
      <div class="row">
        <div class="col-lg-6">
          <label>Select Course</label>
          <select class="form-control" name="sbj" id="sbj-list" required>
            <option value="">Select Course</option>
          </select>
        </div>

        <!-- INSTRUCTOR -->
        <div class="col-lg-6 ">
          <label>Select Instructor</label>
          <select class="form-control" name="instructor" required>
            <option value="">Select Instructor</option>
            <?php foreach ($instructors as $i): ?>
              <option value="<?= $i['sname'] ?>"><?= $i['staffname'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>


      <!-- SUBMIT -->
      <div class="col-lg-6 offset-3">
        <br>
        <input type="submit" class="form-control  btn-success" name="allocate" value="Allocate Course">
      </div>
    </form>

  </div>
</div>
<br>
<br>
<br>

<!-- Breadcomb area End-->
<!-- Data Table area Start-->
<div id="doc" class="data-table-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="data-table-list">
          <div class="basic-tb-hd">
            <h2>Subject Allocation List

            </h2>
            <p></p>
          </div>
          <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Term</th>
                  <th>Class name</th>
                  <th>Subject</th>
                  <th>Instructor</th>
                  <th>Supervisor</th>
                  <th>Modify</th>


                </tr>
              </thead>


              <?php
              try {
                // Get active term
                $stmt = $pdo->query('SELECT term FROM lpterm WHERE status = 1 LIMIT 1');
                $activeTerm = $stmt->fetchColumn();

                // Fetch allocations
                $stmt = $pdo->prepare('
        SELECT a.*, 
               s1.staffname AS instructor_name,
               s2.staffname AS supervisor_name
        FROM lhpalloc a
        LEFT JOIN lhpstaff s1 ON a.staffid = s1.sname
        LEFT JOIN lhpstaff s2 ON a.supro = s2.sname
        WHERE a.term = ?
        ORDER BY a.classname ASC
    ');
                $stmt->execute([$activeTerm]);
                $allocations = $stmt->fetchAll(PDO::FETCH_ASSOC);
              } catch (PDOException $e) {
                die('Database error: ' . $e->getMessage());
              }
              ?>

              <tbody>
                <?php $count = 1;
                foreach ($allocations as $row): ?>
                  <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $row['term'] ?></td>
                    <td><?= $row['classname'] ?></td>
                    <td><?= $row['subject'] ?></td>
                    <td><?= $row['instructor_name'] ?></td>
                    <td><?= $row['supervisor_name'] ?></td>
                    <td>
                      <a href="allocatedit.php?ref=<?= $row['aid'] ?>" class="btn btn-warning">
                        Modify
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>

              <tfoot>
                <tr>
                  <th>S/N</th>
                  <th>Term</th>
                  <th>Class name</th>
                  <th>Subject</th>
                  <th>Instructor</th>
                  <th>Supervisor</th>
                  <th>Modify</th>
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
<?php include 'foot.html'; ?>
<!-- End Footer area-->