<?php
	require_once "resources.php";

	$fail = $success = "";
	session_start();
	if (!isset($_SESSION['mSessionInitiated']))
	{
		session_regenerate_id();
		$_SESSION['mSessionInitiated'] = 1;
	}
	getHeader($admin_label, $admin_welcome_message);
	if(!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['role'] != 1)
		$fail .= $admin_access_required;
	else
		$success .= $admin_body_message;
	//display errors
	if($fail != "")
		getErrors($fail);
	//display success msgs
	if($success != "")
		getSuccess($success);
	getFooter();
?>