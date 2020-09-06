<?php
if (!isset($_GET['var']))
	Util::redirect('dashboard.html');
if ($_SESSION['permissions'] != 0) 
	Util::redirect('/index.html');
if ($_GET['var'] == 'businesses') {
	if (!isset($_GET['svar'])) {
		$db = new Bdd();
		$page = new Page('sadmin', 'admin', 'businesses/list');
		$businesses = $db->query("
			SELECT b.id, b.logo, b.name, u.phone
			FROM business b, user u
			WHERE u.id = b.founder
		");
		$page->loop_assign('A.page', 'businesses', $businesses);
	}
	elseif ($_GET['svar'] == "add") {
		if (empty($_POST))
			$page = new Page('sadmin', 'admin', 'businesses/add');
		else {
			$errors = [];
			if ($_FILES['businessLogo']['error'] !== UPLOAD_ERR_OK)
				$errors[] = ["error" => "Upload failed with error code " . $_FILES['businessLogo']['error']];
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
				$errors[] = ["error" => "You must enter a valid e-mail address"];
			$db = new Bdd();
			$emailExists = $db->query("SELECT * FROM user WHERE email = ?", [$_POST['email']]);
			$businessExists = $db->query("SELECT * FROM business WHERE name = ?", [$_POST['businessName']]);
			if (!empty($emailExists))
				$errors[] = ["error" => "This e-mail address is already in use for another user"];
			if (!empty($businessExists))
				$errors[] = ["error" => "This Business name is already registered"];
			$info = getimagesize($_FILES['businessLogo']['tmp_name']);
			if ($info === false)
				$errors[] = ["error" => "Please select a valid image"];
			$ext = pathinfo(basename($_FILES['businessLogo']['name']), PATHINFO_EXTENSION);
			$filename = "uploads/business_".uniqid()."." . $ext;
			if (!move_uploaded_file($_FILES['businessLogo']['tmp_name'], $filename))
				$errors[] = ["error" => "Couldn't upload file"];
			if (!empty($errors)) {
				$page = new Page('sadmin', 'admin', 'businesses/add');
				$page->assign("A.page", $_POST);
				$page->loop_assign('A.page', 'errors', $errors);
			}
			else {
				$businessId = $db->query("INSERT INTO business (name, logo) VALUES (?, ?)", [
					$_POST['businessName'],
					$filename
				]);
				$ownerId = $db->query("INSERT INTO user (email, password, phone, permissions, member_of, owner_of) VALUES (?, ?, ?, ?, ?, ?)", [
					$_POST['email'],
					password_hash($_POST['password'], PASSWORD_DEFAULT),
					(empty($_POST['phone'])) ? null : $_POST['phone'],
					1,
					$businessId,
					$businessId
				]);
				$db->query("UPDATE business SET founder = ? WHERE id = ?", [$ownerId, $businessId]);
				header("Location: /admin/businesses.html");
			}
		}
	} elseif ($_GET['svar'] == 'delete') {
		if (!isset($_GET['tvar']) || !is_numeric($_GET['tvar']))
			header("Location: /index.php");
		$db = new Bdd();
		$db->query("DELETE FROM business WHERE id = ?", [$_GET['tvar']]);
		$db->query("DELETE FROM user WHERE member_of = ? OR owner_of = ?", [$_GET['tvar'], $_GET['tvar']]);
		header("Location: /admin/businesses.html");
	} elseif ($_GET['svar'] == 'edit') {
		if (!isset($_GET['tvar']) || !is_numeric($_GET['tvar']))
			header("Location: /index.php");
		if (empty($_POST)) {
			$db = new Bdd();
			$business = $db->query("
				SELECT b.*, o.email, o.phone
				FROM business b, user o
				WHERE o.owner_of = b.id AND b.id = ?
			", [$_GET['tvar']]);
			if (empty($business))
				header("Location: /index.php");
			$page = new Page('sadmin', 'admin', 'businesses/edit');
			$page->assign("A.page", $business[0]);
		}
		else {
			$db = new Bdd();
			$business = $db->query("
				SELECT b.*, o.email, o.phone
				FROM business b, user o
				WHERE o.owner_of = b.id AND b.id = ?
			", [$_GET['tvar']]);
			$errors = [];
			if (empty($business))
				header("Location: /index.php");
			$updates = [
				':name'	=> $_POST['businessName'],
				':id'	=> $_GET['tvar']
			];
			if ($_POST['businessName'] !== $business[0]['name']) {
				$businessExists = $db->query("
					SELECT 1 FROM business WHERE name = ?
				", [$_POST['businessName']]);
				if ($businessExists)
					$errors[] = ["error" => "This business name is already taken"];
			} 
			$logochange = '';
			if ($_FILES['newLogo']['error'] === UPLOAD_ERR_OK) {
				$info = getimagesize($_FILES['newLogo']['tmp_name']);
				if ($info === false)
					$errors[] = ["error" => "Please select a valid image"];
				$logochange = ', logo = :logo';
				$ext = pathinfo(basename($_FILES['newLogo']['name']), PATHINFO_EXTENSION);
				$filename = "uploads/business_".uniqid()."." . $ext;
				if (!move_uploaded_file($_FILES['newLogo']['tmp_name'], $filename))
					$errors[] = ["error" => "Couldn't upload file"];
				$updates[':logo'] = $filename;
			}
			if (empty($errors)) {
				$db->query("UPDATE business SET name = :name$logochange WHERE id = :id", $updates);
				unlink($business[0]['logo']);
				header("Location: /admin/businesses.html");
			} else {
				$db = new Bdd();
				$business = $db->query("
					SELECT b.*, o.email, o.phone
					FROM business b, user o
					WHERE o.owner_of = b.id AND b.id = ?
				", [$_GET['tvar']]);
				if (empty($business))
					header("Location: /index.php");
				$page = new Page('sadmin', 'admin', 'businesses/edit');
				$page->assign("A.page", $business[0]);
				$page->loop_assign('A.page', 'errors', $errors);
			}
		}
	}
} else {
	$page = new Page('login', '404');
}