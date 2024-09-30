<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/hr-linebot/config/include.php');
require_once(home_path().'controller/fn-users.php');
global $conn;
date_default_timezone_set("Asia/Bangkok");

// ตรวจสอบการ login
is_login();

// Current User
$current_user = current_user();

if (isset($_GET['id'])) {
    $id = $_GET['id']; 
}
else {
    $id = '';
}

$allrow = count(getUsersById($id));

?>

<!-- include header start -->
<?php require_once(home_path().'config/header/header-page.php'); ?>
<!-- include header End -->

<div class="pc-container">
    <div class="pcoded-content pb-4">
        <!-- breadcrumb start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10"><i data-feather="info"></i>รายละเอียด</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">หัวเรื่องทั้งหมด</li>
                            <li class="breadcrumb-item">หัวเรื่อง</li>
                            <li class="breadcrumb-item">รายละเอียดหัวเรื่อง</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-3">
                <a href="<?=home_url()?>page/users/" class="btn btn-primary"><i data-feather="list"></i> หัวเรื่องทั้งหมด</a>
                <a href="<?=home_url()?>page/users/create.php" class="btn btn-success"><i data-feather="plus"></i> เพิ่มหัวเรื่อง</a>
                <?php if ($allrow != 0) { ?>
                    <a href="<?=home_url()?>page/users/edit.php?id=<?=$id?>" class="btn btn-warning"><i data-feather="edit"></i> แก้ไขหัวเรื่อง</a>
                <?php } ?>
            </div>
            <?php 
            if ($allrow != 0) {
                foreach (getUsersById($id) as $key => $value) {
            ?>
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-xl-8">
                                    <h5>รายละเอียดหัวเรื่อง</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">หัวเรื่อง</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2"><?=$value['user_fullname']?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">หัวเรื่องย่อย</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2"><?=$value['user_email']?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">รายละเอียด</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2"><?=$value['user_username']?></p>
                                </div>
                            </div>
                            <h5 class="mt-4 text-decoration-underline">ข้อมูลผู้บันทึก/แก้ไข</h5>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">ผู้บันทึก</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2">
                                    <?php 
                                    foreach (getUsersById($value['create_by']) as $key_user => $value_user) {
                                        echo $value_user['user_fullname'];
                                    }
                                    ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">วันที่บันทึก</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2"><?=date_format(date_create($value['create_at']), 'd-m-Y H:i:s')?> (<?=getTimeAgo($value['create_at'])?>)</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">ผู้แก้ไข</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2">
                                    <?php 
                                    foreach (getUsersById($value['update_by']) as $key_user => $value_user) {
                                        echo $value_user['user_fullname'];
                                    }
                                    ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                                    <p class="fw-bold mb-2">วันที่แก้ไข</p>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                                    <p class="fw-normal mb-2"><?=date_format(date_create($value['update_at']), 'd-m-Y H:i:s')?> (<?=getTimeAgo($value['update_at'])?>)</p>
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
                                    <h5>รายละเอียดผู้ใช้งาน</h5>
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

<?php require_once(home_path().'config/footer/footer.php'); ?>

<script type="text/javascript">
$(document).ready(function () {
    $('#table-user-log').DataTable();
});
</script>