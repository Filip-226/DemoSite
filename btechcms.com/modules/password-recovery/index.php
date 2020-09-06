<?php
$page = new Page("login");
if (isset($_POST['email'])) {
	if (Util::sendRecoveryEmail($_POST['email']))
		$page->assign("A.page", "message", "An e-mail has been sent with a link that will allow you to reset your password");
	else
		$page->assign("A.page", "message", "An error has occured while trying to send you the e-mail");
} else 
	$page->assign("A.page", "message", "Enter your e-mail address below")
?>