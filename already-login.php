<?php
require_once ($_SERVER["DOCUMENT_ROOT"].'/consignment/config/include.php');
global $conn;

// Current Date Time
date_default_timezone_set("Asia/Bangkok");
$currDate = date("Y-m-d");
$currTime = date("H:i:s");
$currDateTime = date("Y-m-d H:i:s");

if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
        $uid = json_decode(base64_decode($_GET['uid']));
    }
    else {
        $uid = 0;
    }
}
else {
    $uid = 0;
}

?>

<?php require_once(home_path().'config/header/header.php'); ?>

<div class="auth-wrapper aut-bg-img">
    <div class="auth-content" style="width: 40%;">
        <div class="card">
            <div class="row align-items-center text-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <img src="assets/images/logo.svg" alt="" class="img-fluid mb-4">
                        <div class="row mt-4">
                            <div class="col-lg-12 col-md-12">
                                <h1 class="text-center text-warning"><i class="fas fa-lock fa-2x"></i></h1>
                                <h3 class="text-center mt-3 font-weight-bold" style="color: #001f33;">ท่านล็อกอินเข้าใช้งานระบบอยู่แล้ว</h3>
                                <h5 class="text-center" style="color: #001f33;">ต้องการอยู่ในระบบต่อไปหรือไม่</h5>
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center">
                                <form class="form" method="POST" action="<?=home_url()?>already-create-login.php" id="form-login">
                                    <?php 
                                    $username = '';
                                    $password = '';

                                    $sql = "SELECT * from user where id = '$uid' and is_login = 'Y'";
                                    $query = mysqli_query($conn, $sql);
                                    while ($arrUser = mysqli_fetch_assoc($query)){
                                        $username = $arrUser['user_username'];
                                        $password = $arrUser['user_password'];
                                    }
                                    ?>
                                    <input type="hidden" id="user_id" name="user_id" value="<?=$uid?>">
                                    <input type="hidden" id="username" name="username" value="<?=$username?>">
                                    <input type="hidden" id="password" name="password" value="<?=$password?>">
                                    <button name="rememberMe" id="rememberMe" type="submit" class="btn btn-primary">อยู่ในระบบต่อ</button>
                                </form>
                                <a href="<?=home_url()?>logout.php?uid=<?=$uid?>" class="btn btn-dark ml-2">ออกจากระบบ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(home_path().'/config/footer/footer.php'); ?>