<?php 
require_once ($_SERVER["DOCUMENT_ROOT"].'/consignment/config/include.php'); 
require_once ($_SERVER["DOCUMENT_ROOT"].'/consignment/controller/fn-users.php');
global $conn;
date_default_timezone_set("Asia/Bangkok");

// ตรวจสอบการ login
is_login();

// Current User
$current_user = current_user();
$user_id = $current_user['user_id'];

if (isset($_GET['id'])) {
    if ($user_id == json_decode(base64_decode($_GET['id']))) {
        $id = json_decode(base64_decode($_GET['id']));
    }
    else {
        $id = '';
    }
}
else {
    $id = '';
}

?>

<!-- include header start -->
<?php require_once(HOME_PATH.'config/header/header-page.php'); ?>
<!-- include header End -->

<div class="pc-container">
    <div class="pcoded-content pb-4">
        <!-- breadcrumb start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10"><i data-feather="lock"></i> เปลี่ยนรหัสผ่าน</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">บัญชีของฉัน</li>
                            <li class="breadcrumb-item">เปลี่ยนรหัสผ่าน</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-3">
                <form id="change_password_form" class="needs-validation" method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                    <?php 
                    $allrow = count(getUsersById($id));
                    if ($allrow != 0) {
                    foreach (getUsersById($id) as $key => $value) {
                    ?>

                        <input type="hidden" name="user_id" id="user_id" value="<?=$value['id']?>" readonly>
                        <div class="col-xl-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8">
                                            <h5>เปลี่ยนรหัสผ่าน</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label for="repass_username" class="form-label">ชื่อผู้ใช้งาน <span class="mark">*</span></label>
                                                    <input type="text" class="form-control" id="repass_username" name="repass_username" value="<?=$value['user_username']?>" readonly>
                                                    <label id="repass_username-error" class="mb-0" for="repass_username"></label>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label for="repass_username" class="form-label">รหัสผ่านเดิม <span class="mark">*</span></label>
                                                    <input type="password" class="form-control" id="repass_password_old" name="repass_password_old" value="">
                                                    <div class="hide-show-oldpass">
                                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                                    </div>
                                                    <label id="repass_password_old-error" class="mb-0" for="repass_password_old"></label>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                    <label for="repass_password" class="form-label">รหัสผ่านใหม่  <span class="mark">*</span></label>
                                                    <input type="password" class="form-control" id="repass_password" name="repass_password" value="">
                                                    <div class="hide-show-repass">
                                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                                    </div>
                                                    <label id="repass_password-error" class="error mb-0" for="repass_password"></label>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                    <label for="repass_password_confirm" class="form-label">ยืนยันรหัสผ่าน <span class="mark">*</span></label>
                                                    <input type="password" class="form-control" id="repass_password_confirm" name="repass_password_confirm" value="">
                                                    <div class="hide-show-confirmpass">
                                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                                    </div>
                                                    <label id="repass_password_confirm-error" class="mb-0" for="repass_password_confirm"></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12">
                                                    <button type="submit" id="changePassword" name="changePassword" class="btn btn-success float-right mb-4"><i data-feather="lock"></i> เปลี่ยนรหัสผ่าน</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                                            <h6>เงื่อนไขการกำหนดรหัสผ่าน</h6>
                                            <p class="text-muted text-md mb-1">ตัวอย่างเช่น Abc#1234</p>
                                            <p class="text-muted text-md mb-1 mt-1">1. ประกอบด้วย 0-9, a-z, A-Z อย่างน้อยชุดละ 1 ตัว</p>
                                            <p class="text-muted text-md mb-1">2. มีอักขระพิเศษนี้ (! @ # $ & *) อย่างน้อย 1 ตัว</p>
                                            <p class="text-muted text-md mb-1">3. มีจำนวนอย่างน้อย 8 ตัว แต่ไม่เกิน 16 ตัว</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                    } //end foreach 
                    } 
                    else {
                    ?>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8">
                                            <h5>เปลี่ยนรหัสผ่าน</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="text-center">ไม่พบข้อมูล!</h2>
                                </div>
                            </div>
                        </div>
                    <?php 
                    } 
                    ?>
                    </div>
                </form>
            </div>
        </div>
        <!-- Main Content end -->

    </div>
</div>

<?php require_once(HOME_PATH.'/config/footer/footer.php'); ?>

<script type="text/javascript">
    $(function() {
        $.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
        );

        $("#change_password_form").validate({
            ignore: ":hidden",
            validClass: "is-valid",
            errorClass: "is-invalid",
            errorElement: "label",
            rules: {
                repass_password_old: {required: true},
                repass_password: {
                    required: true, 
                    regex: "^(?=.*\\d)(?=.*[a-z])(?=.*[!@#$&*])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$",
                    maxlength: 16,
                },
                repass_password_confirm: {
                    required: true,
                    equalTo: "#repass_password",
                },
            },
            messages: {
                repass_password_old: {required: 'โปรดกำหนดรหัสผ่านเดิม...'},
                repass_password: { 
                    required: 'โปรดกำหนดรหัสผ่านใหม่...', 
                    regex: 'โปรดระบุให้ถูกต้องตามเงื่อนไข...',
                    maxlength: 'โปรดระบุอย่างน้อย 8-16 ตัวอักษร...',
                },
                repass_password_confirm: { 
                    required: 'โปรดยืนยันรหัสผ่าน...',
                    equalTo: 'โปรดระบุรหัสผ่านให้ตรงกัน...', 
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "repass_password_old" ) {
                    error.appendTo('#repass_password_old-error');
                }

                if (element.attr("name") == "repass_password" ) {
                    error.appendTo('#repass_password-error');
                }

                if (element.attr("name") == "repass_password_confirm" ) {
                error.appendTo('#repass_password_confirm-error');
                }
            },   
        });
    });
</script>

<?php 
if(isset($_POST['changePassword'])) {
    changePassword();
}
?>