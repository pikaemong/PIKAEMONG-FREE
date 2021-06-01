<?php
	$conn = mysqli_connect('localhost', 'root', '', 'elysium');
	$sql = "SELECT * FROM vrp_user_moneys WHERE user_id = ".$_SESSION['id'];;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
?>