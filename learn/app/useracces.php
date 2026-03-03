<?php
session_start();
include '../app/query.php';

$valErr = '';
$userid = '';
$userpwd = '';
$usertype = '';
$login_details = [];

/* ===================== LOGOUT ===================== */
if (isset($_POST['logout']) && $_POST['logout'] === 'logout') {

    $model->log_out_user();

    $_SESSION['msg'] = '
        <div class="alert text-white bg-info d-flex align-items-center justify-content-between" role="alert">
            <div class="alert-text">Bye! <b>Log out successful</b>!</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';

    $model->redirect('../view/index.php');
}


/* ===================== LOGIN ===================== */
if (isset($_POST['log_in']) && $_POST['log_in'] === 'Log in') {

    /* ===== Validate Inputs ===== */
    if (empty($_POST['userid'])) {
        $valErr .= 'Username field must not be empty!.<br/>';
    } else {
        $userid = htmlspecialchars(trim($_POST['userid']));
    }

    if (empty($_POST['userpwd'])) {
        $valErr .= 'Password field must not be empty!.<br/>';
    } else {
        $userpwd = trim($_POST['userpwd']);
    }

    if (!empty($valErr)) {
        $_SESSION['msg'] = '
            <div class="alert text-white bg-danger d-flex align-items-center justify-content-between">
                <div class="alert-text">Error! <br>' . $valErr . '</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
        $model->redirect('../view/index.php');
    }

    /* ===== Check Learner Table ===== */
    $confirm_learner = $model->getRows('lhpuser', [
        'return_type' => 'single',
        'where' => ['uname' => $userid]
    ]);

    /* ===== Check Staff Table ===== */
    $confirm_staff = $model->getRows('lhpstaff', [
        'return_type' => 'single',
        'where' => ['sname' => $userid]
    ]);

    if (!empty($confirm_learner)) {
        $usertype = 'Learner';
        $login_details = $confirm_learner;
        $password = $login_details['upwd'] ?? '';
    } 
    elseif (!empty($confirm_staff)) {
        $usertype = 'Instructor';
        $login_details = $confirm_staff;
        $password = $login_details['spwd'] ?? '';
    } 
    else {
        $valErr = 'Invalid Login Credentials!.<br/>';

        $model->insert_data('log', [
            'uname' => $userid,
            'utype' => 'unknown',
            'uip'   => $_SERVER['REMOTE_ADDR'],
            'stat'  => 4
        ]);

        $_SESSION['msg'] = '
            <div class="alert text-white bg-danger d-flex align-items-center justify-content-between">
                <div class="alert-text">Error! <br>' . $valErr . '</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';

        $model->redirect('../view/index.php');
    }

    /* ===== Verify Password ===== */
    if (!empty($password) && password_verify($userpwd, $password)) {

        /* ===== Check Active Status ===== */
        if (isset($login_details['status']) && (int)$login_details['status'] === 1) {

            $model->insert_data('log', [
                'uname' => $userid,
                'utype' => $usertype,
                'uip'   => $_SERVER['REMOTE_ADDR'],
                'stat'  => 1
            ]);

            $_SESSION['active'] = $userid;
            $_SESSION['user_type'] = $usertype;

            $_SESSION['msg'] = '
                <div class="alert text-white bg-success d-flex align-items-center justify-content-between">
                    <div class="alert-text">Welcome! <b>Log in successful</b>!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';

            if ($usertype === 'Learner') {
                $model->redirect('../view/learner/index.php');
            } else {
                $model->redirect('../view/instructor/index.php');
            }

        } else {

            $valErr = 'Access Denied! Contact school administrator.<br/>';

            $model->insert_data('log', [
                'uname' => $userid,
                'utype' => $usertype,
                'uip'   => $_SERVER['REMOTE_ADDR'],
                'stat'  => 2
            ]);
        }

    } else {

        $valErr = 'Invalid Login Credentials!.<br/>';

        $model->insert_data('log', [
            'uname' => $userid,
            'utype' => $usertype,
            'uip'   => $_SERVER['REMOTE_ADDR'],
            'stat'  => 3
        ]);
    }

    $_SESSION['msg'] = '
        <div class="alert text-white bg-danger d-flex align-items-center justify-content-between">
            <div class="alert-text">Error! <br>' . $valErr . '</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';

    $model->redirect('../view/index.php');
}
?>