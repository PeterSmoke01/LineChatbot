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

$allrow = count(getCustomerItemById($id));
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
                            <h5 class="m-b-10"><i data-feather="edit"></i> แก้ไขสินค้าและราคา</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">ลูกค้า</li>
                            <li class="breadcrumb-item">ข้อมูลสินค้าและราคา</li>
                            <li class="breadcrumb-item">แก้ไขสินค้าและราคา</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-3">
                <form id="edit_customer_item_form" class="needs-validation" method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <?php foreach (getCustomerItemById($id) as $key_item => $value_item) { ?>
                                <a href="<?=home_url()?>page/customer/detail.php?id=<?=$value_item['customer_id']?>" class="btn btn-secondary mobile-d-block mb-1"><i data-feather="arrow-left"></i> ย้อนกลับ</a>
                            <?php } ?>
                            <a href="<?=home_url()?>page/customer/" class="btn btn-primary mobile-d-block mb-1"><i data-feather="list"></i> ลูกค้าทั้งหมด</a>
                        </div>
                        <?php 
                        if ($allrow != 0) {
                        foreach (getCustomerItemById($id) as $key => $value) {
                        ?>

                        <input type="hidden" name="customer_item_id" id="customer_item_id" value="<?=$value['id']?>">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8">
                                            <h5>แก้ไขสินค้าและราคา</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <h5 class="text-decoration-underline text-primary">ข้อมูลสินค้า</h5>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label for="customer_id" class="form-label fw-bold">ชื่อลูกค้า <span class="mark">*</span></label>
                                                    <select id="customer_id" name="customer_id" class="form-control" readonly>
                                                    <?php 
                                                        foreach (getCustomerById($value['customer_id']) as $key_customer => $value_customer) {
                                                            echo '<option value="'.$value_customer['id'].'" selected>'.$value_customer['customer_name'].'</option>';
                                                        }
                                                    ?>
                                                    </select>
                                                    <label id="customer_id-error" class="mb-2" for="customer_id"></label>
                                                </div>
                                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label for="customer_item_goods" class="form-label fw-bold">ชื่อสินค้า <span class="mark">*</span></label>
                                                    <select id="customer_item_goods" name="customer_item_goods" class="form-control" readonly>
                                                    <?php 
                                                        foreach (getGoodsList() as $key_goods_list => $value_goods_list) {
                                                            if ($value_goods_list['id'] == $value['customer_item_goods']) {
                                                                echo '<option value="'.$value_goods_list['id'].'" selected>'.$value_goods_list['goods_code'].' - '.$value_goods_list['goods_name'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                    <label id="customer_item_goods-error" class="mb-2" for="customer_item_goods"></label>
                                                </div>
                                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <label for="customer_item_cuscode" class="form-label fw-bold">รหัสสินค้าในระบบลูกค้า</label>
                                                    <input type="text" id="customer_item_cuscode" name="customer_item_cuscode" class="form-control" maxlength="50" value="<?=$value['customer_item_cuscode']?>">
                                                    <label id="customer_item_cuscode-error" class="mb-2" for="customer_item_cuscode"></label>
                                                </div>
                                            </div>

                                            <h5 class="mt-4 text-decoration-underline text-primary">ข้อมูลจำนวนและราคา</h5>
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_item_max" class="form-label fw-bold">จำนวนสต๊อกตั้งต้น <span class="mark">*</span></label>
                                                    <input type="number" id="customer_item_max" name="customer_item_max" class="form-control" min="1" step="1" value="<?=$value['customer_item_max']?>">
                                                    <label id="customer_item_max-error" class="mb-2" for="customer_item_max"></label>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_item_min" class="form-label fw-bold">จำนวนสต๊อกต่ำสุด <span class="mark">*</span></label>
                                                    <input type="number" id="customer_item_min" name="customer_item_min" class="form-control" min="1" step="1" value="<?=$value['customer_item_min']?>">
                                                    <label id="customer_item_min-error" class="mb-2" for="customer_item_min"></label>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_item_unit_price" class="form-label fw-bold">ราคาต่อหน่วย (บาท) <span class="mark">*</span></label>
                                                    <input type="text" id="customer_item_unit_price" name="customer_item_unit_price" class="form-control" maxlength="20" value="<?=($value['customer_item_unit_price'] != '' ? number_format($value['customer_item_unit_price'], 2) : '0.00')?>">
                                                    <label id="customer_item_unit_price-error" class="mb-2" for="customer_item_unit_price"></label>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <label for="customer_item_total_price" class="form-label fw-bold">มูลค่ารวม (บาท) <span class="mark">*</span></label>
                                                    <input type="text" id="customer_item_total_price" name="customer_item_total_price" class="form-control" maxlength="20" readonly value="<?=($value['customer_item_total_price'] != '' ? number_format($value['customer_item_total_price'], 2) : '0.00')?>">
                                                    <label id="customer_item_total_price-error" class="mb-2" for="customer_item_total_price"></label>
                                                </div>
                                            </div>

                                            <h5 class="mt-4 text-decoration-underline text-primary">ข้อมูลผู้แก้ไข</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="is_active" class="form-label fw-bold">สถานะการใช้งาน <span class="mark">*</span></label>
                                                    <select id="is_active" name="is_active" class="form-control">
                                                        <option value="Y" <?php if($value['is_active'] == 'Y') {echo "selected";} ?>>เปิดใช้งาน</option>
                                                        <option value="N" <?php if($value['is_active'] == 'N') {echo "selected";} ?>>ปิดใช้งาน</option>
                                                    </select>
                                                    <label id="is_active-error" class="mb-0" for="is_active"></label>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="update_by" class="form-label fw-bold">ผู้แก้ไข <span class="mark">*</span></label>
                                                    <select id="update_by" name="update_by" class="form-control mb-1" readonly>
                                                        <option value="<?=$current_user['user_id']?>" selected><?=$current_user['user_fullname']?></option>
                                                    </select>
                                                    <label id="update_by-error" class="mb-0" for="update_by"></label>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
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
                            <button type="submit" id="editCustomerItemGoods" name="editCustomerItemGoods" class="btn btn-success float-right ml-1"><i data-feather="download"></i> บันทึกการแก้ไข</button>
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
                                            <h5>แก้ไขสินค้าและราคา</h5>
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

<script type="text/javascript">
$(document).ready(function () {

    $('#customer_item_max').on('keyup blur change', function () {
        var item_max = $('#customer_item_max').val();
        var item_unit_price = $('#customer_item_unit_price').val();

        if (item_max != '' && item_unit_price != '') {
            var unit_price = item_unit_price.replace(',', "");
            var total_price = (item_max*unit_price);
        }
        else {
            var total_price = 0;
        }

        var item_min = Math.floor((item_max/2));
        $('#customer_item_min').val(item_min);
        $('#customer_item_total_price').val(total_price.toFixed(2));
        $('#customer_item_total_price').trigger('blur');
    });


    $('#customer_item_unit_price').on({
        keyup: function() {
            formatCurrency($(this));

            var item_max = $('#customer_item_max').val();
            var item_unit_price = $('#customer_item_unit_price').val();

            if (item_max != '' && item_unit_price != '') {
                var unit_price = item_unit_price.replace(',', "");
                var total_price = (item_max*unit_price);
            }
            else {
                var total_price = 0;
            }

            $('#customer_item_total_price').val(total_price.toFixed(2));
            $('#customer_item_total_price').trigger('blur');
        },
        blur: function() { 
            formatCurrency($(this), "blur");
        },
    });

    $('#customer_item_total_price').on({
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
    $("#edit_customer_item_form").validate({
        ignore: ":hidden",
        validClass: "is-valid",
        errorClass: "is-invalid",
        errorElement: "label",
        rules: {
            customer_id: {required: true},
            customer_item_goods: {required: true},
            customer_item_max: {required: true},
            customer_item_min: {required: true},
            customer_item_unit_price: {required: true},
            customer_item_total_price: {required: true},
            is_active: {required: true},
            update_by: {required: true},
        },
        messages: {
            customer_id: {required: 'โปรดระบุ...'},
            customer_item_goods: {required: 'โปรดระบุ...'},
            customer_item_max: {required: 'โปรดระบุ...'},
            customer_item_min: {required: 'โปรดระบุ...'},
            customer_item_unit_price: {required: 'โปรดระบุ...'},
            customer_item_total_price: {required: 'โปรดระบุ...'},
            is_active: {required: 'โปรดระบุ...'},
            update_by: {required: 'โปรดระบุ...'},
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "customer_id" ) {
               error.appendTo('#customer_id-error');
            }

            if (element.attr("name") == "customer_item_goods" ) {
               error.appendTo('#customer_item_goods-error');
            }

            if (element.attr("name") == "customer_item_max" ) {
               error.appendTo('#customer_item_max-error');
            }

            if (element.attr("name") == "customer_item_min" ) {
               error.appendTo('#customer_item_min-error');
            }

            if (element.attr("name") == "customer_item_unit_price" ) {
               error.appendTo('#customer_item_unit_price-error');
            }

            if (element.attr("name") == "customer_item_total_price" ) {
               error.appendTo('#customer_item_total_price-error');
            }

            if (element.attr("name") == "is_active" ) {
               error.appendTo('#is_active-error');
            }

            if (element.attr("name") == "update_by" ) {
               error.appendTo('#update_by-error');
            }
        },  
    });
});
</script>

<?php 
if(isset($_POST['editCustomerItemGoods'])) {
    editCustomerItemGoods();
}
?>