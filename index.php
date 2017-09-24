<?php
	require_once 'resources.php';

	session_start();
	if (!isset($_SESSION['mSessionInitiated']))
	{
		session_regenerate_id();
		$_SESSION['mSessionInitiated'] = 1;
	}
	//display header
	getHeader($mainpage_label, $mainpage_welcome_message);
	
	echo "
	<p>Modify this as needed</p>
	<h1>This is the main page, list of graduates</h1>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tempor viverra nulla, non sodales justo mattis ut. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer non dapibus turpis. Donec fringilla vitae tellus eu egestas. Mauris a mi venenatis, vulputate massa venenatis, lacinia lectus. Cras ornare tincidunt vestibulum. Maecenas rhoncus, metus in cursus posuere, nisi arcu tristique tortor, non interdum ante velit id risus. Etiam ultrices, sem a gravida luctus, massa ipsum tempor justo, congue suscipit sem nisi lacinia sem. Ut suscipit ligula et eros sagittis aliquam. Vivamus vehicula eros vitae eros pulvinar rutrum. Integer finibus tempus leo vitae pellentesque. Nullam lacinia mauris quis quam feugiat, ac vehicula arcu posuere. Maecenas euismod nulla dolor, non consequat orci condimentum ultrices. Proin faucibus justo et risus varius condimentum. Proin dui ex, congue nec orci quis, egestas faucibus velit.

Cras congue neque urna, id eleifend felis interdum at. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In cursus tortor id risus tristique, quis accumsan mi feugiat. Curabitur vitae hendrerit sem. Aliquam aliquam fermentum dignissim. Donec sodales quam quis felis pretium, non consectetur dui tincidunt. Suspendisse consectetur vehicula ex, sit amet tristique nisi ullamcorper ut. Quisque vehicula risus at facilisis ultricies. Fusce ultrices sapien in ligula laoreet, ac tempor arcu tincidunt. Nulla ut lectus sed purus tempor ultricies eget egestas ante. Praesent nibh eros, lacinia aliquet cursus eu, congue fermentum libero. Duis sit amet molestie ante, eu lobortis lacus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Morbi non est eget est tincidunt dignissim. Phasellus augue dolor, sodales in est id, semper varius lorem.

";
	//display footer
	getFooter();
?>