# FullstackWebsite
implemented backend in  SQL &amp; PHP: basic website with login set up, registration, user profile

This website contains the following pages:
-A main page named mainpage.php
-a registration page named registration.php
-a sign in page named login.php
-a page for signed in users named user.php
-a page for administrators named admin.php

Access:
If the visitor is not logged in, all pages except all pages except user.php and admin.php should be accessible.
If the visitor is logged in as a regular user, all pages except admin.php should be accessible.
If the visitor is logged in as an administrator, all pages should be accessible. Trying to access a page where access is denied should display an appropriate error message, for example, “you need to be logged in as an administrator to access this page” instead of displaying the regular contents of the page.
