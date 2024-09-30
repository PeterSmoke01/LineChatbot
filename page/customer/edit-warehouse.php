<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/consignment/config/include.php');
require_once(home_path().'controller/fn-customer.php');
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
    <div class="pcoded-content pb-4">
        <!-- breadcrumb start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10"><i data-feather="edit"></i> แก้ไขคลังสินค้า</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">ลูกค้า</li>
                            <li class="breadcrumb-item">ข้อมูลคลังสินค้า</li>
                            <li class="breadcrumb-item">แก้ไขคลังสินค้า</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-3">
                <form id="edit_customer_form" class="needs-validation" method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <?php foreach (getWarehouseById($id) as $key_warehouse => $value_warehouse) { ?>
                                <a href="<?=home_url()?>page/customer/detail.php?id=<?=$value_warehouse['customer_id']?>" class="btn btn-secondary mobile-d-block mb-1"><i data-feather="arrow-left"></i> ย้อนกลับ</a>
                            <?php } ?>
                            <a href="<?=home_url()?>page/customer/" class="btn btn-primary mobile-d-block mb-1"><i data-feather="list"></i> ลูกค้าทั้งหมด</a>
                        </div>
                        <?php 
                        $allrow = count(getWarehouseById($id));
                        if ($allrow != 0) {
                        foreach (getWarehouseById($id) as $key => $value) {
                        ?>

                        <input type="hidden" name="wh_id" id="wh_id" value="<?=$value['id']?>">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-12">
                                            <h5>แก้ไขคลังสินค้า</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="customer_id" class="form-label fw-bold">ชื่อลูกค้า <span class="mark">*</span></label>
                                                    <select id="customer_id" name="customer_id" class="form-control" readonly>
                                                        <?php 
                                                        foreach (getCustomerList() as $key_customer => $value_customer) {
                                                            if ($value_customer['id'] == $value['customer_id']) {
                                                                echo '<option value="'.$value_customer['id'].'" selected>'.$value_customer['customer_name'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label id="customer_id-error" class="mb-0" for="customer_id"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="wh_code" class="form-label fw-bold">รหัสคลังสินค้า</label>
                                                    <input type="text" class="form-control" id="wh_code" name="wh_code" value="<?=$value['wh_code']?>">
                                                    <label id="wh_code-error" class="mb-0" for="wh_code"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="wh_name" class="form-label fw-bold">ชื่อคลังสินค้า</label>
                                                    <input type="text" class="form-control" id="wh_name" name="wh_name" value="<?=$value['wh_name']?>">
                                                    <label id="wh_name-error" class="mb-0" for="wh_name"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="wh_provinces" class="form-label fw-bold">ที่ตั้ง จังหวัด <span class="mark">*</span></label>
                                                    <select id="wh_provinces" name="wh_provinces" class="form-control select2" data-placeholder="เลือกจังหวัด...">
                                                        <option></option>
                                                        <?php 
                                                        foreach (getProvincesList() as $key_provinces => $value_provinces) {
                                                            if ($value_provinces['id'] == $value['wh_provinces']) {
                                                                echo '<option value="'.$value_provinces['id'].'" selected>'.$value_provinces['name_th'].'</option>';
                                                            }
                                                            else {
                                                                echo '<option value="'.$value_provinces['id'].'">'.$value_provinces['name_th'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label id="wh_provinces-error" class="mb-0" for="wh_provinces"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="wh_district" class="form-label fw-bold">เขต/อำเภอ <span class="mark">*</span></label>
                                                    <select id="wh_district" name="wh_district" class="form-control select2" data-placeholder="เลือกอำเภอ...">
                                                        <option></option>
                                                        <?php 
                                                        foreach (getAmphuresByProvince($value['wh_provinces']) as $key_district => $value_district) {
                                                            if ($value_district['id'] == $value['wh_district']) {
                                                                echo '<option value="'.$value_district['id'].'" selected>'.$value_district['name_th'].'</option>';
                                                            }
                                                            else {
                                                                echo '<option value="'.$value_district['id'].'">'.$value_district['name_th'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label id="wh_district-error" class="mb-0" for="wh_district"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="is_active" class="form-label fw-bold">สถานะการใช้งาน <span class="mark">*</span></label>
                                                    <select id="is_active" name="is_active" class="form-control select2">
                                                        <option value="Y" <?php if($value['is_active'] == 'Y') {echo "selected";} ?>>เปิดใช้งาน</option>
                                                        <option value="N" <?php if($value['is_active'] == 'N') {echo "selected";} ?>>ปิดใช้งาน</option>
                                                    </select>
                                                    <label id="is_active-error" class="mb-0" for="is_active"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="update_by" class="form-label fw-bold">ผู้แก้ไข <span class="mark">*</span></label>
                                                    <select id="update_by" name="update_by" class="form-control mb-1" readonly>
                                                        <option value="<?=$current_user['user_id']?>" selected><?=$current_user['user_fullname']?></option>
                                                    </select>
                                                    <label id="update_by-error" class="mb-0" for="update_by"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="update_at" class="form-label fw-bold">วันที่แก้ไข <span class="mark">*</span></label>
                                                    <input type="text" class="form-control" id="update_at" name="update_at" value="<?=date("Y-m-d H:i:s")?>" readonly>
                                                    <label id="update_at-error" class="mb-0" for="update_at"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <button type="submit" id="editCustomerWarehouse" name="editCustomerWarehouse" class="btn btn-success float-right ml-1"><i data-feather="download"></i> บันทึกการแก้ไข</button>
                            <a href="<?=home_url()?>page/customer/detail.php?id=<?=$value['customer_id']?>" class="btn btn-secondary float-right ml-1"><i data-feather="x"></i> ยกเลิก</a>
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
                                        <div class="col-xl-12">
                                            <h5>แก้ไขข้อมูลลูกค้า</h5>
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

<?php require_once(home_path().'config/footer/footer.php'); ?>

<!-- ที่ตั้งคลังสินค้า -->
<script type="text/javascript">
$(document).ready(function () {
    $('#wh_provinces').on('change', function() {
        $.ajax({
            url : '<?=home_url()?>ajax/getDistrictList.php',
            type : 'post',
            dataType: 'json',
            data : {
                province_id: $('#wh_provinces').val(),
            },
            success : function(data) {
                var district_option = '';
                $.each(data.data, function(index, val) {
                    district_option += '<option value="'+val.id+'">'+val.name_th+'</option>';
                });

                $('#wh_district').html(district_option);
                $('#wh_district').trigger('change');
            }
        });
    });
});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $("#edit_warehouse_form").validate({
        ignore: ":hidden",
        validClass: "is-valid",
        errorClass: "is-invalid",
        errorElement: "label",
        rules: {
            customer_id: {required: true},
            wh_code: {
                required: true,
                maxlength: 20,
            },
            wh_name: {
                required: true,
                maxlength: 100,
            },
            wh_provinces: {required: true},
            wh_district: {required: true},
            is_active: {required: true},
            create_by: {required: true},
            create_at: {required: true},
        },
        messages: {
            customer_id: {required: 'โปรดระบุ...'},
            wh_code: {
                required: 'โปรดระบุ...',
                maxlength: 'ระบุได้ไม่เกิน 20 ตัวอักษร',
            },
            wh_name: {
                required: 'โปรดระบุ...',
                maxlength: 'ระบุได้ไม่เกิน 100 ตัวอักษร',
            },
            wh_provinces: {required: 'โปรดระบุ...'},
            wh_district: {required: 'โปรดระบุ...'},
            is_active: {required: 'โปรดระบุ...'},
            create_by: {required: 'โปรดระบุ...'},
            create_at: {required: 'โปรดระบุ...'},
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "customer_id" ) {
               error.appendTo('#customer_id-error');
            }

            if (element.attr("name") == "wh_code" ) {
               error.appendTo('#wh_code-error');
            }

            if (element.attr("name") == "wh_name" ) {
               error.appendTo('#wh_name-error');
            }

            if (element.attr("name") == "wh_provinces" ) {
               error.appendTo('#wh_provinces-error');
            }

            if (element.attr("name") == "wh_district" ) {
               error.appendTo('#wh_district-error');
            }

            if (element.attr("name") == "is_active" ) {
               error.appendTo('#is_active-error');
            }

            if (element.attr("name") == "create_by" ) {
               error.appendTo('#create_by-error');
            }

            if (element.attr("name") == "create_at" ) {
               error.appendTo('#create_at-error');
            }
        },  
    });
});
</script>

<?php 
if(isset($_POST['editCustomerWarehouse'])) {
    editCustomerWarehouse();
}
?>