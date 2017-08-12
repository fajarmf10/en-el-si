<?php
	session_start();
	ob_start();
	include "library/config.php";
	mysqli_query($mysqli, "UPDATE peserta SET status='off' WHERE id_tim='$_SESSION[id_tim]'");
	
	session_destroy();
	ob_clean();
	header('location: login.php');
?>
