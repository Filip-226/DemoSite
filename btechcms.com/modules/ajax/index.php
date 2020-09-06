<?php
$api_return = [];
try {
switch($_GET['var']) {
		case 'getClientData':
			$db = new Bdd();
			$client = $db->query("SELECT clients.id, clients.firstname, clients.lastname, clients.address, clients.city, clients.state, clients.country, clients.zip, clients.insuranceplan, clients.email, clients.phone, clients.joindate, clients.insured_id, clients.business, clients.patient_number, business.id AS business_id, business.name AS business_name, business.logo, business.founder, business.business_symbol, business.business_address, business.business_city, business.business_state, business.business_zip FROM clients LEFT JOIN business ON business.id = clients.business WHERE clients.id = ? AND clients.business = ?", [
				$_POST['client'],
				$_SESSION['user']['owner_of']
			]);
			if (empty($client))
				throw new Exception("You have no client with ID {$_POST['client']}");
			$api_return = [
				'success'	=> true,
				'data'		=> $client[0]
			];
			break;
		case 'getDataTest':
			$api_return = [
				'success'	=> true,
				'message'		=> "Saved"
			];
			break;
		default:
			header("HTTP/1.0 404 Not Found");
			throw new Exception("Unknown route {$_GET['var']}");
			break;
	}
} catch (Exception $e) {
	$api_return = [
		'success'	=> false,
		'error'		=> $e->getMessage()
	];
}
die(json_encode($api_return));