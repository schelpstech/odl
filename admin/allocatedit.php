<?php
include './inc/nav.php';

if (!empty($_GET['ref'])) {
  $ref = $_GET["ref"];
  $_SESSION["ref"] = $ref;
}

try {

  // Fetch allocation (Programme–Course–Lecturer mapping)
  $stmt = $pdo->prepare("
        SELECT 
            a.*,
            c.classname AS programme_name,
            s.sbjname AS course_name,
            s.courseId AS course_code,
            st.staffname AS lecturer_name
        FROM lhpalloc a
        LEFT JOIN lhpclass c ON a.classid = c.classid
        LEFT JOIN lhpsubject s ON a.sbjid = s.sbjid
        LEFT JOIN lhpstaff st ON a.staffid = st.sname
        WHERE a.aid = ?
        LIMIT 1
    ");
  $stmt->execute([$ref]);
  $alloc = $stmt->fetch(PDO::FETCH_ASSOC);

  // Fetch all active lecturers
  $stmt = $pdo->query("SELECT sname, staffname FROM lhpstaff WHERE status = 1 ORDER BY staffname ASC");
  $instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die('Database error: ' . $e->getMessage());
}
?>

<div class="form-element-area">
  <div class="container">

    <div class="row">
      <div class="col-lg-12">
        <div class="form-element-list">
          <div class="basic-tb-hd">
            <h2>Edit Course Allocation</h2>
            <p>This form allows you to modify the Course–Lecturer assignment for the selected academic term.</p>

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
      <form method="POST" action="./app/editallocated.php" class="form-element-area" id="fupload">

        <!-- TERM (hidden) -->
        <div class="col-lg-6">
          <label>Academic Term</label>
          <div class="form-group ic-cmp-int">
            <div class="nk-int-st">
              <select class="form-control" disabled name="term">
                <option value="<?php echo $alloc['term']; ?>">
                  <?php echo $alloc['term']; ?>
                </option>
              </select>
            </div>
          </div>
        </div>

        <!-- PROGRAMME -->
        <div class="col-lg-6">
          <label>Programme :</label>
          <div class="form-group ic-cmp-int">
            <div class="nk-int-st">
              <select class="form-control" name="allclass" disabled readonly>
                <option value="<?php echo $alloc['classid']; ?>">
                  <?php echo $alloc['programme_name']; ?>
                </option>
              </select>
            </div>
          </div>
        </div>

        <!-- COURSE -->
        <div class="col-lg-6">
          <label>Course :</label>
          <div class="form-group ic-cmp-int">
            <div class="nk-int-st">
              <select class="form-control" name="allsubject" disabled readonly>
                <option value="<?php echo $alloc['sbjid']; ?>">
                  <?php echo $alloc['course_code'] . " - " . $alloc['course_name']; ?>
                </option>
              </select>
            </div>
          </div>
        </div>

        <!-- LECTURER -->
        <div class="col-lg-6">
          <label>Lecturer :</label>
          <div class="form-group ic-cmp-int">
            <div class="nk-int-st">
              <select class="form-control" name="newinstructor" required>

                <!-- Current lecturer -->
                <option value="<?php echo $alloc['staffid']; ?>">
                  <?php echo $alloc['lecturer_name']; ?>
                </option>

                <option disabled>----------SELECT ANOTHER ----------</option>

                <!-- Other available lecturers -->
                <?php foreach ($instructors as $stf): ?>
                  <option value="<?php echo $stf['sname']; ?>">
                    <?php echo $stf['staffname']; ?>
                  </option>
                <?php endforeach; ?>

              </select>
            </div>
          </div>
        </div>

        <!-- SAVE BUTTON -->
        <div class="col-lg-6">
          <div class="form-group ic-cmp-int">
            <div class="nk-int-st">
              <button type="submit" class="btn btn-success" name="editalloc">
                Update Course Allocation
              </button>
            </div>
          </div>
        </div>
        <!-- DELETE BUTTON -->
        <div class="col-lg-6">
          <div class="form-group ic-cmp-int">
            <div class="nk-int-st">
              <a
                href="./app/editallocated.php?ref=<?php echo $ref; ?>"
                class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this course allocation?');">
                <strong>Delete Course Allocation</strong>
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>

  </div>
</div>

<?php include "foot.html"; ?>