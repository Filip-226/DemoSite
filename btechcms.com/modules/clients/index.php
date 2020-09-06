<?php
if (!isset($_GET['var'])) {
	$page = new Page('admin', 'clients', 'list');
	$db = new Bdd();
	$clients = $db->query("SELECT id, CONCAT_WS(' ', firstname, lastname) name, joindate, phone, insuranceplan, insured_id FROM clients WHERE business = ?", [$_SESSION['user']['owner_of']]);
	$page->loop_assign("A.page", "clients", $clients);
} else {
	if ($_GET['var'] == 'add') {
		if (empty($_POST)) {
			$page = new Page('admin', 'clients', 'add');
		} else {
			$db = new Bdd();
			$errors = [];
			$no_exists = $db->query("SELECT 1 FROM clients WHERE id = ? AND business = ?", [$_POST['id'], $_SESSION['user']['owner_of']]);
			$email_exists = $db->query("SELECT 1 FROM clients WHERE email = ?", [$_POST['email']]);
			if (!empty($no_exists))
				$errors[] = ['error' => "This client number is taken"];
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
				$errors[] = ['error' => "Please enter a valid e-mail address"];
			if (!empty($email_exists))
				$errors[] = ['error' => "This e-mail address is already registered to another client"];
			if (!empty($errors)) {
				$page = new Page('admin', 'clients', 'add');
				$insurance = $_POST['insurance_type'];
				$key = $insurance . '_selected';
				$_POST[$key] = ' selected';
				$page->assign("A.page", $_POST);
				$page->loop_assign('A.page', 'errors', $errors);
			} else {
				$in = $db->query("INSERT INTO clients (id, insured_id, firstname, lastname, address, city, state, country, zip, insuranceplan, email, phone, joindate, business) VALUES (:id, :insured_id, :firstname, :lastname, :address, :city, :state, :country, :zip, :insuranceplan, :email, :phone, :joindate, :business)",
				[
					':id'				=> $_POST['id'],
					':insured_id'		=> $_POST['insured_id'],
					':firstname'		=> $_POST['first_name'],
					':lastname'			=> $_POST['last_name'],
					':address'			=> $_POST['address'],
					':city'				=> $_POST['city'],
					':state'			=> $_POST['state'],
					':country'			=> $_POST['country'],
					':zip'				=> $_POST['zip'],
					':insuranceplan'	=> $_POST['insuranceplan'],
					':email'			=> $_POST['email'],
					':phone'			=> $_POST['phone_no'],
					':joindate'			=> $_POST['date'],
					':business'			=> $_SESSION['user']['owner_of']
				]);
				header("Location: /clients.html");
			}
		}
	} elseif ($_GET['var'] == 'edit') {
		if (!isset($_GET['svar']) || !is_numeric($_GET['svar'])) {
			header("Location: /index.php");
		}
		$db = new Bdd();
		$client = $db->query("SELECT * FROM clients WHERE id = ? AND business = ?", [$_GET['svar'], $_SESSION['user']['owner_of']]);
		if (empty($client)) {
			header("Location: /index.php");
		}
		$insurance = $client[0]['insuranceplan'];
		$key = $insurance . '_selected';
		$client[0][$key] = ' selected';
		if (empty($_POST)) {
			$page = new Page('admin', 'clients', 'edit');
			$page->assign("A.page", $client[0]);
		} else {
			$errors = [];
			if (!empty($errors)) {
				$page = new Page('admin', 'clients', 'edit');
				$page->assign("A.page", $client[0]);
				$page->loop_assign("A.page", "errors", $errors);
			}
			else {
				$db->query("UPDATE clients SET joindate = :joindate, firstname = :firstname, lastname = :lastname, address = :address, city = :city, state = :state, country = :country, zip = :zip, phone = :phone, email = :email, insuranceplan = :insuranceplan WHERE id = :id AND business = :business", [
					':joindate'			=> $_POST['joindate'],
					':firstname'		=> $_POST['firstname'],
					':lastname'			=> $_POST['lastname'],
					':address'			=> $_POST['address'],
					':city'				=> $_POST['city'],
					':state'			=> $_POST['state'],
					':country'			=> $_POST['country'],
					':zip'				=> $_POST['zip'],
					':phone'			=> $_POST['phone'],
					':email'			=> $_POST['email'],
					':insuranceplan'	=> $_POST['insuranceplan'],
					':id'				=> $_GET['svar'],
					':business'			=> $_SESSION['user']['owner_of']
				]);
				header("Location: /clients.html");
			}
		}

	} elseif ($_GET['var'] == 'delete') {
		if (!isset($_GET['svar']) || !is_numeric($_GET['svar'])) {
			header("Location: /index.php");
		}
		$db = new Bdd();
		$client = $db->query("SELECT * FROM clients WHERE id = ? AND business = ?", [$_GET['svar'], $_SESSION['user']['owner_of']]);
		if (empty($client)) {
			header("Location: /index.php");
		}
		$db->query("DELETE FROM clients WHERE id = ? AND business = ?", [$_GET['svar'], $_SESSION['user']['owner_of']]);
		header("Location: /clients.html");
	}
}
