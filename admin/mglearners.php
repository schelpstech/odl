<?php
include "./inc/nav.php";


// Fetch class list
try {
  $stmt = $pdo->query("SELECT * FROM lhpclass ORDER BY classname ASC");
  $classresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Database error: " . $e->getMessage());
}

?>
<!-- Main Menu area End-->

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
                  <h2>Welcome Admin</h2>
                  <p><span class="bread-ntd"></span></p>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="breadcomb-report">
                <button type="button" onclick="generatePDF()" class="btn">
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
            <h2>Create Learners Account</h2>
            <p>Use the form below to create Learners account</p>
            <h2>
              <?php
              if (isset($_SESSION['lsmessaged']) && $_SESSION['lsmessaged']) {
                echo "<b>{$_SESSION['lsmessaged']}</b>";
                unset($_SESSION['lsmessaged']);
              }
              ?>
            </h2>
          </div>
        </div>
      </div>
    </div>

    <br><br><br>

    <div class="row">
      <form method="POST" action="./app/managelearner.php" class="form-element-area" id="fupload" enctype="multipart/form-data">

        <div class="col-lg-6">
          <label>Learner's Full Name</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <input type="text" class="form-control" name="lname" required placeholder="Enter Learner's Fullname">
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <label>Learner's Username</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <input type="text" class="form-control" maxlength="16" name="luname" required placeholder="Enter Username">
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Learner's Password</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <input type="text" required class="form-control" name="lpwd" disabled value="Default123" >
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <label>Learner's Gender</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <select name="gender" class="form-control" required>
                <option value="">Enter Learner's Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <label>Learner's Date of Birth</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <input type="date" class="form-control" name="dob" required>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <label>Learner's Email Address</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <input type="email" class="form-control" name="lmail" required placeholder="Enter Email">
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <label>Select Class</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <select name="lclass" required class="form-control">
                <option value="">Select Class</option>
                <?php foreach ($classresult as $classed): ?>
                  <option value="<?= $classed['classid'] ?>">
                    <?= $classed['classname'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-12">
          <div class="form-group ic-cmp-int">
            <div class="nk-int-st">
              <input type="submit" class="form-control" name="createlearner" value="Create Learner Account">
            </div>
          </div>
        </div>

      </form>
    </div>

  </div>
</div>


<!-- Learners List Table -->
<div id="doc" class="data-table-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">

        <div class="data-table-list">
          <div class="basic-tb-hd">
            <h2>Learners' List</h2>
            <p>Learners' Contact and Login Details</p>
          </div>

          <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Class</th>
                  <th>Full name</th>
                  <th>Username</th>
                  <th>Gender</th>
                  <th>Date of Birth</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Edit</th>
                </tr>
              </thead>

              <tbody>

                <?php
                $query = $pdo->prepare("SELECT * FROM lhpuser ORDER BY classid DESC");
                $query->execute();
                $sn = 1;

                while ($row = $query->fetch(PDO::FETCH_OBJ)) {

                  // Get class name
                  $classStmt = $pdo->prepare("SELECT classname FROM lhpclass WHERE classid = ?");
                  $classStmt->execute([$row->classid]);
                  $classRow = $classStmt->fetch(PDO::FETCH_ASSOC);
                  $classname = $classRow['classname'] ?? 'Unknown';

                  // Status button
                  if ($row->status == 1) {
                    $statusBtn = '<a href="studentstatus.php?unam=' . $row->uname . '" class="btn btn-success">Active. Change</a>';
                  } else {
                    $statusBtn = '<a href="studentstatus.php?unam=' . $row->uname . '" class="btn btn-danger">Inactive. Change</a>';
                  }
                ?>
                  <tr>
                    <td><?= $sn++ ?></td>
                    <td><?= $classname ?></td>
                    <td><?= $row->fname ?></td>
                    <td><?= $row->uname ?></td>
                    <td><?= $row->gender ?></td>
                    <td><?= $row->dob ?></td>
                    <td><?= $row->email ?></td>
                    <td><?= $statusBtn ?></td>
                    <td>
                      <a href="editlearner.php?unam=<?= $row->uname ?>" class="btn btn-info">Edit</a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>S/N</th>
                  <th>Class</th>
                  <th>Full name</th>
                  <th>Username</th>
                  <th>Gender</th>
                  <th>Date of Birth</th>
                  <th>Email </th>
                  <th>Status</th>
                  <th>Edit </th>
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