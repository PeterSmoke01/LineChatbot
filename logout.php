<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/hr-linebot/config/include.php');
global $conn;
date_default_timezone_set("Asia/Bangkok");

// Call function
$user_id = $_GET['uid'];
logout($user_id);

?>