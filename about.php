<?php
	require_once 'resources.php';

	session_start();

	getHeader("About","About");
	echo "<p>This web page is part of the assignment 4 <br>(Secure) Web based systems<br>Due date: December 02, 2016<br>Team 13<br> Developers: <br>Raphael Akande<br>Richard Samples<br>Mark Smith<br>Alejandro Vargas</p>";
	getFooter();
?>