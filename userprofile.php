<?php
	require_once 'resources.php';

	session_start();

	getHeader("User profile","this is the user profile");
	echo "This is the user profile, modify as needed";
	getFooter();
?>