<?php
// Load PDO connector (expects $pdo). If connect.php defines $conn, we'll alias it.
require_once "connect.php";

   if(isset($_POST['staff'])){	
   
    header('Location: ./staff.php');
}

if(isset($_POST['student'])){	
   
    header('Location: ./student.php');
}

if (!isset($pdo)) {
    if (isset($conn) && $conn instanceof PDO) {
        $pdo = $conn;
    } else {
        throw new RuntimeException('No PDO instance found. Ensure connect.php defines $pdo or $conn.');
    }
}

// Load school info
try {
    $stmt = $pdo->query("SELECT * FROM lhpschool LIMIT 1");
    $schoolData = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

    if (!empty($schoolData)) {
        $schoollogo = $schoolData['logo']
            ?? $schoolData['schlogo']
            ?? 'logo.png';
    } else {
        $schoollogo = 'logo.png';
    }

    $schoolname  = $schoolData['schname'] ?? 'Learnable Admin Dashboard ';
    $schoolmotto = $schoolData['motto'] ?? 'Learnable Admin Dashboard ';
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
		<title><?= htmlspecialchars($schoolname) ?> - Learn at Home</title>
    <meta name="description" content="<?= htmlspecialchars($schoolmotto) ?>">
	<!--===============================================================================================-->
	 <link rel="shortcut icon" type="image/x-icon" href="<?php echo 'learn/asset/img/school/' . rawurlencode($schoollogo); ?>">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/banner.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					 
				</span>
				<form method="post" action ="index.php" class="login100-form validate-form p-b-33 p-t-5">

					

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn"  name="staff">
							Staff Log in
						</button> 
					</div>
					
					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" name="student" >
							Learners Log in
						</button> 
					</div>
				</form>
			</div>
			
			
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
    <!--Start of Tawk.to Script-->

</body>
</html>