<?php
	//General messages
	$db_error_user_create = "Error creating user";

	//labels
	$registration_label = "Registration";
	$mainpage_label = "Main page";
	$login_label = "Login";
	$admin_label = "Administrator";
	$user_label = "User";

	//Messages
	$website_welcome_message = "University of Texas at El Paso\n<br>\n Computer Science Department\n<br>\n";
	$login_welcome_message = "This is the log in page";
	$registration_welcome_message = "This is the registration page";
	$mainpage_welcome_message = "List of graduates";
	$admin_welcome_message = "This is administrator page";
	$user_welcome_message = "This is user page";
	$admin_body_message = "This text should be visible only for administrators";
	$user_body_message = "This text should be visible only for logged users";

	$admin_access_required = "You need to be logged in as an administrator to access this page!";
	$user_access_required = "You need to be logged in to access this page!";
	$registration_logout_required = "You are logged in!";

	function getHR_messages($conn, $field, $msg){
		$eof = "<br>";
		switch($msg){
			case 'db_access_failed' :
				return "Database access failed: " . $conn->error . $eof;
				break;

			case 'un_exists' :
				return "The username already exists" . $eof;
				break;

			case 'graduate_un_exists':
				return "The graduate already has a username" . $eof;
				break;

			case 'conn_error':
				return "Connection error" . $conn->error . $eof;
				break;

			case 'blank':
				return "'$field' can not be empty" . $eof;
				break;

			case 'create_success':
				return "The $field has been created" . $eof;
				break;

			case 'error':
				return "$field" . $eof;
				break;

			case 'login_failed':
				return "The user/password combination could not be found";
				break;

			case 'login_success':
				return "You are logged in as $field!";
				break;

			case 'graduate_no_exists':
				return "Your name does not appear on the graduates list";
				break;

			default:
				return "Message not defined" . $eof;
		}
	}
	function getErrors($fail){
		echo <<<_END
		<p style="color:red">
			$fail
		</p>
\n
_END;
	}
	function getSuccess($fail){
		echo <<<_END
		<p style="color:green">$fail</p>
\n
_END;
	}
	function getHeader($title,$message){
		echo <<<_END
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>$title</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script type="text/javascript" src="javascript.js"></script>
	</head>
	<body>
		
\n
_END;
		getWelcome($message);
	}
	function getFooter(){
		echo <<<_END
	</body>
</html>
\n
_END;
	}
	function getNav(){
		echo <<<_END
		<ul class="mNav" id="myNav">
			<li>
				<a href="index.php">Home</a>
			</li>
_END;
		$user = $_SESSION['username'];
		if(!empty($_SESSION['username'])){
			echo <<<_END
			<li>
				<a href="bulletinboard.php">Bulletin board</a>
			</li>
			<li>
				<a href="userprofile.php">My profile</a>
			</li>
			<li style="float:right;">
				<a href="./login.php?logout=1">Log out ($user)</a>
			</li>
_END;
		}else{
			if(basename($_SERVER['PHP_SELF']) != "registration.php")
			echo <<<_END
			<li>
				<a href="./registration.php">Registration</a>
			</li>
_END;
			if(basename($_SERVER['PHP_SELF']) != "login.php")
			echo <<<_END
			<li>
				<a href="./login.php">Log in</a>
			</li>
_END;
		}

		echo <<<_END
			<li>
				<a href="./about.php">About</a>
			</li>
			<li class="icon">
				<a href="javascript:void(0);" onclick="responsiveNav()">&#9776;</a>
			</li>
		</ul>
		
\n
_END;
	}

	function getWelcome($message){
		getNav();
		global $website_welcome_message;
		echo <<<_END
		<p style="color:black;text-align: center;">$website_welcome_message</p>
		<h1 style="color:black;text-align: center;">$message</h1>
\n
_END;
	}

	function mysql_entities_fix_string($connection, $string)
	{
		return htmlentities(mysql_fix_string($connection, $string));
	}

	function mysql_fix_string($connection, $string)
	{
		if (get_magic_quotes_gpc()) $string = stripslashes($string);
		return $connection->real_escape_string($string);
	}

	function destroy_session_and_data()
	{
		$_SESSION = array();
		session_destroy();
	}
?>