<?php
include '../include/header.php';
include '../include/nav.php';
include '../include/navigator.php';
?>
<div class="main_content_iner overly_inner ">
    <div class="container-fluid p-0 ">


        <div class="row ">
            <div class="col-xl-12">
                <div class="white_card card_height_100 mb_30">
                    <div class="date_picker_wrapper">
                        <div class="default-datepicker">
                            <div class="datepicker-here" data-language='en'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box_body">
            <div class="white_card_body QA_section">
                <div class="todo_wrapper">

                    <?php
                    if (!empty($calendar_list)) {
                        $count = 1;
                        foreach ($calendar_list as $item) {
                    ?>
                            <div class="single_todo d-flex justify-content-between align-items-center">
                                <div class="lodo_left d-flex align-items-center">
                                    <div class="bar_line mr_10"></div>

                                    <div class="todo_box">
                                        <label class="form-label primary_checkbox d-flex mr_10">
                                            <p class="f_s_18 f_w_900 mb-0">
                                                <small><?php echo $count++; ?></small>
                                            </p>
                                            <input type="checkbox" disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                    <div class="lodo_right">
                                        <a class="badge_complete">
                                            <p class="f_s_18 f_w_900 mb-0">
                                                <small><?php echo htmlspecialchars($item['category']) . " :: " . htmlspecialchars($item['title']); ?></small>
                                            </p>
                                        </a>
                                    </div>

                                    <div class="todo_head">
                                        <h6><strong><?php echo date("d M Y", strtotime($item['start_date'])); ?></strong>
                                            &nbsp; to &nbsp;
                                            <strong><?php echo date("d M Y", strtotime($item['end_date'])); ?></strong>
                                        </h6>
                                        <h6 class="f_s_12 mb-0 text_color_8">
                                            <?php echo htmlspecialchars($item['description']); ?>
                                        </h6>
                                    </div>
                                </div>

                                <?php
                                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === "Instructor") {
                                    echo '
                            <div class="lodo_right">
                                <a href="../../app/router.php?pageid=calendar&item=modify_calendar&item_ref=' . $item['calendar_id'] . '" class="mark_complete">
                                    <p class="f_s_18 f_w_900 mb-0">Modify</p>
                                </a>
                            </div>';
                                }
                                ?>
                            </div>

                    <?php
                        }
                    } else {
                        echo '
                <div class="single_todo d-flex justify-content-between align-items-center">
                    <div class="lodo_left d-flex align-items-center">
                        <div class="bar_line mr_10"></div>
                        <div class="todo_head">
                            <h5 class="f_s_18 f_w_900 mb-0">No calendar events available</h5>
                            <p class="f_s_12 f_w_400 mb-0 text_color_8"></p>
                        </div>
                    </div>
                    <div class="lodo_right">
                        <a class="badge_complete">as at ' . date("d-m-Y") . '</a>
                    </div>
                </div>';
                    }
                    ?>

                </div>
            </div>
        </div>

    </div>
</div>


</section>
<?php
include '../include/footer.php';
?>