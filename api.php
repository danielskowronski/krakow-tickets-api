<?php
require("config.php");

if ($mode=="kk_mobile"){
	$payload = json_encode($kk_mobile_auth);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://bilety.kkm.krakow.pl/api/v1/auth/login");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$token = json_decode(curl_exec($ch))->authToken;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://bilety.kkm.krakow.pl/api/v1/tickets/list");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'AuthToken:'.$token,
		'X-Device-Id:dupa_xD',
		'Content-Type:application/json'
	));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tix = json_decode(curl_exec($ch))->tickets;
	if(count($tix)>0){
		$expiration=date_create($tix[0]->endDate);
		$now=date_create();
		$interval = date_diff($expiration, $now); 
		echo $interval->format('%d');
		die();
	}
	else {
		die("-1");
	}
}
else {
	die("not implemented yet");
}