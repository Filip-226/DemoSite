<?php
if ($_SESSION['auth'])
	header("Location: dashboard.html");
if (isset($_POST['email']) && isset($_POST['password'])) {
	try {
		$db = new Bdd();
		$user = $db->query("SELECT `id`, `password`, `permissions`, `owner_of`, `member_of` FROM `user` WHERE `email` = ?", [
			$_POST['email']
		]);
		if (empty($user))
			throw new Exception("E-mail or Password incorrect");
		$user = $user[0];
		if (!password_verify($_POST['password'], $user['password']))
			throw new Exception("E-mail or Password incorrect");
		unset($user['password']);
		$_SESSION['user'] = $user;
		$_SESSION['permissions'] = intval($user['permissions']);
		$_SESSION['auth'] = true;
		header("Location: dashboard.html");	
	} catch (Exception $e) {
		$page = new Page("login");
		$page->assign("A.page", "error", $e->getMessage());
	}
} else {
	$page = new Page("login");
}

?>