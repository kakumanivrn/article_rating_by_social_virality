<?php
function get_plusones($url) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	$curl_results = curl_exec ($curl);
	curl_close ($curl);
	$json = json_decode($curl_results, true);
	return intval( $json[0]['result']['metadata']['globalCounts']['count'] );
}

function get_fb_likes_shares_comments($url) {
	$url = "https://api.facebook.com/method/links.getStats?format=json&urls=".$url;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_results = curl_exec ($curl);
	curl_close ($curl);
	$json = json_decode($curl_results, true);
	return array(intval($json[0]["like_count"]), intval($json[0]["share_count"]), intval($json[0]["comment_count"]));
}

function get_linkedin_shares ($url) {
	$url = "https://www.linkedin.com/countserv/count/share?callback=tuttu&url=".$url;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_results = curl_exec ($curl);
	curl_close ($curl);
	$curl_results = str_replace("tuttu(", "", $curl_results);
	$curl_results = str_replace(");", "", $curl_results);
	$json = json_decode($curl_results, true);
	return intval($json["count"]);
}

function get_pinterest_count($url) {
	$url = "http://widgets.pinterest.com/v1/urls/count.json?source=6&callback=tuttu&url=".$url;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_results = curl_exec ($curl);
	curl_close ($curl);
	$curl_results = str_replace("tuttu(", "", $curl_results);
	$curl_results = str_replace(")", "", $curl_results);
	//print_r($curl_results);
	$json = json_decode($curl_results, true);
	return intval($json["count"]);
}

function get_twitter_count ($url) {
	$url = "http://urls.api.twitter.com/1/urls/count.json?callback=tuttu&url=".$url;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_results = curl_exec ($curl);
	curl_close ($curl);
	$curl_results = str_replace("tuttu(", "", $curl_results);
	$curl_results = str_replace(");", "", $curl_results);
	$json = json_decode($curl_results, true);
	return intval($json["count"]);
}

function get_stumbleupon_views ($url) {
	$url = "http://www.stumbleupon.com/services/1.01/badge.getinfo?url=".$url;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_results = curl_exec ($curl);
	curl_close ($curl);
	$json = json_decode($curl_results, true);
	if(isset($json["result"]["views"])) {
		return intval($json["result"]["views"]);
	}
	return 0;
}
