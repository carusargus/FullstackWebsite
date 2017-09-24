<?php
	session_start();
	require_once 'resources.php';
	require_once 'connect.php';
	
	getHeader("Messages","Bulletinboard: Post messages here");
	
	
	$connection = new mysqli($hn, $db, $un, $pw);
	if ($connection->connect_error) die($connection->connect_error);
	
	if(isset($_SESSION['username'])){
		
		$user = $_SESSION['username'];
		$loggedin = TRUE;
	}
	else{
		
		$loggedin = FALSE;
	}
	
	## take sent message from user
	if(isset($_POST['text'])){
		
		
		## cleanup and add message to database
		if(strlen($_POST['text'])<=250){
			$text = sanitizeString($_POST['text']);
			
			if($text != ""){
				queryMysql("INSERT INTO messages VALUES('$text','$user',NULL)");
			}
		}
	}
	
	$query = "SELECT * FROM messages ORDER BY time ASC"; 
	$result = queryMysql($query);
	$num = $result->num_rows;
	
	echo "<table align='center'>\n";
	for($i = 0; $i < $num; $i++){
		
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
		$message = $row['message'];
		$author = $row['author'];
		$time = $row['time'];
		
		echo "	<tr>\n".
			  "		<td>$author</td>\n".
			  "		<td style='width:300px'>$message</td>\n".
			  "		<td>$time</td>\n".
			  "	</tr>\n";
	}
	echo "</table>\n".
		  "<br><br>\n";
		  
	if($loggedin){
		echo "<form method = 'post' action = 'bulletinboard.php' align='center'>\n".
			  "	<textarea name='text' style='resize:none' cols = '50' rows='5' maxlength='250'></textarea><br>\n".
			  "	<input type='submit' value='SEND'>\n".
			  "</form>\n";
		
	}
	// add this function to  resources.php
	function sanitizeString($var){
		global $connection;
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return $connection->real_escape_string($var);
	}
   //-----------------------------------------
	// add this function to resources.php
	function queryMysql($query){
		global $connection;
		$result = $connection->query($query);
		if (!$result) die($connection->error);
		return $result;
	}
	//---------------------------------------	
	
	
	getFooter();
?>