<?php
// Paramètres de connexionn à la base de données
define ("DB_HOST", "localhost");
define ("DB_NAME", "zflex");
define ("DB_USER", "root");
define ("DB_PASS", "root");

// Paramètres par défaut (Nom du site, Page d'accueil, Template choisit, langue, page d'erreur, URL)
define ("SITE_NAME", "Zflex");
define ("SITE_URL", "http://zflex.local");
define ("SITE_INDEX_USER", "dashboard");
define ("SITE_INDEX_GUEST", "landing");
define ("SITE_THEME_USER", "cms");
define ("SITE_THEME_GUEST", "landing");

$THEMES = [
	"landing"	=> [
		"0.head"	=> "landing/header",
		"1.menu"	=> "landing/menu",
		"Z.foot"	=> "landing/footer"
	],
	"sadmin"	=> [
		"0.head"	=> "cms/header",
		"1.menu"	=> "cms/menu_superadmin",
		"Z.foot"	=> "cms/footer"
	],
	"admin"		=> [
		"0.head"	=> "cms/header",
		"1.menu"	=> "cms/menu_admin",
		"Z.foot"	=> "cms/footer"
	],
	"member"	=> [
		"0.head"	=> "cms/header",
		"1.menu"	=> "cms/menu_member",
		"Z.foot"	=> "cms/footer"
	],
	"login"		=> [
		"0.head"	=> "cms/header",
		"Z.foot"	=> "cms/footer"
	]
];
?>
