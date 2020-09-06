<?php
session_start();
date_default_timezone_set('Europe/London');
require_once trim(file_get_contents(".zflexrc"));;
require_once "./incl/class.page.php";
require_once "./incl/class.bdd.php";
require_once "./incl/class.util.php";
$_SESSION['auth'] = (isset($_SESSION['auth'])) ? $_SESSION['auth'] : false;
if (!isset($_GET['mod']) || $_GET['mod'] == "index")
{
	if ($_SESSION['auth'])
	{
		include ("./modules/".SITE_INDEX_USER."/index.php");
	} else
	{
		include ("./modules/".SITE_INDEX_GUEST."/index.php");
	}
}
else
{
	// $_GET['mod'] correspond au nom du sous dossier du module qu'on veut
	// La page index du sous-dossier contiendra les includes dynamiques correspondant aux différentes pages du module
	$file = "./modules/".$_GET['mod']."/index.php";
	if (!file_exists($file))
	{
		// La page d'erreur par défaut définie dans config.php
		include ("./modules/404/index.php");
	}
	else
	{
		include ($file);
	}
}

if (isset($page))
{
	if (!isset($_GET['mod'])) {
		$url = "index.php";
	} else {
		$url = $_GET['mod'];
		$url .= (isset($_GET['var'])) ? "/".$_GET['var'] : "";
		$url .= (isset($_GET['svar'])) ? "/".$_GET['svar'] : "";
		$url .= (isset($_GET['tvar'])) ? "/".$_GET['tvar'] : "";
		$url .= ".html";
	}
	$title = SITE_NAME;
	$title .= (isset($module['name'])) ? ' - '.$module['name'] : '';
	$title .= (isset($module['page'])) ? ' : '.$module['page'] : '';
	$page->assign("0.head", array(
		"title" => $title,
		"site_url" => SITE_URL
	));
	if (isset($head_addon))
	{
		$page->assign("head", "head_addon", $head_addon);
	}
	if (isset($_SESSION['permissions'])) {
		switch($_SESSION['permissions']) {
			case 0:
				break;
			case 1:
				$db = new Bdd();
				$businessData = $db->query("SELECT * FROM business WHERE id = ?", [
					$_SESSION['user']['owner_of']
				]);
				$clientList = $db->query("SELECT * FROM clients WHERE business = ?", [
					$_SESSION['user']['owner_of']
				]);
				break;
			default:
				$db = new Bdd();
				$businessData = $db->query("SELECT * FROM business WHERE id = ?", [
					$_SESSION['user']['member_of']
				]);
				break;
		}
	}
	if (isset($businessData)) {
		$page->assign("1.menu", "logo", $businessData[0]['logo']);
		$page->assign("1.menu", "name", $businessData[0]['name']);
	}
	if (isset($clientList)) {
		$page->loop_assign("1.menu", "clientlist", $clientList);
	}
	echo $page->output(0);
}	

?>
