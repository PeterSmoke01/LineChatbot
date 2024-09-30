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
                            <h5 class="m-b-10"><i data-feather="plus"></i> เพิ่มคลังสินค้า</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">ลูกค้า</li>
                            <li class="breadcrumb-item">ข้อมูลคลังสินค้า</li>
                            <li class="breadcrumb-item">เพิ่มคลังสินค้า</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-3">
                <form id="create_warehouse_form" class="needs-validation" method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <a href="<?=home_url()?>page/customer/detail.php?id=<?=$id?>" class="btn btn-secondary mobile-d-block mb-1"><i data-feather="arrow-left"></i> ย้อนกลับ</a>
                            <a href="<?=home_url()?>page/customer/" class="btn btn-primary"><i data-feather="list"></i> ลูกค้าทั้งหมด</a>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8">
                                            <h5>เพิ่มคลังสินค้า</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="customer_id" class="form-label fw-bold">ชื่อลูกค้า <span class="mark">*</span></label>
                                                    <select id="customer_id" name="customer_id" class="form-control select2" data-placeholder="เลือกชื่อลูกค้า...">
                                                        <option></option>
                                                        <?php 
                                                        foreach (getCustomerById($id) as $key_customer => $value_customer) {
                                                            echo '<option value="'.$value_customer['id'].'" selected>'.$value_customer['customer_name'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <label id="customer_id-error" class="mb-0" for="customer_id"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="wh_code" class="form-label fw-bold">รหัสคลังสินค้า</label>
                                                    <input type="text" class="form-control" id="wh_code" name="wh_code" value="">
                                                    <label id="wh_code-error" class="mb-0" for="wh_code"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="wh_name" class="form-label fw-bold">ชื่อคลังสินค้า</label>
                                                    <input type="text" class="form-control" id="wh_name" name="wh_name" value="">
                                                    <label id="wh_name-error" class="mb-0" for="wh_name"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="wh_provinces" class="form-label fw-bold">ที่ตั้ง จังหวัด <span class="mark">*</span></label>
                                                    <select id="wh_provinces" name="wh_provinces" class="form-control select2" data-placeholder="เลือกจังหวัด...">
                                                        <option></option>
                                                        <?php 
                                                        foreach (getProvincesList() as $key_provinces => $value_provinces) {
                                                            echo '<option value="'.$value_provinces['id'].'">'.$value_provinces['name_th'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <label id="wh_provinces-error" class="mb-0" for="wh_provinces"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="wh_district" class="form-label fw-bold">เขต/อำเภอ <span class="mark">*</span></label>
                                                    <select id="wh_district" name="wh_district" class="form-control select2" data-placeholder="เลือกอำเภอ...">
                                                        <option></option>
                                                    </select>
                                                    <label id="wh_district-error" class="mb-0" for="wh_district"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="is_active" class="form-label fw-bold">สถานะการใช้งาน <span class="mark">*</span></label>
                                                    <select id="is_active" name="is_active" class="form-control select2">
                                                        <option value="Y" selected>เปิดใช้งาน</option>
                                                        <option value="N">ปิดใช้งาน</option>
                                                    </select>
                                                    <label id="is_active-error" class="mb-0" for="is_active"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="create_by" class="form-label fw-bold">ผู้บันทึก <span class="mark">*</span></label>
                                                    <select id="create_by" name="create_by" class="form-control mb-1" readonly>
                                                        <option value="<?=$current_user['user_id']?>" selected><?=$current_user['user_fullname']?></option>
                                                    </select>
                                                    <label id="create_by-error" class="mb-0" for="create_by"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="create_at" class="form-label fw-bold">วันที่บันทึก <span class="mark">*</span></label>
                                                    <input type="text" class="form-control" id="create_at" name="create_at" value="<?=date("Y-m-d H:i:s")?>" readonly>
                                                    <label id="create_at-error" class="mb-0" for="create_at"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <button type="submit" id="addCustomerWarehouse" name="addCustomerWarehouse" class="btn btn-success float-right ml-1"><i data-feather="download"></i> บันทึกข้อมูล</button>
                            <a href="<?=home_url()?>page/customer/detail.php?id=<?=$id?>" class="btn btn-secondary float-right ml-1"><i data-feather="x"></i> ยกเลิก</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Main Content end -->

    </div>
</div>

<?php require_once(home_path().'/config/footer/footer.php'); ?>

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
    $("#create_warehouse_form").validate({
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
if(isset($_POST['addCustomerWarehouse'])) {
    addCustomerWarehouse();
}
?>