<?php
if (!$_SESSION['auth'])
	Util::redirect("login.html");
switch($_SESSION['permissions']) {
	case 0:
		$menu = "sadmin";
		$dashboard_title = "Admin Dashboard";
		break;
	case 1:
		$menu = "admin";
		$dashboard_title = "Office Dashboard";
		break;
	default:
		$menu = "member";
		$dashboard_title = "Office Dashboard";
		break;
}
$page = new Page($menu);
$page->assign("A.page", "dashboard_title", $dashboard_title);

if (!isset($_GET['var'])) {
    //Get the Numbers for the TOP DASHBOARD VIEW ICONS  - Tony M. (Black Tech Enterprise,LLC)
    $client_tot=0;
    $claims_tot=0;
    $claims_totsub=0;
    $revenue_totchrg=0;
    
    $db = new Bdd();
    $clientd = $db->query("SELECT count(*) as client_tot FROM clients WHERE business = ?", [$_SESSION['user']['owner_of']]);
    $page->assign("A.page", "client_tot", $clientd[0]['client_tot']);
    
    $claimsd = $db->query("SELECT count(*) as claims_tot FROM claims WHERE business_id = ?", [$_SESSION['user']['owner_of']]);
    $page->assign("A.page", "claims_tot", $claimsd[0]['claims_tot']);
    
    $revenue_D = $db->query("SELECT SUM(total_charge) as revenue_totchrg FROM claims WHERE business_id = ?", [$_SESSION['user']['owner_of']]);
    $page->assign("A.page", "revenue_totchrg", $revenue_D[0]['revenue_totchrg']);
    
    $claims_S = $db->query("SELECT count(*) as claims_totsub FROM claims WHERE business_id = ?", [$_SESSION['user']['owner_of']]);
    $page->assign("A.page", "claims_totsub", $claims_S[0]['claims_totsub']);
    
}
if (isset($business)) {
	$page->assign("1.menu", "logo", $business[0]['logo']);
	
}


?>