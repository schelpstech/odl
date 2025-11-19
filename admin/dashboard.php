<?php
include "../connect.php";
include "nav.php";
?>


<!-- Main Menu area End-->
<!-- Breadcomb area Start-->
<div class="breadcomb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
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

<!-- Start Status area -->
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <?php
            // Array of tables and display names
            $status_cards = [
                ['table' => 'lhpclass', 'id' => 'classid', 'title' => 'Classes', 'link' => 'mgclass.php'],
                ['table' => 'lhpstaff', 'id' => 'staffid', 'title' => 'Instructors', 'link' => 'mgstaff.php'],
                ['table' => 'lhpuser', 'id' => 'id', 'title' => 'Learners', 'link' => 'mglearners.php'],
                ['table' => 'lhpnote', 'id' => 'noteid', 'title' => 'Learning Resources', 'link' => 'mglesson.php']
            ];

            foreach ($status_cards as $card) {
                $stmt = $pdo->prepare("SELECT COUNT(`{$card['id']}`) AS cnt FROM `{$card['table']}`");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $count = $row['cnt'];
            ?>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                    <div class="website-traffic-ctn">
                        <h2><span class="counter"><?php echo $count; ?></span></h2>
                        <a href="<?php echo $card['link']; ?>">
                            <h4><strong><?php echo $card['title']; ?></strong></h4>
                        </a>
                    </div>
                    <div class="sparkline-bar-stats1">1,2,3,4,5</div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Login Monitor Table -->
<div id="doc" class="data-table-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="data-table-list">
                    <div class="basic-tb-hd">
                        <h2>Login Monitor</h2>
                        <p>A list of all login attempts to the School E-learning Platform</p>
                    </div>
                    <div class="table-responsive">
                        <table id="data-table-basic" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>IP address</th>
                                    <th>Username</th>
                                    <th>Usertype</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM log ORDER BY udate DESC LIMIT 500");
                                $stmt->execute();
                                $logs = $stmt->fetchAll(PDO::FETCH_OBJ);
                                $count = 1;
                                foreach ($logs as $row) {
                                    $show = match ($row->stat) {
                                        1 => "Successful Login",
                                        2 => "Failed! Learner Account Deactivated",
                                        3 => "Failed! Incorrect Password",
                                        4 => "Failed! Wrong Username",
                                        default => "Unknown"
                                    };
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $row->uip; ?></td>
                                    <td><?php echo $row->uname; ?></td>
                                    <td><?php echo $row->utype; ?></td>
                                    <td><?php echo $show; ?></td>
                                    <td><?php echo $row->udate; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>IP address</th>
                                    <th>Username</th>
                                    <th>Usertype</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include "foot.html"; ?>
