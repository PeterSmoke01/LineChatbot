<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/consignment/config/include.php');
require_once(home_path().'controller/fn-customer.php');
global $conn;
date_default_timezone_set("Asia/Bangkok");

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
    <div class="pcoded-content pb-4">
        <!-- breadcrumb start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10"><i data-feather="plus"></i> เพิ่มลูกค้า</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">ลูกค้า</li>
                            <li class="breadcrumb-item">เพิ่มลูกค้า</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-3">
                <form id="create_customer_form" class="needs-validation" method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <a href="<?=home_url()?>page/customer/" class="btn btn-primary"><i data-feather="list"></i> ลูกค้าทั้งหมด</a>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8">
                                            <h5>ข้อมูลลูกค้า</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                    <label for="customer_code" class="form-label">รหัสลูกค้า <span class="mark">*</span></label>
                                                    <input type="text" class="form-control" id="customer_code" name="customer_code" value="">
                                                    <label id="customer_code-error" class="mb-0" for="customer_code"></label>
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                                    <label for="customer_name" class="form-label">ชื่อลูกค้า <span class="mark">*</span></label>
                                                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="">
                                                    <label id="customer_name-error" class="mb-0" for="customer_name"></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_address" class="form-label">ที่อยู่ <span class="mark">*</span> <small class="text-muted">(บ้านเลขที่, อาคาร, หมู่ที่, ตรอก/ซอย, ถนน)</small></label>
                                                    <input type="text" class="form-control" id="customer_address" name="customer_address" value="">
                                                    <label id="customer_address-error" class="mb-0" for="customer_address"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="customer_provinces" class="form-label">จังหวัด <span class="mark">*</span></label>
                                                    <select id="customer_provinces" name="customer_provinces" class="form-control select2" data-placeholder="เลือกจังหวัด...">
                                                        <option></option>
                                                        <?php 
                                                        foreach (getProvincesList() as $key_provinces => $value_provinces) {
                                                            echo '<option value="'.$value_provinces['id'].'">'.$value_provinces['name_th'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <label id="customer_provinces-error" class="mb-0" for="customer_provinces"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="customer_district" class="form-label">เขต/อำเภอ <span class="mark">*</span></label>
                                                    <select id="customer_district" name="customer_district" class="form-control select2" data-placeholder="เลือกอำเภอ...">
                                                        <option></option>
                                                    </select>
                                                    <label id="customer_district-error" class="mb-0" for="customer_district"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="customer_subdistrict" class="form-label">แขวง/ตำบล <span class="mark">*</span></label>
                                                    <select id="customer_subdistrict" name="customer_subdistrict" class="form-control select2" data-placeholder="เลือกตำบล...">
                                                        <option></option>
                                                    </select>
                                                    <label id="customer_subdistrict-error" class="mb-0" for="customer_subdistrict"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_zipcode" class="form-label">รหัสไปรษณีย์ <span class="mark">*</span></label>
                                                    <select id="customer_zipcode" name="customer_zipcode" class="form-control select2" data-placeholder="เลือกรหัสไปรษณีย์...">
                                                        <option></option>
                                                    </select>
                                                    <label id="customer_zipcode-error" class="mb-0" for="customer_zipcode"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_tel" class="form-label">หมายเลขโทรศัพท์</label>
                                                    <input type="text" class="form-control" id="customer_tel" name="customer_tel" value="">
                                                    <label id="customer_tel-error" class="mb-0" for="customer_tel"></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="is_active" class="form-label">สถานะการใช้งาน <span class="mark">*</span></label>
                                                    <select id="is_active" name="is_active" class="form-control select2">
                                                        <option value="Y" selected>เปิดใช้งาน</option>
                                                        <option value="N">ปิดใช้งาน</option>
                                                    </select>
                                                    <label id="is_active-error" class="mb-0" for="is_active"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="create_by" class="form-label">ผู้บันทึก <span class="mark">*</span></label>
                                                    <select id="create_by" name="create_by" class="form-control mb-1" readonly>
                                                        <option value="<?=$current_user['user_id']?>" selected><?=$current_user['user_fullname']?></option>
                                                    </select>
                                                    <label id="create_by-error" class="mb-0" for="create_by"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="create_at" class="form-label">วันที่บันทึก <span class="mark">*</span></label>
                                                    <input type="text" class="form-control" id="create_at" name="create_at" value="<?=date("Y-m-d H:i:s")?>" readonly>
                                                    <label id="create_at-error" class="mb-0" for="create_at"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8">
                                            <h5>ข้อมูลคลังสินค้า</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                    <label class="col-form-label col-auto fw-bold">รายการคลังสินค้าทั้งหมด จำนวน <span id="warehouse_total_text" class="text-primary">0</span> รายการ <span class="mark">*</span></label>
                                                    <input type="text" name="warehouse_total" id="warehouse_total" class="text-center d-none" value="">
                                                    <label id="warehouse_total-error" class="mb-2" for="warehouse_total"></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div id="area_warehouse">
                                                        <div class="panel panel-default" id="area_warehouse_panel">
                                                            <div class="panel-body">
                                                                <ul id="area_warehouse_ul" class="mb-0 p-0">
                                                                    <p id="warehouse_none" class="fst-italic text-danger mb-1" style="padding: 10px; background-color: #e8ebee;">ยังไม่มีรายการคลังสินค้า</p>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <button type="button" class="btn btn-primary fw-normal" data-toggle="modal" data-target="#addWarehouseModal"><i class="fas fa-plus"></i> เพิ่มรายการ</button>
                                                </div>
                                            </div>

                                            <!-- Start Modal Warehouse -->
                                            <div class="modal fade" id="addWarehouseModal" aria-labelledby="addWarehouseModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><i data-feather="plus-circle"></i> เพิ่มรายการคลังสินค้า</h4>
                                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-muted text-sm mb-3">โปรดระบุข้อมูลช่องที่มีเครื่องหมาย <span class="mark">*</span> ให้ครบถ้วน แล้วคลิกยืนยันข้อมูล</p>
                                                            <div class="row">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                    <div class="row">
                                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                            <label for="txt_wh_code" class="form-label">รหัสคลังสินค้า <span class="mark">*</span></label>
                                                                            <input type="text" id="txt_wh_code" name="txt_wh_code" class="form-control" maxlength="20">
                                                                            <label id="txt_wh_code1-error" class="mb-2" for="txt_wh_code1"></label>
                                                                        </div>
                                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                            <label for="txt_wh_name" class="form-label">ชื่อคลังสินค้า <span class="mark">*</span></label>
                                                                            <input type="text" id="txt_wh_name" name="txt_wh_name" class="form-control" maxlength="100">
                                                                            <label id="txt_wh_name1-error" class="mb-2" for="txt_wh_name1"></label>
                                                                        </div>
                                                                        <p class="fw-bold mb-2">ที่ตั้งคลังสินค้า</p>
                                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                                                            <label for="txt_wh_provinces" class="form-label">จังหวัด <span class="mark">*</span></label>
                                                                            <select id="txt_wh_provinces" name="txt_wh_provinces" class="form-control select2" data-placeholder="เลือกจังหวัด...">
                                                                                <option></option>
                                                                                <?php 
                                                                                foreach (getProvincesList() as $key_provinces => $value_provinces) {
                                                                                    echo '<option value="'.$value_provinces['id'].'">'.$value_provinces['name_th'].'</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <label id="txt_wh_provinces1-error" class="mb-0" for="txt_wh_provinces1"></label>
                                                                        </div>
                                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                                                            <label for="txt_wh_district" class="form-label">เขต/อำเภอ <span class="mark">*</span></label>
                                                                            <select id="txt_wh_district" name="txt_wh_district" class="form-control select2" data-placeholder="เลือกอำเภอ...">
                                                                                <option></option>
                                                                            </select>
                                                                            <label id="txt_wh_district1-error" class="mb-0" for="txt_wh_district1"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="row">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                                                    <button class="btn btn-primary fw-normal" id="confirmWarehouse" type="button"><i class="fas fa-check"></i> ยืนยันข้อมูล</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal Warehouse -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8">
                                            <h5>ข้อมูลสินค้าและราคา</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                    <label class="col-form-label col-auto fw-bold">รายการสินค้าและราคาทั้งหมด จำนวน <span id="customer_item_total_text" class="text-primary">0</span> รายการ <span class="mark">*</span></label>
                                                    <input type="text" name="customer_item_total" id="customer_item_total" class="text-center d-none" value="">
                                                    <label id="customer_item_total-error" class="mb-2" for="customer_item_total"></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div id="area_customer_item">
                                                        <div class="panel panel-default" id="area_customer_item_panel">
                                                            <div class="panel-body">
                                                                <ul id="area_customer_item_ul" class="mb-0 p-0">
                                                                    <p id="customer_item_none" class="fst-italic text-danger mb-1" style="padding: 10px; background-color: #e8ebee;">ยังไม่มีรายการสินค้าและราคา</p>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <button type="button" class="btn btn-primary fw-normal" data-toggle="modal" data-target="#customerItemModal"><i class="fas fa-plus"></i> เพิ่มรายการ</button>
                                                </div>
                                            </div>

                                            <!-- Start Modal customer Item -->
                                            <div class="modal fade" id="customerItemModal" aria-labelledby="customerItemModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><i data-feather="plus-circle"></i> เพิ่มรายการสินค้าและราคา</h4>
                                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-muted text-sm mb-3">โปรดระบุข้อมูลช่องที่มีเครื่องหมาย <span class="mark">*</span> ให้ครบถ้วน แล้วคลิกยืนยันข้อมูล</p>
                                                            <div class="row">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                    <div class="row">
                                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                            <label for="txt_customer_item_goods" class="form-label fw-bold">ชื่อสินค้า <span class="mark">*</span></label>
                                                                            <select id="txt_customer_item_goods" name="txt_customer_item_goods" class="form-control select2" data-placeholder="เลือกสินค้า...">
                                                                                <option></option>
                                                                                <?php 
                                                                                foreach (getGoodsList() as $key_goods => $value_goods) {
                                                                                    echo '<option value="'.$value_goods['id'].'">'.$value_goods['goods_code'].' - '.$value_goods['goods_name'].'</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <label id="txt_customer_item_goods1-error" class="mb-2" for="txt_customer_item_goods1"></label>
                                                                        </div>
                                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                            <label for="txt_customer_item_max" class="form-label fw-bold">จำนวนสต๊อกตั้งต้น <span class="mark">*</span></label>
                                                                            <input type="number" id="txt_customer_item_max" name="txt_customer_item_max" class="form-control" min="1" step="1">
                                                                            <label id="txt_customer_item_max1-error" class="mb-2" for="txt_customer_item_max1"></label>
                                                                        </div>
                                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                            <label for="txt_customer_item_min" class="form-label fw-bold">จำนวนสต๊อกต่ำสุด <span class="mark">*</span> <small class="text-muted fw-normal">ใช้สำหรับแจ้งเตือนเพื่อจัดส่งสินค้า</small></label>
                                                                            <input type="number" id="txt_customer_item_min" name="txt_customer_item_min" class="form-control" min="1" step="1">
                                                                            <label id="txt_customer_item_min1-error" class="mb-2" for="txt_customer_item_min1"></label>
                                                                        </div>
                                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                            <label for="txt_customer_item_unit_price" class="form-label fw-bold">ราคาต่อหน่วย (บาท) <span class="mark">*</span></label>
                                                                            <input type="text" id="txt_customer_item_unit_price" name="txt_customer_item_unit_price" class="form-control" maxlength="20">
                                                                            <label id="txt_customer_item_unit_price1-error" class="mb-2" for="txt_customer_item_unit_price1"></label>
                                                                        </div>
                                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                            <label for="txt_customer_item_total_price" class="form-label fw-bold">มูลค่ารวม (บาท) <span class="mark">*</span></label>
                                                                            <input type="text" id="txt_customer_item_total_price" name="txt_customer_item_total_price" class="form-control" maxlength="20" readonly>
                                                                            <label id="txt_customer_item_total_price1-error" class="mb-2" for="txt_customer_item_total_price1"></label>
                                                                        </div>
                                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                            <label for="txt_customer_item_cuscode" class="form-label fw-bold">รหัสสินค้าในระบบลูกค้า</label>
                                                                            <input type="text" id="txt_customer_item_cuscode" name="txt_customer_item_cuscode" class="form-control" maxlength="50">
                                                                            <label id="txt_customer_item_cuscode1-error" class="mb-2" for="txt_customer_item_cuscode1"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="row">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                                                    <button class="btn btn-primary fw-normal" id="confirmAddCustomerItem" type="button"><i class="fas fa-check"></i> ยืนยันข้อมูล</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal customer Item -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <button type="submit" id="addCustomer" name="addCustomer" class="btn btn-success float-right ml-1"><i data-feather="download"></i> บันทึกข้อมูล</button>
                            <a href="<?=home_url()?>page/customer/" class="btn btn-secondary float-right ml-1"><i data-feather="x"></i> ยกเลิก</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Main Content end -->

    </div>
</div>

<?php require_once(home_path().'/config/footer/footer.php'); ?>

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

<!-- ที่ตั้งคลังสินค้า -->
<script type="text/javascript">
$(document).ready(function () {
    $('#txt_wh_provinces').on('change', function() {
        $.ajax({
            url : '<?=home_url()?>ajax/getDistrictList.php',
            type : 'post',
            dataType: 'json',
            data : {
                province_id: $('#txt_wh_provinces').val(),
            },
            success : function(data) {
                var district_option = '';
                $.each(data.data, function(index, val) {
                    district_option += '<option value="'+val.id+'">'+val.name_th+'</option>';
                });

                $('#txt_wh_district').html(district_option);
                $('#txt_wh_district').trigger('change');
            }
        });
    });
});
</script>

<!-- ============== Add Warehouse ============= -->
<script type="text/javascript">
$(document).ready(function () {
    $('#txt_wh_code').on('keyup blur change', function () {
        var txt_wh_code = $('#txt_wh_code').val();
        if (txt_wh_code != '') {
            $('#txt_wh_code').addClass('is-valid').removeClass('is-invalid');
            $('#txt_wh_code1-error').removeClass('is-invalid').html('');
        }
        else {
            $('#txt_wh_code').addClass('is-invalid').removeClass('is-valid');
            $('#txt_wh_code1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
        }
    });

    $('#txt_wh_name').on('keyup blur change', function () {
        var txt_wh_name = $('#txt_wh_name').val();
        if (txt_wh_name != '') {
            $('#txt_wh_name').addClass('is-valid').removeClass('is-invalid');
            $('#txt_wh_name1-error').removeClass('is-invalid').html('');
        }
        else {
            $('#txt_wh_name').addClass('is-invalid').removeClass('is-valid');
            $('#txt_wh_name1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
        }
    });

    $('#txt_wh_provinces').on('change', function () {
        var txt_wh_provinces = $('#txt_wh_provinces').val();
        if (txt_wh_provinces != '') {
            $('#txt_wh_provinces').addClass('is-valid').removeClass('is-invalid');
            $('#txt_wh_provinces1-error').removeClass('is-invalid').html('');
        }
    });

    $('#txt_wh_district').on('change', function () {
        var txt_wh_district = $('#txt_wh_district').val();
        if (txt_wh_district != '') {
            $('#txt_wh_district').addClass('is-valid').removeClass('is-invalid');
            $('#txt_wh_district1-error').removeClass('is-invalid').html('');
        }
    });

    var sort_number = 1;
    $("#confirmWarehouse").click(function () {
        var wh_code = $('#txt_wh_code').val().trim();
        var wh_name = $('#txt_wh_name').val().trim();
        var wh_provinces = $('#txt_wh_provinces').val().trim();
        var wh_district = $('#txt_wh_district').val().trim();
        var wh_provinces_text = $('#txt_wh_provinces').select2('data')[0].text;
        var wh_district_text = $('#txt_wh_district').select2('data')[0].text;    

        if (wh_code != "" && wh_name != "" && wh_provinces != "" && wh_district != "") {
            $("button#confirmWarehouse").html('<i class="fas fa-circle-notch fa-spin"></i> กำลังประมวลผล');

            setTimeout(function() {
                var html = "";
                    html += '<li data-area="area_warehouse_li_'+sort_number+'" data-sort="'+sort_number+'" id="warehouse_'+wh_code+'" class="mb-1 ui-state-default area_warehouse_li_'+sort_number+'" style="cursor: unset;">';
                    html += '<div class="row align-items-center">';

                    html += '<div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">';

                    html += '<div class="row align-items-center mb-2">';
                    html += '<label class="col-form-label col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6 fw-bold pt-0 pb-0">รหัสคลังสินค้า :</label>';
                    html += '<div class="col-xl-4 col-lg-4 col-md-3 col-sm-6 col-6 pb-0">';
                    html += '<span class="form-control" readonly>'+wh_code+'</span>';
                    html += '<input type="hidden" id="wh_code'+sort_number+'" name="wh_code[]" class="form-control" value="'+wh_code+'">';  
                    html += '</div>';
                    html += '<label class="col-form-label col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6 fw-bold pt-0 pb-0">ชื่อคลังสินค้า :</label>';
                    html += '<div class="col-xl-4 col-lg-4 col-md-3 col-sm-6 col-6 pb-0">';
                    html += '<span class="form-control" readonly>'+wh_name+'</span>';
                    html += '<input type="hidden" id="wh_name'+sort_number+'" name="wh_name[]" class="form-control" value="'+wh_name+'">';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="row align-items-center">';
                    html += '<label class="col-form-label col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6 fw-bold pt-0 pb-0">ที่ตั้ง เขต/อำเภอ :</label>';
                    html += '<div class="col-xl-4 col-lg-4 col-md-3 col-sm-6 col-6 pb-0">';
                    html += '<span class="form-control" readonly>'+wh_district_text+'</span>';
                    html += '<input type="hidden" id="wh_district'+sort_number+'" name="wh_district[]" class="form-control" value="'+wh_district+'">';  
                    html += '</div>';
                    html += '<label class="col-form-label col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6 fw-bold pt-0 pb-0">จังหวัด :</label>';
                    html += '<div class="col-xl-4 col-lg-4 col-md-3 col-sm-6 col-6 pb-0">';
                    html += '<span class="form-control" readonly>'+wh_provinces_text+'</span>';
                    html += '<input type="hidden" id="wh_provinces'+sort_number+'" name="wh_provinces[]" class="form-control" value="'+wh_provinces+'">';
                    html += '</div>';
                    html += '</div>';

                    html += '</div>';

                    html += '<div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">';
                    html += '<a data-button="'+sort_number+'" class="btn btn-danger btn-sm text-sm text-light float-xl-right" id="remove_warehouse"><i class="fas fa-times"></i></a>';
                    html += '</div>';

                    html += '</div>';
                    html += '</li>';

                var check_append = $("ul#area_warehouse_ul li#warehouse_"+wh_code).length;
                if (check_append == 0) {
                    $('ul#area_warehouse_ul').append(html);

                    var total_warehouse = $('ul#area_warehouse_ul li').length;
                    $('#warehouse_total').val(total_warehouse);
                    $('#warehouse_total_text').html(total_warehouse);
                    $('.select2').select2();
                    sort_number++;
                }
                else {
                    Swal.fire({
                        title: "เพิ่มรายการคลังสินค้าซ้ำซ้อน",
                        html: "รายการคลังสินค้า <b>"+wh_code+" </b> เพิ่มเข้าไปในรายการแล้ว",
                        icon: "warning",
                        confirmButtonColor: "#1690ed",
                    });
                }

                if ($('#warehouse_total').val() > 0) {
                    $('p#warehouse_none').removeClass('d-block').addClass('d-none').html('');
                }
                else {
                    $('p#warehouse_none').removeClass('d-none').addClass('d-block').html('ยังไม่มีรายการคลังสินค้า');
                }

                //Reset input
                $("button#confirmWarehouse").html('<i class="fas fa-check"></i> ยืนยันข้อมูล');
                $('#txt_wh_code').val('').removeClass('is-valid');
                $('#txt_wh_name').val('').removeClass('is-valid');
                $('#txt_wh_provinces').removeClass('is-valid');
                $('#txt_wh_provinces').val(null).trigger('change');
                $('#txt_wh_district').removeClass('is-valid');
                $('#txt_wh_district').val(null).trigger('change');
                $('#addWarehouseModal').modal('hide');

            },1000);
        }
        else {
            if (wh_code == "") {
                $('#txt_wh_code').addClass('is-invalid').removeClass('is-valid');
                $('#txt_wh_code1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
            }
            else {
                $('#txt_wh_code').addClass('is-valid').removeClass('is-invalid');
                $('#txt_wh_code1-error').addClass('is-valid').removeClass('is-invalid').html('');
            }

            if (wh_name == "") {
                $('#txt_wh_name').addClass('is-invalid').removeClass('is-valid');
                $('#txt_wh_name1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
            }
            else {
                $('#txt_wh_name').addClass('is-valid').removeClass('is-invalid');
                $('#txt_wh_name1-error').addClass('is-valid').removeClass('is-invalid').html('');
            }

            if (wh_provinces == "") {
                $('#txt_wh_provinces').addClass('is-invalid').removeClass('is-valid');
                $('#txt_wh_provinces1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
            }
            else {
                $('#txt_wh_provinces').addClass('is-valid').removeClass('is-invalid');
                $('#txt_wh_provinces1-error').addClass('is-valid').removeClass('is-invalid').html('');
            }

            if (wh_district == "") {
                $('#txt_wh_district').addClass('is-invalid').removeClass('is-valid');
                $('#txt_wh_district1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
            }
            else {
                $('#txt_wh_district').addClass('is-valid').removeClass('is-invalid');
                $('#txt_wh_district1-error').addClass('is-valid').removeClass('is-invalid').html('');
            }
        }        
    });
});

$(function () {
    //Remove
    $('ul#area_warehouse_ul').on('click', '#remove_warehouse', function() {
        var button_id = $(this).data('button');
        $("ul#area_warehouse_ul > li.area_warehouse_li_"+button_id).remove();
        var total_warehouse = $('ul#area_warehouse_ul li').length;

        if (total_warehouse > 0) {
            $('#warehouse_total').val(total_warehouse);
            $('#warehouse_total_text').html(total_warehouse);
            $('p#warehouse_none').removeClass('d-block').addClass('d-none').html('');
        }
        else {
            $('#warehouse_total').val('');
            $('#warehouse_total_text').html('0');
            $('p#warehouse_none').removeClass('d-none').addClass('d-block').html('ยังไม่มีรายการคลังสินค้า');
        }
    });
});
</script>

<!-- ============== Add customer item ============= -->
<script type="text/javascript">
$(document).ready(function () {

    $('#txt_customer_item_goods').on('change', function () {
        var txt_customer_item_goods = $('#txt_customer_item_goods').val();
        if (txt_customer_item_goods != '') {
            $('#txt_customer_item_goods').addClass('is-valid').removeClass('is-invalid');
            $('#txt_customer_item_goods1-error').removeClass('is-invalid').html('');
        }
    });

    $('#txt_customer_item_max').on('keyup blur change', function () {
        var txt_customer_item_max = $('#txt_customer_item_max').val();
        if (txt_customer_item_max != '') {
            $('#txt_customer_item_max').addClass('is-valid').removeClass('is-invalid');
            $('#txt_customer_item_max1-error').removeClass('is-invalid').html('');
        }
        else {
            $('#txt_customer_item_max').addClass('is-invalid').removeClass('is-valid');
            $('#txt_customer_item_max1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
        }
    });

    $('#txt_customer_item_min').on('keyup blur change', function () {
        var txt_customer_item_min = $('#txt_customer_item_min').val();
        if (txt_customer_item_min != '') {
            $('#txt_customer_item_min').addClass('is-valid').removeClass('is-invalid');
            $('#txt_customer_item_min1-error').removeClass('is-invalid').html('');
        }
        else {
            $('#txt_customer_item_min').addClass('is-invalid').removeClass('is-valid');
            $('#txt_customer_item_min1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
        }
    });

    $('#txt_customer_item_unit_price').on('keyup blur change', function () {
        var txt_customer_item_unit_price = $('#txt_customer_item_unit_price').val();
        if (txt_customer_item_unit_price != '') {
            $('#txt_customer_item_unit_price').addClass('is-valid').removeClass('is-invalid');
            $('#txt_customer_item_unit_price1-error').removeClass('is-invalid').html('');
        }
        else {
            $('#txt_customer_item_unit_price').addClass('is-invalid').removeClass('is-valid');
            $('#txt_customer_item_unit_price1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
        }
    });

    $('#txt_customer_item_total_price').on('keyup blur change', function () {
        var txt_customer_item_total_price = $('#txt_customer_item_total_price').val();
        if (txt_customer_item_total_price != '') {
            $('#txt_customer_item_total_price').addClass('is-valid').removeClass('is-invalid');
            $('#txt_customer_item_total_price1-error').removeClass('is-invalid').html('');
        }
        else {
            $('#txt_customer_item_total_price').addClass('is-invalid').removeClass('is-valid');
            $('#txt_customer_item_total_price1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
        }
    });

    var sort_number = 1;
    $("#confirmAddCustomerItem").click(function () {
        var customer_item_goods = $('#txt_customer_item_goods').val().trim();
        var customer_item_goods_text = $('#txt_customer_item_goods').select2('data')[0].text;
        var customer_item_cuscode = $('#txt_customer_item_cuscode').val().trim();
        var customer_item_max = $('#txt_customer_item_max').val().trim();
        var customer_item_min = $('#txt_customer_item_min').val().trim();
        var customer_item_unit_price = $('#txt_customer_item_unit_price').val().trim();
        var customer_item_total_price = $('#txt_customer_item_total_price').val().trim();

        if (customer_item_goods != "" && customer_item_max != "" && customer_item_min != "" && customer_item_unit_price != "" && customer_item_total_price != "") {
            $("button#confirmAddCustomerItem").html('<i class="fas fa-circle-notch fa-spin"></i> กำลังประมวลผล');

            setTimeout(function() {
                var html = "";
                    html += '<li data-area="area_customer_item_li_'+customer_item_goods+'" data-sort="'+sort_number+'" id="customer_item_'+customer_item_goods+'" class="mb-1 ui-state-default">';
                    html += '<div class="row align-items-center">';

                    html += '<div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12 text-md">';

                    html += '<div class="row align-items-center">';
                    html += '<label class="col-form-label col-xl-2 col-lg-3 col-md-3 col-sm-6 col-6 fw-bold pt-0 pb-2">ชื่อสินค้า <label id="customer_item_goods'+customer_item_goods+'-error" class="mb-0 fw-normal" for="customer_item_goods'+customer_item_goods+'"></label></label>';
                    html += '<div class="col-xl-10 col-lg-9 col-md-9 col-sm-6 col-6 pb-2">';
                    html += '<span class="form-control" readonly>'+customer_item_goods_text+'</span>';
                    html += '<input type="hidden" id="customer_item_goods'+customer_item_goods+'" name="customer_item_goods[]" class="form-control" value="'+customer_item_goods+'">'; 
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="row align-items-center">';
                    html += '<label class="col-form-label col-xl-2 col-lg-3 col-md-3 col-sm-6 col-6 fw-bold pt-0 pb-2">จำนวนสต๊อกตั้งต้น</label>';
                    html += '<div class="col-xl-4 col-lg-3 col-md-3 col-sm-6 col-6 pb-2">';
                    html += '<input type="text" id="customer_item_max'+customer_item_goods+'" name="customer_item_max[]" class="form-control" value="'+customer_item_max+'" onkeyup="calcustomerItemPrice('+customer_item_goods+')">';
                    html += '</div>';
                    html += '<label class="col-form-label col-xl-2 col-lg-3 col-md-3 col-sm-6 col-6 fw-bold pt-0 pb-2">จำนวนสต๊อกต่ำสุด</label>';
                    html += '<div class="col-xl-4 col-lg-3 col-md-3 col-sm-6 col-6 pb-2">';
                    html += '<input type="text" id="customer_item_min'+customer_item_goods+'" name="customer_item_min[]" class="form-control" value="'+customer_item_min+'">';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="row align-items-center">';
                    html += '<label class="col-form-label col-xl-2 col-lg-3 col-md-3 col-sm-6 col-6 fw-bold pt-0 pb-2">ราคาต่อหน่วย (บาท)</label>';
                    html += '<div class="col-xl-4 col-lg-3 col-md-3 col-sm-6 col-6 pb-2">';
                    html += '<input type="text" id="customer_item_unit_price'+customer_item_goods+'" name="customer_item_unit_price[]" class="form-control" value="'+customer_item_unit_price+'" onkeyup="calcustomerItemPrice('+customer_item_goods+')">';
                    html += '</div>';
                    html += '<label class="col-form-label col-xl-2 col-lg-3 col-md-3 col-sm-6 col-6 fw-bold pt-0 pb-2">มูลค่ารวม (บาท)</label>';
                    html += '<div class="col-xl-4 col-lg-3 col-md-3 col-sm-6 col-6 pb-2">';
                    html += '<input type="text" id="customer_item_total_price'+customer_item_goods+'" name="customer_item_total_price[]" class="form-control" value="'+customer_item_total_price+'">';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="row align-items-center">';
                    html += '<label class="col-form-label col-xl-2 col-lg-3 col-md-3 col-sm-6 col-6 fw-bold pt-0 pb-0">รหัสสินค้าในระบบลูกค้า</label>';
                    html += '<div class="col-xl-4 col-lg-3 col-md-3 col-sm-6 col-6 pb-2">';
                    html += '<input type="text" id="customer_item_cuscode'+customer_item_goods+'" name="customer_item_cuscode[]" class="form-control" value="'+customer_item_cuscode+'">';
                    html += '</div>';
                    html += '</div>';

                    html += '</div>';

                    html += '<div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">';
                    html += '<a data-button="'+customer_item_goods+'" class="btn btn-danger btn-sm text-light float-xl-right" id="remove_customer_item"><i class="fas fa-times"></i></a>';
                    html += '</div>';

                    html += '</div>';
                    html += '</li>';

                var check_append = $("ul#area_customer_item_ul li#customer_item_"+customer_item_goods).length;
                if (check_append == 0) {
                    $('ul#area_customer_item_ul').append(html);

                    var total_customer_item = $('ul#area_customer_item_ul li').length;
                    $('#customer_item_total').val(total_customer_item);
                    $('#customer_item_total_text').html(total_customer_item);
                    $('.select2').select2();
                    sort_number++;
                }
                else {
                    Swal.fire({
                        title: "เพิ่มรายการสินค้าซ้ำซ้อน",
                        html: "รายการสินค้า <br><b>"+customer_item_goods_text+" </b> <br>เพิ่มเข้าไปในรายการแล้ว",
                        icon: "warning",
                        confirmButtonColor: "#1690ed",
                    });
                }

                if ($('#customer_item_total').val() > 0) {
                    $('p#customer_item_none').removeClass('d-block').addClass('d-none').html('');
                }
                else {
                    $('p#customer_item_none').removeClass('d-none').addClass('d-block').html('ยังไม่มีรายการสินค้าและราคา');
                }

                //Reset input
                $("button#confirmAddCustomerItem").html('<i class="fas fa-check"></i> ยืนยันข้อมูล');
                $('#txt_customer_item_goods').removeClass('is-valid');
                $('#txt_customer_item_goods').val(null).trigger('change');
                $('#txt_customer_item_goods_cuscode').val('').removeClass('is-valid');
                $('#txt_customer_item_max').val('').removeClass('is-valid');
                $('#txt_customer_item_min').val('').removeClass('is-valid');
                $('#txt_customer_item_unit_price').val('').removeClass('is-valid');
                $('#txt_customer_item_total_price').val('').removeClass('is-valid');
                $('#customerItemModal').modal('hide');

            },1000);
        }
        else {
            if (customer_item_goods == "") {
                $('#txt_customer_item_goods').addClass('is-invalid').removeClass('is-valid');
                $('#txt_customer_item_goods1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
            }
            else {
                $('#txt_customer_item_goods').addClass('is-valid').removeClass('is-invalid');
                $('#txt_customer_item_goods1-error').addClass('is-valid').removeClass('is-invalid').html('');
            }

            if (customer_item_max == "") {
                $('#txt_customer_item_max').addClass('is-invalid').removeClass('is-valid');
                $('#txt_customer_item_max1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
            }
            else {
                $('#txt_customer_item_max').addClass('is-valid').removeClass('is-invalid');
                $('#txt_customer_item_max1-error').addClass('is-valid').removeClass('is-invalid').html('');
            }

            if (customer_item_min == "") {
                $('#txt_customer_item_min').addClass('is-invalid').removeClass('is-valid');
                $('#txt_customer_item_min1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
            }
            else {
                $('#txt_customer_item_min').addClass('is-valid').removeClass('is-invalid');
                $('#txt_customer_item_min1-error').addClass('is-valid').removeClass('is-invalid').html('');
            }

            if (customer_item_unit_price == "") {
                $('#txt_customer_item_unit_price').addClass('is-invalid').removeClass('is-valid');
                $('#txt_customer_item_unit_price1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
            }
            else {
                $('#txt_customer_item_unit_price').addClass('is-valid').removeClass('is-invalid');
                $('#txt_customer_item_unit_price1-error').addClass('is-valid').removeClass('is-invalid').html('');
            }

            if (customer_item_total_price == "") {
                $('#txt_customer_item_total_price').addClass('is-invalid').removeClass('is-valid');
                $('#txt_customer_item_total_price1-error').addClass('is-invalid').removeClass('is-valid').html('โปรดระบุ...');
            }
            else {
                $('#txt_customer_item_total_price').addClass('is-valid').removeClass('is-invalid');
                $('#txt_customer_item_total_price1-error').addClass('is-valid').removeClass('is-invalid').html('');
            }
        }        
    });
});

$(function () {
    //Sorting
    $("ul#area_customer_item_ul").sortable({
        placeholder: "ui-state-highlight",
        update: function(event, ui) {
            var j=0;
            var k=0;

            $("ul#area_customer_item_ul li").each(function() {
                var array_customer_item = [];
                var i;

                array_customer_item.push($(this).data('area'));
                for (i = 0; i < array_customer_item.length; i++) {
                    $("ul#area_customer_item_ul > li[data-area='"+array_customer_item[i]+"']").attr('data-sort',++j);
                }   
            });
        }
    });
    $('ul#area_customer_item_ul').disableSelection();
    
    //Remove
    $('ul#area_customer_item_ul').on('click', '#remove_customer_item', function() {
        var button_id = $(this).data('button');
        $("ul#area_customer_item_ul > li#customer_item_"+button_id).remove();
        var total_customer_item = $('ul#area_customer_item_ul li').length;

        if (total_customer_item > 0) {
            $('#customer_item_total').val(total_customer_item);
            $('#customer_item_total_text').html(total_customer_item);
            $('p#customer_item_none').removeClass('d-block').addClass('d-none').html('');
        }
        else {
            $('#customer_item_total').val('');
            $('#customer_item_total_text').html('0');
            $('p#customer_item_none').removeClass('d-none').addClass('d-block').html('ยังไม่มีรายการสินค้าและราคา');
        }
    });
});
</script>

<script type="text/javascript">
function calcustomerItemPrice(id) {
    var item_max = $('#customer_item_max'+id).val();
    var item_unit_price = $('#customer_item_unit_price'+id).val();
    var unit_price = item_unit_price.replace(',', "");

    var total_price = (item_max*unit_price);
    var item_min = Math.floor((item_max/2));

    $('#customer_item_min'+id).val(item_min);
    $('#customer_item_total_price'+id).val(total_price.toFixed(2));
    formatCurrency($('#customer_item_unit_price'+id));
    formatCurrency($('#customer_item_total_price'+id));
}
</script>

<script type="text/javascript">
$(document).ready(function () {

    $('#txt_customer_item_max').on('keyup blur change', function () {
        var item_max = $('#txt_customer_item_max').val();
        var item_unit_price = $('#txt_customer_item_unit_price').val();

        if (item_max != '' && item_unit_price != '') {
            var unit_price = item_unit_price.replace(',', "");
            var total_price = (item_max*unit_price);
        }
        else {
            var total_price = 0;
        }

        var item_min = Math.floor((item_max/2));
        $('#txt_customer_item_min').val(item_min);
        $('#txt_customer_item_total_price').val(total_price.toFixed(2));
        $('#txt_customer_item_total_price').trigger('blur');
    });


    $('#txt_customer_item_unit_price').on({
        keyup: function() {
            formatCurrency($(this));

            var item_max = $('#txt_customer_item_max').val();
            var item_unit_price = $('#txt_customer_item_unit_price').val();

            if (item_max != '' && item_unit_price != '') {
                var unit_price = item_unit_price.replace(',', "");
                var total_price = (item_max*unit_price);
            }
            else {
                var total_price = 0;
            }

            $('#txt_customer_item_total_price').val(total_price.toFixed(2));
            $('#txt_customer_item_total_price').trigger('blur');
        },
        blur: function() { 
            formatCurrency($(this), "blur");
        },
    });

    $('#txt_customer_item_total_price').on({
        keyup: function() {
            formatCurrency($(this));
        },
        blur: function() { 
            formatCurrency($(this), "blur");
        },
    });
});
</script>

<script type="text/javascript">
    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }

    function formatCurrency(input, blur) {

        // get input value
        var input_val = input.val();
    
        // don't validate empty input
        if (input_val === "") { return; }

        // original length
        var original_len = input_val.length;

        // initial caret position
        var caret_pos = input.prop("selectionStart");
            
        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);

            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }

            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            input_val = formatNumber(input_val);
            input_val = input_val;
    
            // final formatting
            if (blur === "blur") {
                input_val += ".00";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }
</script>

<script type="text/javascript">
$(document).ready(function () {
    $("#create_customer_form").validate({
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
            warehouse_total: {
                required: function(element) {
                    return $("#warehouse_total").val() == '';
                },
            },
            customer_item_total: {
                required: function(element) {
                    return $("#customer_item_total").val() == '';
                },
            },
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
            warehouse_total: {required: 'โปรดระบุอย่างน้อย 1 รายการ...'},
            customer_item_total: {required: 'โปรดระบุอย่างน้อย 1 รายการ...'},
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

            if (element.attr("name") == "warehouse_total" ) {
               error.appendTo('#warehouse_total-error');
            }

            if (element.attr("name") == "customer_item_total" ) {
               error.appendTo('#customer_item_total-error');
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
if(isset($_POST['addCustomer'])) {
    addCustomer();
}
?>