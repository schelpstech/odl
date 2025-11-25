<?php
include "./inc/nav.php";
// Fetch programme list with PDO
try {
    $stmt = $pdo->query("SELECT * FROM lpterm where status = 1");
    $term = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                        <h2>Create School Calendar Activity for This Semester</h2>
                        <p>Use the form below to add a new academic activity or event to the school calendar.</p>
                    </div>
                </div>
            </div>
        </div>

        <br><br><br>

        <div class="row">
            <form method="POST" action="./app/managecalendar.php" id="fupload">

                <!-- Select Term -->
                <div class="col-lg-4">
                    <label>Select Term / Semester</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-support"></i>
                        </div>
                        <div class="nk-int-st">
                            <select required class="form-control" name="term">
                                <?php foreach ($term as $t) { ?>
                                    <option value="<?= htmlspecialchars($t['term']); ?>">
                                        <?= htmlspecialchars($t['term']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Start Date -->
                <div class="col-lg-4">
                    <label>Start Date</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-calendar"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="date" required class="form-control" name="start_date">
                        </div>
                    </div>
                </div>

                <!-- End Date -->
                <div class="col-lg-4">
                    <label>End Date</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-calendar"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="date" required class="form-control" name="end_date">
                        </div>
                    </div>
                </div>


                <!-- Category -->
                <div class="col-lg-6">
                    <label>Category</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-menu"></i>
                        </div>
                        <div class="nk-int-st">
                            <select required class="form-control" name="category">
                                <option value="Holiday">Holiday</option>
                                <option value="Examination">Examination</option>
                                <option value="Continuous Assessment">Continuous Assessment</option>
                                <option value="Event">Event</option>
                                <option value="PTA">PTA</option>
                                <option value="Resumption">Resumption</option>
                                <option value="Closure">Closure</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <div class="col-lg-6">
                    <label>Event Title</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-edit"></i>
                        </div>
                        <div class="nk-int-st">
                            <input type="text" required class="form-control" name="title" placeholder="Enter event title">
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="col-lg-12">
                    <label>Description</label>
                    <div class="form-group ic-cmp-int">
                        <div class="form-ic-cmp">
                            <i class="notika-icon notika-chat"></i>
                        </div>
                        <div class="nk-int-st">
                            <textarea class="form-control" name="description" placeholder="Describe this event..." rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-lg-12">
                    <div class="form-group ic-cmp-int">
                        <div class="nk-int-st">
                            <input type="submit" class="form-control btn-success" name="create_calendar" value="Save Calendar Event">
                        </div>
                    </div>
                </div>

            </form>
        </div>


    </div>
</div>


<?php
try {
    $stmt = $pdo->query("
        SELECT calendar_id, term, title, description, start_date, end_date, category
        FROM lhpcalendar
        ORDER BY start_date ASC
    ");
    $calendar = $stmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!-- Data Table area Start-->
<div id="doc" class="data-table-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="data-table-list">
                    <div class="basic-tb-hd">
                        <h2>School Calendar Events</h2>
                        <p>A list of all events created for the school calendar.</p>
                    </div>

                    <div class="table-responsive">
                        <table id="data-table-basic" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Term</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Category</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($calendar as $row) {
                                ?>
                                    <tr>
                                        <td><?= $count++; ?></td>
                                        <td><?= htmlspecialchars($row->term); ?></td>
                                        <td><?= htmlspecialchars($row->title); ?></td>
                                        <td><?= htmlspecialchars($row->description); ?></td>
                                        <td><?= date("d M Y", strtotime($row->start_date)); ?></td>
                                        <td><?= date("d M Y", strtotime($row->end_date)); ?></td>
                                        <td><?= htmlspecialchars($row->category); ?></td>

                                        <td>
                                            <a href="delcalendar.php?id=<?= $row->calendar_id ?>"
                                                onclick="return confirm('Are you sure you want to delete this event?');"
                                                class="btn btn-danger">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Term</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Category</th>
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