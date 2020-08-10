<?php
/*
 * Plugin Name: CryptoCalc
 * Version: 1.0
 * Author: Dmitry Simtsys
 * License: GPLv2
 */



if($_POST['counts']){
calcul($_POST['to']);
}

function get_last_ten(){

	global $wpdb;
	
	$lasttens = $wpdb->get_results("SELECT * FROM `wp_exchange` ORDER BY id DESC LIMIT 10");
	return $lasttens;
}
function calcul($value){
	require_once('../../../wp-load.php');
	global $wpdb;
	
	$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
	$parameters = [
	  'start' => '1',
	  'limit' => '5',
	  'convert' => $value
	];

	$headers = [
	  'Accepts: application/json',
	  'X-CMC_PRO_API_KEY: 59b8b462-7ac5-4139-a843-a17828bed25e'
	];
	$qs = http_build_query($parameters); // query string encode the parameters
	$request = "{$url}?{$qs}"; // create the request URL

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $request,
	  CURLOPT_HTTPHEADER => $headers,
	  CURLOPT_RETURNTRANSFER => 1
	));

	$response = curl_exec($curl);

	curl_close($curl); // Close request
	$result = json_decode($response);

	foreach($result->data as $item){
		foreach($item->quote as $value){
			if($item->symbol == $_POST['from']){
				$summ = $_POST['counts'] * $value->price;
				$wpdb->prepare("insert into `wp_exchange` (`froms`,`tos`,`counts`,`result`) values ('%s','%s','%s','%s') ",$_POST['from'],$_POST['to'],$_POST['counts'],$summ);
				
//$wpdb->prepare('wp_exchange',['froms' => $_POST['from'], 'tos' =>$_POST['to'],'counts' => $_POST['counts'], 'result' =>$summ ]);
				echo $summ;
			}
		}
	}
}