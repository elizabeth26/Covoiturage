<?php
	function getFrenchDate($date){
		$membres = explode('-', $date);
		$date = $membres[2].'/'.$membres[1].'/'.$membres[0];
		return $date;
	}
	function getEnglishDate($date){
		$membres = explode('/', $date);
		$date = $membres[2].'-'.$membres[1].'-'.$membres[0];
		return $date;
	}

	function addJours($date, $nbJours){
		$membres = explode('/', $date);
		$date = $membres[2].'-'.$membres[1].'-'.(intval($membres[0])+$nbJours);
		return $date;
	}
	function createPasswordCrypte($pwd){
	$password_crypte = sha1(sha1($pwd).SALT);

	return $password_crypte;
}

?>
