<?php
class Util {
	public static function sendRecoveryEmail($address) {
		return false;
	}
	public static function redirect($url) {
		header("Location: $url");
		die();
	}
}