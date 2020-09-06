<?php
if (!isset($_GET['var'])) {
	$page = new Page("admin", "calendar", "calendar");
	$db = new Bdd();
	$staff = $db->query("SELECT * FROM user WHERE member_of = ?", [$_SESSION['user']['member_of']]);
	$page->loop_assign("A.page", "calendar", $staff);
} elseif ($_GET['var'] == 'add') {
	if (empty($_POST)) {
		$page = new Page("admin", "calendar", "calendar");
	} else {
		$db = new Bdd();
		$errors = [];
		$mailExists = $db->query("SELECT 1 FROM user WHERE email = ?", [$_POST['email']]);
		if ($mailExists)
			$errors[] = ['error' => "This e-mail is already in use"];
		if (!empty($errors)) {
			$page = new Page("admin", "staff", "add");
			$page->loop_assign("A.page", "errors", $errors);
		} else {
			$isAdmin = isset($_POST['isAdmin']) && $_POST['isAdmin'];
			$db->query("INSERT INTO user (firstname, lastname, email, password, phone, member_of, owner_of, permissions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [
				$_POST['firstname'],
				$_POST['lastname'],
				$_POST['email'],
				password_hash($_POST['password'], PASSWORD_DEFAULT),
				$_POST['phone'],
				$_SESSION['user']['owner_of'],
				($isAdmin) ? $_SESSION['user']['owner_of'] : 0,
				($isAdmin) ? 1 : 2
			]);
			header("Location: /calendar.html");
		}
	}
} elseif ($_GET['var'] == 'edit') {
	if (!isset($_GET['svar']) || !is_numeric($_GET['svar']))
		header("Location: /index.php");
	if (empty($_POST)) {
		$db = new Bdd();
		$page = new Page("admin", "calendar", "calendar");
		$user = $db->query("SELECT id, firstname, lastname, email, phone, member_of, owner_of FROM user WHERE id = ?", [$_GET['svar']]);
		if (!$user)
			header("Location: /index.php");
		$user[0]['is_admin'] = ($user[0]['owner_of'] == $user[0]['member_of']) ? ' checked' : '';
		$page->assign("A.page", $user[0]);
	} else {
		$db = new Bdd();
		$user = $db->query("SELECT id, firstname, lastname, email, phone, member_of, owner_of FROM user WHERE id = ?", [$_GET['svar']]);
		if (!$user)
			header("Location: /index.php");
		$errors = [];
		if ($user[0]['email'] != $_POST['email']) {
			$mailExists = $db->query("SELECT 1 FROM user WHERE email = ?", [$_POST['email']]);
			if ($mailExists)
				$errors[] = ['error' => "This e-mail is already in use"];
		}
		if (!empty($errors)) {
			$page = new Page("admin", "calendar", "calendar");
			$page->assign("A.page", $user[0]);
			$page->loop_assign("A.page", "errors", $errors);
		} else {
			$isAdmin = isset($_POST['isAdmin']) && $_POST['isAdmin'];
			$updates = [
				':firstname'	=> $_POST['firstname'],
				':lastname'		=> $_POST['lastname'],
				':phone'		=> $_POST['phone'],
				':owner_of'		=> ($isAdmin) ? $_SESSION['user']['owner_of'] : 0,
				':permissions'	=> ($isAdmin) ? 1 : 2,
				':id'			=> $_GET['svar']
			];
			$passchange = '';
			if ($_POST['password'] != '') {
				$passchange = ', password = :password';
				$updates[':password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
			}
			$sql = "UPDATE user SET firstname = :firstname, lastname = :lastname, phone = :phone, owner_of = :owner_of, permissions = :permissions$passchange WHERE id = :id";
			$db->query($sql, $updates);
			header("Location: /calendar.html");
		}
	}
}