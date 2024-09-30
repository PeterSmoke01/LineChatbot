<?php 
require_once ($_SERVER["DOCUMENT_ROOT"].'/consignment/config/include.php'); 
require_once ($_SERVER["DOCUMENT_ROOT"].'/consignment/controller/fn-users.php');
global $conn;
date_default_timezone_set("Asia/Bangkok");

// ตรวจสอบการ login
is_login();

// Current User
$current_user = current_user();
$id = $current_user['user_id'];

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
                            <h5 class="m-b-10"><i data-feather="user"></i> บัญชีของฉัน</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">บัญชีของฉัน</li>
                            <li class="breadcrumb-item">รายละเอียด</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <?php 
            $allrow = count(getUsersById($id));
            if ($allrow != 0) {
                foreach (getUsersById($id) as $key => $value) {
            ?>
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-xl-8">
                                    <h5>รายละเอียด</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">ชื่อ-นามสกุล</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2"><?=$value['user_fullname']?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">อีเมล</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2"><?=$value['user_email']?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">ชื่อผู้ใช้งาน</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2"><?=$value['user_username']?></p>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">รหัสผ่าน</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2">
                                        <?php 
                                        for($i=1; $i<=5; $i++) {
                                            echo '<i class="fas fa-ellipsis-h"></i>';
                                        }
                                        ?>
                                        <span>
                                            <a href="<?=home_url()?>page/account/change-password.php?id=<?=base64_encode(json_encode($value['id']))?>" class="btn btn-warning btn-sm text-sm">เปลี่ยนรหัสผ่าน</a>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">เปลี่ยนรหัสผ่านล่าสุด</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2">
                                    <?php 
                                    if ($value['is_change_pwd'] != '') {
                                        echo getTimeAgo($value['is_change_pwd']);
                                    }
                                    else {
                                        echo 'ยังไม่เคยเปลี่ยนรหัสผ่าน';
                                    }
                                    ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">บทบาทผู้ใช้งาน</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2">
                                    <?php
                                    if (count(getRoleById($value['role_id'])) != 0) {
                                        foreach (getRoleById($value['role_id']) as $key_role => $value_role) {
                                            echo $value_role['role_name'];
                                        } 
                                    }
                                    else {
                                        echo "-";
                                    }
                                    ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">สถานะบัญชีผู้ใช้งาน</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2">
                                    <?php 
                                    if ($value['is_active'] == 'Y') {
                                        echo '<span class="badge bg-success fw-normal text-md" style="font-size: 14px;">ใช้งานได้ปกติ</span>';
                                    }
                                    elseif ($value['is_active'] == 'N') {
                                        echo '<span class="badge bg-danger fw-normal text-md" style="font-size: 14px;">ปิดการใช้งาน</span>';
                                    }
                                    ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">สถานะการเข้าใช้งาน</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2">
                                    <?php 
                                    if ($value['is_login'] == 'Y') {
                                        echo '<span class="badge bg-success fw-normal text-md" style="font-size: 14px;">ออนไลน์</span>';
                                    }
                                    elseif ($value['is_login'] == 'N') {
                                        echo '<span class="badge bg-danger fw-normal text-md" style="font-size: 14px;">ออฟไลน์</span>';
                                    }
                                    ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">เข้าใช้งานล่าสุดเมื่อ</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2">
                                    <?php
                                    if (count(getUserLogLastByUserId($value['id'])) != 0) { 
                                        foreach (getUserLogLastByUserId($value['id']) as $key_log_login => $value_log_login) {
                                            echo getTimeAgo($value_log_login['log_at']);
                                        }
                                    }
                                    else {
                                        echo '<span class="text-danger">ยังไม่เคยเข้าใช้งาน</span>';
                                    }
                                    ?>  
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-xl-8">
                                    <h5>User Log.</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table id="table-user-log" class="table table-hover dataTable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Username</th>
                                                    <th>Log Date</th>
                                                    <th>Log Event</th>
                                                    <th>Log Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $number_row = 1;
                                            if (count(getUserLogByUserId($id)) > 0) {
                                                foreach (getUserLogByUserId($id) as $key_log_login => $value_log_login) {
                                            ?>
                                                    <tr>
                                                        <td><?=$number_row?></td>
                                                        <td>
                                                        <?php 
                                                        foreach (getUsersById($value_log_login['log_by']) as $key_user => $value_user) {
                                                            echo $value_user['user_username'];
                                                        }
                                                        ?>
                                                        </td>
                                                        <td><?=date_format(date_create($value_log_login['log_at']), 'd/m/Y H:i')?></td>
                                                        <td><?=$value_log_login['log_type']?></td>
                                                        <td><?=$value_log_login['log_msg']?></td>
                                                    </tr>
                                            <?php
                                                    $number_row++;
                                                }
                                            }
                                            else {
                                            ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-danger">ยังไม่มีประวัติการเข้าใช้งานระบบ</td>
                                                </tr>
                                            <?php 
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                }//end foreach 
                } 
                else {
                ?>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-xl-8">
                                    <h5>ข้อมูลผู้ใช้งาน</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="text-center">ไม่พบข้อมูล!</h2>
                        </div>
                    </div>
                </div>
                <?php 
                } //end if else 
                ?>
        </div>
        <!-- Main Content end -->

    </div>
</div>

<?php require_once(HOME_PATH.'/config/footer/footer.php'); ?>

<script type="text/javascript">
$(document).ready(function () {
    $('#table-user-log').DataTable();
});
</script>

<script type="text/javascript">

    $(function() {

        // configure your validation
        $("#change_password_form").validate({
            ignore: ":hidden",
            validClass: "is-valid",
            errorClass: "is-invalid",
            errorElement: "label",
            rules: {
                reset_password: {
                    required: true, 
                    regex: "^(?=.*\\d)(?=.*[a-z])(?=.*[!@#$&*])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$",
                    maxlength: 16,
                },
                reset_password_confirm: {
                    required: true,
                    equalTo: "#reset_password",
                },
            },
            messages: {
                reset_password: { 
                    required: 'โปรดกำหนดรหัสผ่านใหม่...', 
                    regex: 'โปรดระบุให้ถูกต้องตามรูปแบบ...',
                    maxlength: 'โปรดระบุอย่างน้อย 8-16 ตัวอักษร...',
                },
                reset_password_confirm: { 
                    required: 'โปรดยืนยันรหัสผ่าน...',
                    equalTo: 'โปรดระบุรหัสผ่านให้ตรงกัน...', 
                },
            }, 
        });

    });
</script>

<?php 
if(isset($_POST['changePasswordByUser'])) {
    changePasswordByUser();
}
?>