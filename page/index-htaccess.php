<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/hr-linebot/config/include.php');
require_once(home_path().'controller/fn-users.php');

global $conn;
date_default_timezone_set("Asia/Bangkok");

// ตรวจสอบการ login
is_login();

// Current User
$current_user = current_user();
$dateNow = date("Y-m-d");


if (isset($_GET['page']) && isset($_GET['subpage'])) {
    $page = $_GET["page"];
    $page = explode("/", $page);
    $page = $page[0];

    $subpage = $_GET["subpage"];
    $subpage = explode("/", $subpage);
    $subpage = $subpage[0];

    require_once($page."/".$subpage.".php");            
}
else {
    require_once("dashboard.php");
}

?>