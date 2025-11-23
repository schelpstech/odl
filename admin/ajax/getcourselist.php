<?php
require "../../connect.php";  // must define $pdo

if (!empty($_GET['class_id'])) {

	$classId = intval($_GET['class_id']); // sanitize ID

	// Prepare query
	$stmt = $pdo->prepare("SELECT sbjid, sbjname , courseId
                           FROM lhpsubject 
                           WHERE classid = ? 
                           ORDER BY sbjname ASC");
	$stmt->execute([$classId]);

	$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo '<option value="">Select Course From List</option>';

	foreach ($subjects as $sbj) {
		echo '<option value="' . $sbj['sbjid'] . '">' . $sbj['courseId'] ." - ". $sbj['sbjname'] . '</option>';
	}
}
