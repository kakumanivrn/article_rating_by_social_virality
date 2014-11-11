<?php

require "functions.php";
$url = $_GET["url"];
if(!isset($url) || strlen($url) <= 3) {
	$total_array = array(
					"fb_likes" => 0,
					"fb_shares" => 0,
					"fb_comments" => 0,
					"google_plus" => 0,
					"linkedin_shares" => 0,
					"pin_count" => 0,
					"tweet_count" => 0,
					"stumbleupon_views" => 0,
					"total_count" => 0
					);
	header('Content-Type: application/json');
	echo json_encode($total_array);
	exit;
}
if (strpos($url,'http://') === false && strpos($url,'https://') === false) {
	$url = 'http://' . $url;
}

list($fb_likes, $fb_shares, $fb_comments) = get_fb_likes_shares_comments($url);
$google_plus = get_plusones($url);
$linkedin_shares = get_linkedin_shares($url);
$pin_count = get_pinterest_count($url);
$tweet_count = get_twitter_count ($url);
$stumbleupon_views = get_stumbleupon_views($url);

$total_count = $stumbleupon_views + $tweet_count + $pin_count + $linkedin_shares + $google_plus + $fb_likes + $fb_shares + $fb_comments;

$total_array = array(
					"fb_likes" => $fb_likes,
					"fb_shares" => $fb_shares,
					"fb_comments" => $fb_comments,
					"google_plus" => $google_plus,
					"linkedin_shares" => $linkedin_shares,
					"pin_count" => $pin_count,
					"tweet_count" => $tweet_count,
					"stumbleupon_views" => $stumbleupon_views,
					"total_count" => $total_count
					);
header('Content-Type: application/json');
echo json_encode($total_array);
