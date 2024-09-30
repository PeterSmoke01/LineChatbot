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

$allrow = count(getCustomerById($id));

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
                            <h5 class="m-b-10"><i data-feather="info"></i> รายละเอียดลูกค้า</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">ลูกค้า</li>
                            <li class="breadcrumb-item">รายละเอียดลูกค้า</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-3">
                <a href="<?=home_url()?>page/customer/" class="btn btn-secondary mobile-d-block mb-1"><i data-feather="list"></i> ลูกค้าทั้งหมด</a>
                <a href="<?=home_url()?>page/customer/create.php" class="btn btn-primary mobile-d-block mb-1"><i data-feather="plus"></i> เพิ่มลูกค้า</a>
                <?php if ($allrow != 0) { ?>
                    <a href="<?=home_url()?>page/customer/edit.php?id=<?=$id?>" class="btn btn-warning mobile-d-block mb-1"><i data-feather="edit"></i> แก้ไขข้อมูลลูกค้า</a>

                    <?php
                    foreach (getCustomerById($id) as $key2 => $value2) {
                    if ($value2['is_active'] == 'Y') {
                        echo '<a href="javascript:void(0);" class="btn btn-danger mobile-d-block mb-1" onclick="updateIsActive('.$value2['id'].', \''.$value2['customer_name'].'\', '.$current_user['user_id'].', \'N\', \'customer\')"><i class="fas fa-ban"></i> ปิดใช้งาน</a>';
                    }
                    elseif ($value2['is_active'] == 'N') {
                        echo '<a href="javascript:void(0);" class="btn btn-success mobile-d-block mb-1" onclick="updateIsActive('.$value2['id'].', \''.$value2['customer_name'].'\', '.$current_user['user_id'].', \'Y\', \'customer\')"><i class="fas fa-check"></i> เปิดใช้งาน</a>';
                    }
                    }
                    ?>
                <?php } ?>
            </div>
            <?php 
            if ($allrow != 0) {
                foreach (getCustomerById($id) as $key => $value) {
            ?>
                <div class="col-xl-12 col-md-12">
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
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">รหัสลูกค้า</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2"><?=$value['customer_code']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">ชื่อลูกค้า</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2"><?=$value['customer_name']?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">ที่อยู่</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2"><?=$value['customer_address']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">แขวง/ตำบล</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2">
                                            <?php
                                            if (count(getDistrictsById($value['customer_subdistrict'])) != 0) {
                                                foreach (getDistrictsById($value['customer_subdistrict']) as $key_subdistrict => $value_subdistrict) {
                                                    echo $value_subdistrict['name_th'];
                                                }
                                            } 
                                            else {
                                                echo '-';
                                            }
                                            ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">เขต/อำเภอ</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2">
                                            <?php
                                            if (count(getAmphuresById($value['customer_district'])) != 0) {
                                                foreach (getAmphuresById($value['customer_district']) as $key_district => $value_district) {
                                                    echo $value_district['name_th'];
                                                }
                                            } 
                                            else {
                                                echo '-';
                                            }
                                            ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">จังหวัด</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2">
                                            <?php
                                            if (count(getProvincesById($value['customer_provinces'])) != 0) {
                                                foreach (getProvincesById($value['customer_provinces']) as $key_provinces => $value_provinces) {
                                                    echo $value_provinces['name_th'];
                                                }
                                            } 
                                            else {
                                                echo '-';
                                            }
                                            ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">รหัสไปรษณีย์</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2"><?=$value['customer_zipcode']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">หมายเลขโทรศัพท์</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2"><?=$value['customer_tel']?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">สถานะการใช้งาน</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2">
                                            <?php 
                                            if ($value['is_active'] == 'Y') {
                                                echo '<span class="badge bg-success fw-normal" style="font-size: 14px;">เปิดใช้งาน</span>';
                                            }
                                            elseif ($value['is_active'] == 'N') {
                                                echo '<span class="badge bg-danger fw-normal" style="font-size: 14px;">ปิดใช้งาน</span>';
                                            }
                                            ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">ผู้บันทึก</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2">
                                            <?php 
                                            foreach (getUsersById($value['create_by']) as $key_user => $value_user) {
                                                echo $value_user['user_fullname'];
                                            }
                                            ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">วันที่บันทึก</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2"><?=date_format(date_create($value['create_at']), 'd-m-Y H:i:s')?> (<?=getTimeAgo($value['create_at'])?>)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">ผู้แก้ไข</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2">
                                            <?php 
                                            foreach (getUsersById($value['update_by']) as $key_user => $value_user) {
                                                echo $value_user['user_fullname'];
                                            }
                                            ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                            <p class="fw-bold mb-2">วันที่แก้ไข</p>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-6">
                                            <p class="fw-normal mb-2"><?=date_format(date_create($value['update_at']), 'd-m-Y H:i:s')?> (<?=getTimeAgo($value['update_at'])?>)</p>
                                        </div>
                                    </div>
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
                                    <h5>ข้อมูลคลังสินค้า</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="fw-bold mb-2">รายการคลังสินค้าทั้งหมด จำนวน <span class="text-primary"><?=count(getWarehouseByCustomerId($value['id']))?></span> รายการ</p>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="table-responsive">
                                        <table id="table-warehouse" class="table table-hover dataTable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-md">รหัสคลังสินค้า</th>
                                                    <th class="text-md">ชื่อคลังสินค้า</th>
                                                    <th class="text-md">ที่ตั้งคลังสินค้า</th>
                                                    <th class="text-md">สถานะการใช้งาน</th>
                                                    <th class="text-md">เมนู</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            foreach (getWarehouseByCustomerId($value['id']) as $key_warehouse => $value_warehouse) {
                                            ?>
                                                    <tr>
                                                        <td><?=$value_warehouse['wh_code']?></td>
                                                        <td><?=$value_warehouse['wh_name']?></td>
                                                        <td>
                                                        <?php
                                                            $wh_district = '';
                                                            $wh_provinces = '';
                                                            foreach (getAmphuresById($value_warehouse['wh_district']) as $key_district => $value_district) {
                                                                $wh_district = $value_district['name_th']." ";
                                                            }


                                                            foreach (getProvincesById($value_warehouse['wh_provinces']) as $key_provinces => $value_provinces) {
                                                                $wh_provinces = $value_provinces['name_th'];
                                                            }

                                                            echo $wh_district." ".$wh_provinces;
                                                        ?>
                                                        </td>
                                                        <td>
                                                        <?php 
                                                        if ($value_warehouse['is_active'] == 'Y') {
                                                            echo '<span class="badge bg-success fw-normal text-md">เปิดใช้งาน</span>';
                                                        }
                                                        elseif ($value_warehouse['is_active'] == 'N') {
                                                            echo '<span class="badge bg-danger fw-normal text-md">ปิดใช้งาน</span>';
                                                        }
                                                        ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?=home_url()?>page/customer/edit-warehouse.php?id=<?=$value_warehouse['id']?>" class="btn btn-icon btn-warning btn-sm fw-normal" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"><i class="ti-pencil"></i></a>

                                                            <?php 
                                                            if ($value_warehouse['is_active'] == 'Y') {
                                                                echo '<a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm mr-1" onclick="updateIsActive('.$value_warehouse['id'].', \''.$value_warehouse['wh_name'].'\', '.$current_user['user_id'].', \'N\', \'warehouse\')" data-toggle="tooltip" data-placement="top" title="ปิดใช้งาน"><i class="fas fa-ban"></i></a>';
                                                            }
                                                            elseif ($value_warehouse['is_active'] == 'N') {
                                                                echo '<a href="javascript:void(0);" class="btn btn-icon btn-success btn-sm mr-1" onclick="updateIsActive('.$value_warehouse['id'].', \''.$value_warehouse['wh_name'].'\', '.$current_user['user_id'].', \'Y\', \'warehouse\')" data-toggle="tooltip" data-placement="top" title="เปิดใช้งาน"><i class="fas fa-check"></i></a>';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                            } 
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <a href="<?=home_url()?>page/customer/create-warehouse.php?id=<?=$value['id']?>" class="btn btn-primary fw-normal"><i class="fas fa-plus"></i> เพิ่มคลังสินค้า</a>
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
                                    <h5>ข้อมูลสินค้าและราคา</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="fw-bold mb-2">รายการสินค้าและราคาทั้งหมด จำนวน <span class="text-primary"><?=count(getCustomerItemByCustomerId($value['id']))?></span> รายการ</p>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="table-responsive">
                                        <table id="table-customer-item" class="table table-hover dataTable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-md">รหัสสินค้า</th>
                                                    <th class="text-md">รายการสินค้า</th>
                                                    <th class="text-md">จำนวนตั้งต้น</th>
                                                    <th class="text-md">จำนวนต่ำสุด</th>
                                                    <th class="text-md">ราคาต่อหน่วย</th>
                                                    <th class="text-md">มูลค่ารวม</th>
                                                    <th class="text-md">สถานะ</th>
                                                    <th class="text-md">เมนู</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            foreach (getCustomerItemByCustomerId($value['id']) as $key_customer_item => $value_customer_item) {
                                                    $goods_code = '';
                                                    $goods_name = '';
                                                    foreach (getGoodsById($value_customer_item['customer_item_goods']) as $key_goods => $value_goods) {
                                                        $goods_code = $value_goods['goods_code'];
                                                        $goods_name = $value_goods['goods_name'];
                                                    }
                                            ?>
                                                    <tr>
                                                        <td><?=$goods_code?></td>
                                                        <td><?=$goods_name?></td>
                                                        <td><?=$value_customer_item['customer_item_max']?></td>
                                                        <td><?=$value_customer_item['customer_item_min']?></td>
                                                        <td><?=($value_customer_item['customer_item_unit_price'] != '' ? number_format($value_customer_item['customer_item_unit_price'], 2) : '0.00')?></td>
                                                        <td><?=($value_customer_item['customer_item_total_price'] != '' ? number_format($value_customer_item['customer_item_total_price'], 2) : '0.00')?></td>
                                                        <td>
                                                        <?php 
                                                            if ($value_customer_item['is_active'] == 'Y') {
                                                                echo '<span class="badge bg-success fw-normal text-md">เปิดใช้งาน</span>';
                                                            }
                                                            elseif ($value_customer_item['is_active'] == 'N') {
                                                                echo '<span class="badge bg-danger fw-normal text-md">ปิดใช้งาน</span>';
                                                            }
                                                        ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?=home_url()?>page/customer/edit-item.php?id=<?=$value_customer_item['id']?>" class="btn btn-warning btn-sm fw-normal" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ"><i class="ti-pencil"></i></a>

                                                            <?php 
                                                            if ($value_customer_item['is_active'] == 'Y') {
                                                                echo '<a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm mr-1" onclick="updateIsActive('.$value_customer_item['id'].', \''.$goods_code.'\', '.$current_user['user_id'].', \'N\', \'customer_item\')" data-toggle="tooltip" data-placement="top" title="ปิดใช้งาน"><i class="fas fa-ban"></i></a>';
                                                            }
                                                            elseif ($value_customer_item['is_active'] == 'N') {
                                                                echo '<a href="javascript:void(0);" class="btn btn-icon btn-success btn-sm mr-1" onclick="updateIsActive('.$value_customer_item['id'].', \''.$goods_code.'\', '.$current_user['user_id'].', \'Y\', \'customer_item\')" data-toggle="tooltip" data-placement="top" title="เปิดใช้งาน"><i class="fas fa-check"></i></a>';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                            } 
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <a href="<?=home_url()?>page/customer/create-item.php?id=<?=$value['id']?>" class="btn btn-primary fw-normal"><i class="fas fa-plus"></i> เพิ่มสินค้าและราคา</a>
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
                                    <h5>รายละเอียดลูกค้า</h5>
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
    $('#table-warehouse').DataTable();
    $('#table-customer-item').DataTable();

    function updateIsActive(data_id, data_value, update_by, is_active, db_name) {
        var active_status = "";

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