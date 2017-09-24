<?php
	require_once "resources.php";

	$fail = $success = "";
	session_start();
	if (!isset($_SESSION['mSessionInitiated']))
	{
		session_regenerate_id();
		$_SESSION['mSessionInitiated'] = 1;
	}
	getHeader($user_label, $user_welcome_message);
	if(!isset($_SESSION['username']) || empty($_SESSION['username']))
		$fail .= $user_access_required;
	else
		$success .= $user_body_message;
	//display errors
	if($fail != "")
		getErrors($fail);
	//display success msgs
	if($success != "")
		getSuccess($success);
	getFooter();
?>