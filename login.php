<?php //authenticate2.php
	require_once 'credentials.php';
	require_once 'resources.php';

	$fail = $success = "";
	$conn =
		new mysqli($db_hostname, $db_username, $db_password, $db_database);
	if ($conn->connect_error)
		$fail .= getHR_messages($conn, null,'conn_error');

	session_start();
	if (!isset($_SESSION['mSessionInitiated']))
	{
		session_regenerate_id();
		$_SESSION['mSessionInitiated'] = 1;
	}

	//if user wants to log out, log him out
	if(isset($_GET['logout']) && $_GET['logout'])
		destroy_session_and_data();

	//if user is not logged in
	if (!isset($_SESSION['username']))
	{
		if(isset($_POST['loginvar'])) //user is trying to login
		{
			//Check if blanks
			$user = "";
			$pass = "";
			if (isset($_POST['user']))
				$user = mysql_entities_fix_string($conn, $_POST['user']);
			if(isset($_POST['pass']))
				$pass = mysql_entities_fix_string($conn, $_POST['pass']);

			if($user == "")
				$fail .= getHR_messages(null, 'user', 'blank');
			if($pass == "")
				$fail .= getHR_messages(null, 'password', 'blank');

			//Check if username exists
			if($fail == ""){
				//$query = "SELECT * FROM twb_user WHERE user='$user'";
				$query = "SELECT twb_user.*, CONCAT(csdegrees.firstname, ' ', csdegrees.lastname) as name  FROM cs5339team13fa16.twb_user join wb_longpre.csdegrees as csdegrees on csdegrees.id = twb_user.graduate_id WHERE user='$user'";

				$result = $conn->query($query);
				if (!$result)
					$fail .= getHR_messages($conn, null,'db_access_failed');
				elseif ($result->num_rows){//There's one user in db, check if password matches
					$salt1 = "Adrastea1\$aM0on";
					$salt2 = $user;
					$token = hash('ripemd128', "$salt1$pass$salt2");

					$row = $result->fetch_array(MYSQLI_NUM);
					$result->close();
					$salt1 = "Adrastea1\$aM0on";
					$salt2 = $user;
					$token = hash('ripemd128', "$salt1$pass$salt2");
					//Check if passwords match
					if ($token == $row[2])
					{
						$_SESSION['username'] = $user;
						$_SESSION['password'] = $pass;
						$_SESSION['name'] = $row[4];
						$success .= getHR_messages(null, $user, 'login_success');
					}
					else
						$fail .= getHR_messages(null, null, 'login_failed');
				}
				else//User could not be found
					$fail .= getHR_messages(null, null, 'login_failed');
			}
		}else
			$fail .= " ";
	}else{ //User is logged in
		$username = $_SESSION['username'];
		$success .= getHR_messages(null, $username, 'login_success');
	}
	$conn->close();

	//display header
	getHeader($login_label, $login_welcome_message);
	//display success msgs
	if($success != "")
		getSuccess($success);
	//display errors
	if($fail != ""){
		getErrors($fail);
		getBody();
	}
	//display footer
	getFooter();

	function getBody(){
		echo <<<_END
		<form action="login.php" method="POST">
			<label for="user">Username:</label>
			<input type="text" name="user" id="user">
			<br><br>
			<label for="pass">Password:</label>
			<input type="password" name="pass" id="pass">
			<br><br>
			<input type="hidden" id="loginvar" name="loginvar" value="0">
			<input type="submit" onclick="document.getElementById('loginvar').value = 1;">
		</form>
	\n
_END;
	}
?>