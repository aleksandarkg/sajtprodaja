<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/sajtprodaja/core/init.php';
	unset($_SESSION['SBuser']);
	header('Location: login.php');
?>