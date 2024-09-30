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
                            <h5 class="m-b-10"><i data-feather="edit"></i> แก้ไขข้อมูลลูกค้า</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">ลูกค้า</li>
                            <li class="breadcrumb-item">ข้อมูลลูกค้า</li>
                            <li class="breadcrumb-item">แก้ไขข้อมูลลูกค้า</li>
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
                            <a href="<?=home_url()?>page/customer/detail.php?id=<?=$id?>" class="btn btn-secondary mobile-d-block mb-1"><i data-feather="arrow-left"></i> ย้อนกลับ</a>
                            <a href="<?=home_url()?>page/customer/" class="btn btn-primary mobile-d-block mb-1"><i data-feather="list"></i> ลูกค้าทั้งหมด</a>
                        </div>
                        <?php 
                        $allrow = count(getCustomerById($id));
                        if ($allrow != 0) {
                        foreach (getCustomerById($id) as $key => $value) {
                        ?>

                        <input type="hidden" name="customer_id" id="customer_id" value="<?=$value['id']?>">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-12">
                                            <h5>แก้ไขข้อมูลลูกค้า</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_code" class="form-label fw-bold">รหัสลูกค้า <span class="mark">*</span></label>
                                                    <input type="text" class="form-control" id="customer_code" name="customer_code" value="<?=$value['customer_code']?>">
                                                    <label id="customer_code-error" class="mb-0" for="customer_code"></label>
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_name" class="form-label fw-bold">ชื่อลูกค้า/ชื่อบริษัท <span class="mark">*</span></label>
                                                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?=$value['customer_name']?>">
                                                    <label id="customer_name-error" class="mb-0" for="customer_name"></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_address" class="form-label fw-bold">ที่อยู่ <span class="mark">*</span> <small class="text-muted fw-normal">(บ้านเลขที่, อาคาร, หมู่ที่, ตรอก/ซอย, ถนน)</small></label>
                                                    <input type="text" class="form-control" id="customer_address" name="customer_address" value="<?=$value['customer_address']?>">
                                                    <label id="customer_address-error" class="mb-0" for="customer_address"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="customer_provinces" class="form-label fw-bold">จังหวัด <span class="mark">*</span></label>
                                                    <select id="customer_provinces" name="customer_provinces" class="form-control select2" data-placeholder="เลือกจังหวัด...">
                                                        <option></option>
                                                        <?php 
                                                        foreach (getProvincesList() as $key_provinces => $value_provinces) {
                                                            if ($value_provinces['id'] == $value['customer_provinces']) {
                                                                echo '<option value="'.$value_provinces['id'].'" selected>'.$value_provinces['name_th'].'</option>';
                                                            }
                                                            else {
                                                                echo '<option value="'.$value_provinces['id'].'">'.$value_provinces['name_th'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label id="customer_provinces-error" class="mb-0" for="customer_provinces"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="customer_district" class="form-label fw-bold">เขต/อำเภอ <span class="mark">*</span></label>
                                                    <select id="customer_district" name="customer_district" class="form-control select2" data-placeholder="เลือกอำเภอ...">
                                                        <option></option>
                                                        <?php 
                                                        foreach (getAmphuresByProvince($value['customer_provinces']) as $key_district => $value_district) {
                                                            if ($value_district['id'] == $value['customer_district']) {
                                                                echo '<option value="'.$value_district['id'].'" selected>'.$value_district['name_th'].'</option>';
                                                            }
                                                            else {
                                                                echo '<option value="'.$value_district['id'].'">'.$value_district['name_th'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label id="customer_district-error" class="mb-0" for="customer_district"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="customer_subdistrict" class="form-label fw-bold">แขวง/ตำบล <span class="mark">*</span></label>
                                                    <select id="customer_subdistrict" name="customer_subdistrict" class="form-control select2" data-placeholder="เลือกตำบล...">
                                                        <option></option>
                                                        <?php 
                                                        foreach (getDistrictsByAmphures($value['customer_district']) as $key_subdistrict => $value_subdistrict) {
                                                            if ($value_subdistrict['id'] == $value['customer_subdistrict']) {
                                                                echo '<option value="'.$value_subdistrict['id'].'" selected>'.$value_subdistrict['name_th'].'</option>';
                                                            }
                                                            else {
                                                                echo '<option value="'.$value_subdistrict['id'].'">'.$value_subdistrict['name_th'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label id="customer_subdistrict-error" class="mb-0" for="customer_subdistrict"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_zipcode" class="form-label fw-bold">รหัสไปรษณีย์ <span class="mark">*</span></label>
                                                    <select id="customer_zipcode" name="customer_zipcode" class="form-control select2" data-placeholder="เลือกรหัสไปรษณีย์...">
                                                        <option></option>
                                                        <?php 
                                                        echo '<option value="'.$value['customer_zipcode'].'" selected>'.$value['customer_zipcode'].'</option>';
                                                        ?>
                                                    </select>
                                                    <label id="customer_zipcode-error" class="mb-0" for="customer_zipcode"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_tel" class="form-label fw-bold">หมายเลขโทรศัพท์</label>
                                                    <input type="text" class="form-control" id="customer_tel" name="customer_tel" value="<?=$value['customer_tel']?>">
                                                    <label id="customer_tel-error" class="mb-0" for="customer_tel"></label>
                                                </div>
                                            </div>
                                            <div class="row">
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
                            <button type="submit" id="editCustomer" name="editCustomer" class="btn btn-success float-right ml-1"><i data-feather="download"></i> บันทึกการแก้ไข</button>
                            <a href="<?=home_url()?>page/customer/detail.php?id=<?=$id?>" class="btn btn-secondary float-right ml-1"><i data-feather="x"></i> ยกเลิก</a>
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

<!-- ที่อยู่ลูกค้า -->
<script type="text/javascript">
$(document).ready(function () {
    $('#customer_provinces').on('change', function() {
        $.ajax({
            url : '<?=home_url()?>ajax/getDistrictList.php',
            type : 'post',
            dataType: 'json',
            data : {
                province_id: $('#customer_provinces').val(),
            },
            success : function(data) {
                var district_option = '';
                $.each(data.data, function(index, val) {
                    district_option += '<option value="'+val.id+'">'+val.name_th+'</option>';
                });

                $('#customer_district').html(district_option);
                $('#customer_district').trigger('change');
            }
        });
    });

    $('#customer_district').on('change', function() {
        $.ajax({
            url : '<?=home_url()?>ajax/getSubDistrictList.php',
            type : 'post',
            dataType: 'json',
            data : {
                district_id: $('#customer_district').val(),
            },
            success : function(data) {
                var subdistrict_option = '';
                $.each(data.data, function(index, val) {
                    subdistrict_option += '<option value="'+val.id+'">'+val.name_th+'</option>';
                });

                $('#customer_subdistrict').html(subdistrict_option);
                $('#customer_subdistrict').trigger('change');
            }
        });
    });

    $('#customer_subdistrict').on('change', function() {
        $.ajax({
            url : '<?=home_url()?>ajax/getZipcode.php',
            type : 'post',
            dataType: 'json',
            data : {
                subdistrict_id: $('#customer_subdistrict').val(),
            },
            success : function(data) {
                var zipcode_option = '';
                $.each(data.data, function(index, val) {
                    zipcode_option += '<option value="'+val.zip_code+'">'+val.zip_code+'</option>';
                    zipcode = val.zip_code;
                });

                $('#customer_zipcode').html(zipcode_option);
            }
        });
    });
});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $("#edit_customer_form").validate({
        ignore: ".ignore",
        validClass: "is-valid",
        errorClass: "is-invalid",
        errorElement: "label",
        rules: {
            customer_code: {
                required: true,
                maxlength: 20,
            },
            customer_name: {
                required: true,
                maxlength: 100,
            },
            customer_address: {
                required: true,
                maxlength: 150,
            },
            customer_provinces: {required: true},
            customer_district: {required: true},
            customer_subdistrict: {required: true},
            customer_zipcode: {required: true},
            customer_tel: {maxlength: 50},
            is_active: {required: true},
            create_by: {required: true},
            create_at: {required: true},
        },
        messages: {
            customer_code: {
                required: 'โปรดระบุ...',
                maxlength: 'ระบุได้ไม่เกิน 20 ตัวอักษร',
            },
            customer_name: {
                required: 'โปรดระบุ...',
                maxlength: 'ระบุได้ไม่เกิน 100 ตัวอักษร',
            },
            customer_address: {
                required: 'โปรดระบุ...',
                maxlength: 'ระบุได้ไม่เกิน 150 ตัวอักษร',
            },
            customer_provinces: {required: 'โปรดระบุ...'},
            customer_district: {required: 'โปรดระบุ...'},
            customer_subdistrict: {required: 'โปรดระบุ...'},
            customer_zipcode: {required: 'โปรดระบุ...'},
            customer_tel: {maxlength: 'ระบุได้ไม่เกิน 50 ตัวอักษร'},
            is_active: {required: 'โปรดระบุ...'},
            create_by: {required: 'โปรดระบุ...'},
            create_at: {required: 'โปรดระบุ...'},
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "customer_code" ) {
               error.appendTo('#customer_code-error');
            }

            if (element.attr("name") == "customer_name" ) {
               error.appendTo('#customer_name-error');
            }

            if (element.attr("name") == "customer_address" ) {
               error.appendTo('#customer_address-error');
            }

            if (element.attr("name") == "customer_provinces" ) {
               error.appendTo('#customer_provinces-error');
            }

            if (element.attr("name") == "customer_district" ) {
               error.appendTo('#customer_district-error');
            }

            if (element.attr("name") == "customer_subdistrict" ) {
               error.appendTo('#customer_subdistrict-error');
            }

            if (element.attr("name") == "customer_zipcode" ) {
               error.appendTo('#customer_zipcode-error');
            }

            if (element.attr("name") == "customer_total" ) {
               error.appendTo('#customer_total-error');
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
if(isset($_POST['editCustomer'])) {
    editCustomer();
}
?>