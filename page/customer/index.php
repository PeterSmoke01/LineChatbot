<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/consignment/config/include.php');
require_once(home_path().'controller/fn-customer.php');

date_default_timezone_set("Asia/Bangkok");
global $conn;

// ตรวจสอบการ login
is_login();

// Current User
$current_user = current_user();


?>

<?php 
if ($current_user['user_role'] == "1" || $current_user['user_role'] == "4") {
    
}
else {
    header("Location:".HOME_URI."404.php");
    exit;
} 
?>

<!-- include header start -->
<?php require_once(home_path().'config/header/header-page.php'); ?>
<!-- include header End -->

<div class="pc-container">
    <div class="pcoded-content">
        <!-- breadcrumb start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10"><i class="ti-user"></i> ลูกค้าทั้งหมด</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">ลูกค้า</li>
                            <li class="breadcrumb-item">ลูกค้าทั้งหมด</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-3">
                <a href="<?=home_url()?>page/customer/create.php" class="btn btn-primary"><i data-feather="plus"></i> เพิ่มลูกค้า</a>
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-xl-8">
                                <h5>ลูกค้าทั้งหมด</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-customer" class="table table-hover dataTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รหัสลูกค้า</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>จำนวนคลังสินค้า</th>
                                        <th>จำนวนรายการสินค้า</th>
                                        <th>สถานะ</th>
                                        <th>อัพเดทเมื่อ</th>
                                        <th>อัพเดทโดย</th>
                                        <th>เมนู</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $number_row = 1;
                                foreach (getCustomerAll() as $key => $value) {
                                ?>
                                <tr>
                                    <td><?=$number_row?></td>
                                    <td><a href="<?=home_url()?>page/customer/detail.php?id=<?=$value['id']?>" class="fw-bold"><?=$value['customer_code']?></a></td>
                                    <td><?=$value['customer_name']?></td>
                                    <td class="text-center"><?=count(getWarehouseByCustomerId($value['id']))?></td>
                                    <td class="text-center"><?=count(getCustomerItemByCustomerId($value['id']))?></td>
                                    <td>
                                    <?php 
                                    if ($value['is_active'] == 'Y') {
                                        echo '<span class="badge bg-success fw-normal" style="font-size: 13px;">เปิดใช้งาน</span>';
                                    }
                                    elseif ($value['is_active'] == 'N') {
                                        echo '<span class="badge bg-danger fw-normal" style="font-size: 13px;">ปิดใช้งาน</span>';
                                    }
                                    ?>   
                                    </td>
                                    <td><?=getTimeAgo($value['update_at'])?></td>
                                    <td>
                                    <?php 
                                    foreach (getUsersById($value['update_by']) as $key_user => $value_user) {
                                        echo $value_user['user_fullname'];
                                    }
                                    ?>
                                    </td>
                                    <td class="text-wrap">
                                    <?php
                                        echo '<h5 class="d-grid gap-2 m-1"><a class="btn btn-primary btn-sm text-sm fw-normal" href="'.home_url().'page/customer/detail.php?id='.$value['id'].'">รายละเอียด</a></h5>';
                                    ?>
                                    </td>
                                </tr>
                                <?php
                                $number_row++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Content end -->

    </div>
</div>

<?php require_once(home_path().'config/footer/footer.php'); ?>

<script type="text/javascript">
    
    $('#table-customer').DataTable();

    function updateIsActive(data_id, data_value, update_by, is_active) {
        var active_status = "";
        var db_name = 'customer';

        if(is_active == 'Y') {
            var active_status = "เปิดใช้งาน";
        }
        else if(is_active == 'N') {
            var active_status = "ปิดใช้งาน";
        }

        Swal.fire({
            title: ""+active_status+"",
            text: "คุณแน่ใจที่จะ"+active_status+" "+data_value+" ใช่หรือไม่",
            icon: "info",
            showCancelButton: true,
            cancelButtonText: "ไม่ใช่",
            confirmButtonColor: "#1690ed",
            confirmButtonText: "ใช่, ฉันแน่ใจ",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : '<?=home_url()?>ajax/updateIsActive.php',
                    type : 'POST',
                    data : {
                        data_id: data_id,
                        update_by: update_by,
                        is_active: is_active,
                        db_name: db_name,
                    },
                    success : function(response) {
                        if (response == 'true') {
                            Swal.fire({
                                title: "Success!",
                                text: ""+active_status+" "+data_value+" สำเร็จ",
                                icon: "success",
                                confirmButtonColor: "#1690ed",
                            }).then(function() {
                                window.location = window.location.href.split("#")[0];
                            });
                        }
                        else {
                            Swal.fire({
                                title: "Error!",
                                text: ""+active_status+" "+data_value+" ไม่สำเร็จ",
                                icon: "error",
                                confirmButtonColor: "#1690ed",
                            }).then(function() {
                                window.location = window.location.href.split("#")[0];
                            });
                        }
                    }
                });
            }
        });
    }
</script>