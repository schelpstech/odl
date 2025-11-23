<?php
include "./inc/nav.php";
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
            <h2>Create Instructor Account</h2>
            <p>Use the form below to create instructor account </p>
            <h2>
              <?php
                if (!empty($_SESSION['ssmessaged'])) {
                    echo '<b>' . htmlspecialchars($_SESSION['ssmessaged']) . '</b>';
                    unset($_SESSION['ssmessaged']);
                }
              ?>
            </h2>
          </div>
        </div>
      </div>
    </div>

    <br><br><br>

    <div class="row">
      <form method="POST" action="./app/managestaff.php" class="form-element-area" id="fupload" enctype="multipart/form-data">
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Instructor Full Name</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <input type="text" required class="form-control" name="stname" placeholder="Enter Instructor Fullname">
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Instructor UserName</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <input type="text" required class="form-control" maxlength="12" name="stuname" placeholder="Enter Instructor Login Username">
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Instructor Password</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <input type="password" required class="form-control" name="stpwd" autocomplete="new-password" placeholder="Enter Instructor Log in Password">
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Instructor  Email Address</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <input type="email" required class="form-control" name="stmail" placeholder="Instructor Email address">
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Instructor Phone number</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <input type="tel" required class="form-control" maxlength="11" name="stfone" placeholder="Instructor Phonenumber">
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
          <label>Instructor Designation</label>
          <div class="form-group ic-cmp-int">
            <div class="form-ic-cmp"><i class="notika-icon notika-support"></i></div>
            <div class="nk-int-st">
              <select class="form-control" name="role" required>
                <option selected value="t">Teaching Instructor</option>
              </select>
            </div>
          </div>
        </div>

        <br><br>

        <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
          <div class="form-group ic-cmp-int">
            <div class="nk-int-st">
              <input type="submit" class="form-control  btn-primary" name="createst" value="Create Instructor Account" />
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
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="data-table-list">
          <div class="basic-tb-hd">
            <h2>Instructor Details</h2>
            <p>Instructor Contact and Log in details</p>
          </div>

          <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Full name</th>
                  <th>Username</th>
                  <th>Phonenumber</th>
                  <th>Email</th>
                  <th>Edit</th>
                  <th>Change Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Fetch staff using $pdo
                try {
                    $stmt = $pdo->prepare("SELECT * FROM lhpstaff ORDER BY staffname DESC");
                    $stmt->execute();
                    $count = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                        $staffname = htmlspecialchars($row->staffname);
                        $sname     = htmlspecialchars($row->sname);
                        $sfone     = htmlspecialchars($row->sfone);
                        $semail    = htmlspecialchars($row->semail);
                        $status    = (int)$row->status;

                        if ($status === 1) {
                            $stat = '<a href="stafffstatus.php?unamd=' . urlencode($row->sname) . '" class="btn btn-success">Active. Change</a>';
                        } else {
                            $stat = '<a href="stafffstatus.php?unamd=' . urlencode($row->sname) . '" class="btn btn-danger">Inactive. Change</a>';
                        }
                ?>
                        <tr>
                          <td><?php echo $count++; ?></td>
                          <td><?php echo $staffname; ?></td>
                          <td><?php echo $sname; ?></td>
                          <td><?php echo $sfone; ?></td>
                          <td><?php echo $semail; ?></td>
                          <td><a href="staffedit.php?un=<?php echo urlencode($row->sname); ?>" class="btn btn-info">Edit</a></td>
                          <td><?php echo $stat; ?></td>
                        </tr>
                <?php
                    }
                } catch (PDOException $e) {
                    // handle error gracefully - show a single table row with the error
                    echo '<tr><td colspan="8">Error fetching staff: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>S/N</th>
                  <th>Full name</th>
                  <th>Username</th>
                  <th>Phonenumber</th>
                  <th>Email</th>
                  <th>Edit</th>
                  <th>Change Status</th>
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
