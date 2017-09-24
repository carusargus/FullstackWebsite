<?php // registration.php
	require_once 'credentials.php';
	require_once 'resources.php';

	$fail = $success = "";
	$error = false;
	$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	if ($conn->connect_error)
		$fail .= getHR_messages($conn, null,'conn_error');

	$conn_graduates = new mysqli($db_hostname, $db_username, $db_password, $db_database_graduates);
	if ($conn_graduates->connect_error)
		$fail .= getHR_messages($conn_graduates, null,'conn_error');

	session_start();
	if (!isset($_SESSION['mSessionInitiated']))
	{
		session_regenerate_id();
		$_SESSION['mSessionInitiated'] = 1;
	}
	if(isset($_SESSION['username']) || !empty($_SESSION['username'])){
		$fail .= $registration_logout_required;
		$error = true;
	}

	if(isset($_POST['saveuser']) && $fail == "") //user is trying to register
	{
		//Check if blanks
		$user = "";
		$pass = "";
		$graduate_firstname = "";
		$graduate_lastname = "";
		if (isset($_POST['user']))
			$user = mysql_entities_fix_string($conn, $_POST['user']);
		if(isset($_POST['pass']))
			$pass = mysql_entities_fix_string($conn, $_POST['pass']);
		if(isset($_POST['graduate_firstname']))
			$graduate_firstname = mysql_entities_fix_string($conn, $_POST['graduate_firstname']);
		if(isset($_POST['graduate_lastname']))
			$graduate_lastname = mysql_entities_fix_string($conn, $_POST['graduate_lastname']);

		if($user == "")
			$fail .= getHR_messages(null, 'Username', 'blank');
		if($pass == "")
			$fail .= getHR_messages(null, 'Password', 'blank');
		if($graduate_firstname == "")
			$fail .= getHR_messages(null, 'First name', 'blank');
		if($graduate_lastname == "")
			$fail .= getHR_messages(null, 'Last name', 'blank');
		$graduate_id;

		//Retrieve id of graduate from primary database
		if($fail == ""){
			$query = "SELECT id FROM csdegrees WHERE lastname='$graduate_lastname' and firstname='$graduate_firstname';";
			
			$result = $conn_graduates->query($query);
			if (!$result)
				$fail .= getHR_messages($conn_graduates, null,'db_access_failed');
			elseif ($result->num_rows){			
				$result->data_seek(0);
				$row = $result->fetch_array(MYSQLI_NUM);
				$graduate_id = $row[0];
			}else{
				$fail .= getHR_messages($conn_graduates, null, 'graduate_no_exists');
			}
			$result->close();
		}
		//Check if graduate already has a user
		if($fail == ""){
			$query = "SELECT * FROM twb_user WHERE graduate_id='$graduate_id'";

			$result = $conn->query($query);
			if (!$result)
				$fail .= getHR_messages($conn, null,'db_access_failed');
			elseif ($result->num_rows)
				$fail .= getHR_messages($conn, null,'graduate_un_exists');
			$result->close();
		}
		//Check if username exists
		if($fail == ""){
			$query = "SELECT * FROM twb_user WHERE user='$user'";

			$result = $conn->query($query);
			if (!$result)
				$fail .= getHR_messages($conn, null,'db_access_failed');
			elseif ($result->num_rows)
				$fail .= getHR_messages($conn, null,'un_exists');
			$result->close();
		}

		//Insert into table	
		if($fail == ""){
			$stmt = $conn->prepare('INSERT INTO twb_user (user,pass,graduate_id) VALUES(?,?,?)');
			$salt1 = "Adrastea1\$aM0on";
			$salt2 = $user;
			$token = hash('ripemd128', "$salt1$pass$salt2");

			$stmt->bind_param('ssi', $user, $token, $graduate_id);
			$stmt->execute();
			if($stmt->affected_rows > 0)
				$success .= getHR_messages(null, "user", "create_success");
			else
				$fail .= getHR_messages(null, $db_error_user_create, "error");
			$stmt->close();
		}
		$conn->close();
	}else
		$fail .= " ";

	//display header
	getHeader($registration_label, $registration_welcome_message);
	//display errors
	if($fail != "")
		getErrors($fail);
	//display success msgs
	if($success != "")
		getSuccess($success);
	if(!$error){
		echo <<<_END
			<form action="registration.php" method="POST">
				<label for="graduate_firstname">First name:</label>
				<input type="text" name="graduate_firstname" id="graduate_firstname">
				<br><br>
				<label for="graduate_lastname">Last name:</label>
				<input type="text" name="graduate_lastname" id="graduate_lastname">
				<br><br>
				<label for="user">Username:</label>
				<input type="text" name="user" id="user">
				<br><br>
				<label for="pass">Password:</label>
				<input type="password" name="pass" id="pass">
				<br><br>
				<input type="hidden" id="saveuser" name="saveuser" value="0">
				<input type="submit" onclick="document.getElementById('saveuser').value = 1;">
			</form>
\n
_END;
	}
	//display footer
	getFooter();
?>