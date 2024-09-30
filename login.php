<?php 
require_once ($_SERVER["DOCUMENT_ROOT"].'/hr-linebot/config/include.php');
global $conn;

if (isset($_POST['userLogin'])) {
    if (empty($_POST['username']) && empty($_POST['password'])) {
        header("Location: ".home_url()."?error=err00");
        exit;
    }
    elseif (empty($_POST['username']) && !empty($_POST['password'])) {
        header("Location: ".home_url()."?error=err06");
        exit;
    }
    elseif (!empty($_POST['username']) && empty($_POST['password'])) {
        header("Location: ".home_url()."?error=err07");
        exit;
    }
    elseif (!empty($_POST['username']) && !empty($_POST['password'])) {
        create_login($_POST['username'], $_POST['password']);

        $current_user = current_user();
        if ($current_user['user_role'] == "1") {
            header("Location: ".home_url()."page/");
        }
        else {
            header("Location: ".home_url()."page/");
        }
    }
}
else {
    is_login();
}

?>


