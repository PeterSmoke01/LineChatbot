<?php 
date_default_timezone_set("Asia/Bangkok");
require_once($_SERVER["DOCUMENT_ROOT"].'/consignment/config/include.php');
require_once(home_path().'controller/fn-users.php');
require_once(home_path().'controller/fn-provinces.php');
require_once(home_path().'controller/fn-amphures.php');
require_once(home_path().'controller/fn-districts.php');
require_once(home_path().'controller/fn-warehouse.php');
require_once(home_path().'controller/fn-warehouse-goods.php');
require_once(home_path().'controller/fn-customer-item.php');

function getCustomerAll() {
    global $conn;
    $result = array();

    $select = "*";
    $where = "";
    $groupby = "";
    $orderby = "id";
    $orderby_key = "asc";

    $query = selectCustomer($select, $where, $groupby, $orderby, $orderby_key);
    while($arr = mysqli_fetch_assoc($query)) {
        $data = array(
        'id'                    => $arr['id'],
        'customer_code'         => $arr['customer_code'],
        'customer_name'         => $arr['customer_name'],
        'customer_address'      => $arr['customer_address'],
        'customer_subdistrict'  => $arr['customer_subdistrict'],
        'customer_district'     => $arr['customer_district'],
        'customer_provinces'    => $arr['customer_provinces'],
        'customer_zipcode'      => $arr['customer_zipcode'],
        'customer_tel'          => $arr['customer_tel'],
        'is_active'             => $arr['is_active'],
        'create_by'             => $arr['create_by'],
        'create_at'             => $arr['create_at'],
        'update_by'             => $arr['update_by'], 
        'update_at'             => $arr['update_at']);

        $result[] = $data;
    }

    return $result;
}

function getCustomerList() {
    global $conn;
    $result = array();

    $select = "*";
    $where = "is_active = 'Y'";
    $groupby = "";
    $orderby = "id";
    $orderby_key = "asc";

    $query = selectCustomer($select, $where, $groupby, $orderby, $orderby_key);
    while($arr = mysqli_fetch_assoc($query)) {
        $data = array(
        'id'                    => $arr['id'],
        'customer_code'         => $arr['customer_code'],
        'customer_name'         => $arr['customer_name'],
        'customer_address'      => $arr['customer_address'],
        'customer_subdistrict'  => $arr['customer_subdistrict'],
        'customer_district'     => $arr['customer_district'],
        'customer_provinces'    => $arr['customer_provinces'],
        'customer_zipcode'      => $arr['customer_zipcode'],
        'customer_tel'          => $arr['customer_tel'],
        'is_active'             => $arr['is_active'],
        'create_by'             => $arr['create_by'],
        'create_at'             => $arr['create_at'],
        'update_by'             => $arr['update_by'], 
        'update_at'             => $arr['update_at']);

        $result[] = $data;
    }

    return $result;
}

function getCustomerById($id) {
    global $conn;
    $result = array();
    
    $select = "*";
    $where = "id = '".$id."'";
    $groupby = "";
    $orderby = "id";
    $orderby_key = "asc";

    $query = selectCustomer($select, $where, $groupby, $orderby, $orderby_key);
    while($arr = mysqli_fetch_assoc($query)) {
        $data = array(
        'id'                    => $arr['id'],
        'customer_code'         => $arr['customer_code'],
        'customer_name'         => $arr['customer_name'],
        'customer_address'      => $arr['customer_address'],
        'customer_subdistrict'  => $arr['customer_subdistrict'],
        'customer_district'     => $arr['customer_district'],
        'customer_provinces'    => $arr['customer_provinces'],
        'customer_zipcode'      => $arr['customer_zipcode'],
        'customer_tel'          => $arr['customer_tel'],
        'is_active'             => $arr['is_active'],
        'create_by'             => $arr['create_by'],
        'create_at'             => $arr['create_at'],
        'update_by'             => $arr['update_by'], 
        'update_at'             => $arr['update_at']);

        $result[] = $data;
    }

    return $result;
}

function addCustomer() {
	global $conn;

    $customer_code          = $_POST['customer_code'];
    $customer_name          = $_POST['customer_name'];
    $customer_address       = $_POST['customer_address'];
    $customer_subdistrict   = $_POST['customer_subdistrict'];
    $customer_district      = $_POST['customer_district'];
    $customer_provinces     = $_POST['customer_provinces'];
    $customer_zipcode       = $_POST['customer_zipcode'];
    $customer_tel           = $_POST['customer_tel'];
    $is_active              = $_POST['is_active'];
    $create_by              = $_POST['create_by'];
    $create_at              = date("Y-m-d H:i:s");
    $update_by              = $_POST['create_by'];
    $update_at              = date("Y-m-d H:i:s");

    $col_arr = "customer_code,customer_name,customer_address,customer_subdistrict,customer_district,customer_provinces,customer_zipcode,customer_tel,is_active,create_by,create_at,update_by,update_at";
    $val_arr = "'".$customer_code."','".$customer_name."','".$customer_address."','".$customer_subdistrict."','".$customer_district."','".$customer_provinces."','".$customer_zipcode."','".$customer_tel."','".$is_active."','".$create_by."','".$create_at."','".$update_by."','".$update_at."'";
    $data_insert = insertCustomer($col_arr, $val_arr);

    if ($data_insert) {
        $customer_id = mysqli_insert_id($conn);

        for ($i = 0; $i < count($_POST['wh_code']); $i++) { 
            $wh_code = $_POST['wh_code'][$i];
            $wh_name = $_POST['wh_name'][$i];
            $wh_district = $_POST['wh_district'][$i];
            $wh_provinces = $_POST['wh_provinces'][$i];

            $col_arr_wh = "wh_code,
                           wh_name,
                           wh_district,
                           wh_provinces,
                           customer_id,
                           is_active,
                           create_by,
                           create_at,
                           update_by,
                           update_at";

            $val_arr_wh = "'".$wh_code."',
                            '".$wh_name."',
                            '".$wh_district."',
                            '".$wh_provinces."',
                            '".$customer_id."',
                            '".$is_active."',
                            '".$create_by."',
                            '".$create_at."',
                            '".$update_by."',
                            '".$update_at."'";
            $data_insert_wh = insertWarehouse($col_arr_wh, $val_arr_wh);
        }

        for ($i = 0; $i < count($_POST['customer_item_goods']); $i++) { 
            $customer_item_cuscode = $_POST['customer_item_cuscode'][$i];
            $customer_item_goods = $_POST['customer_item_goods'][$i];
            $customer_item_min = $_POST['customer_item_min'][$i];
            $customer_item_max = $_POST['customer_item_max'][$i];
            $customer_item_unit_price = floatval(preg_replace("/[^-0-9\.]/","", $_POST['contract_item_unit_price'][$i]));
            $customer_item_total_price = floatval(preg_replace("/[^-0-9\.]/","", $_POST['contract_item_total_price'][$i]));

            $col_arr_item = "customer_id,
                            customer_item_cuscode,
                            customer_item_goods,
                            customer_item_min,
                            customer_item_max,
                            customer_item_unit_price,
                            customer_item_total_price,
                            is_active,
                            create_by,
                            create_at,
                            update_by,
                            update_at";

            $val_arr_item = "'".$customer_id."',
                            '".$customer_item_cuscode."',
                            '".$customer_item_goods."',
                            '".$customer_item_min."',
                            '".$customer_item_max."',
                            '".$customer_item_unit_price."',
                            '".$customer_item_total_price."',
                            '".$is_active."',
                            '".$create_by."',
                            '".$create_at."',
                            '".$update_by."',
                            '".$update_at."'";
            $data_insert_item = insertCustomerItem($col_arr_item, $val_arr_item);
        }

    	echo '<script>
            Swal.fire({
                title: "สำเร็จ!",
                text: "เพิ่มลูกค้าสำเร็จ",
                icon: "success",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/detail.php?id='.$customer_id.'";
            });
            </script>';
    }
    else {
    	echo '<script>
            Swal.fire({
                title: "ไม่สำเร็จ!",
                text: "เพิ่มลูกค้าไม่สำเร็จ",
                icon: "error",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/";
            });
            </script>';
    }
}

function editCustomer() {
	global $conn;

	$customer_id            = $_POST['customer_id'];
    $customer_code          = $_POST['customer_code'];
    $customer_name          = $_POST['customer_name'];
    $customer_address       = $_POST['customer_address'];
    $customer_subdistrict   = $_POST['customer_subdistrict'];
    $customer_district      = $_POST['customer_district'];
    $customer_provinces     = $_POST['customer_provinces'];
    $customer_zipcode       = $_POST['customer_zipcode'];
    $customer_tel           = $_POST['customer_tel'];
    $is_active              = $_POST['is_active'];
    $create_by              = $_POST['update_by'];
    $create_at              = date("Y-m-d H:i:s");
    $update_by              = $_POST['update_by'];
    $update_at              = date("Y-m-d H:i:s");

    $set_arr = "customer_code = '".$customer_code."',
                customer_name = '".$customer_name."',
                customer_address = '".$customer_address."',
                customer_subdistrict = '".$customer_subdistrict."',
                customer_district = '".$customer_district."',
                customer_provinces = '".$customer_provinces."',
                customer_zipcode = '".$customer_zipcode."',
                customer_tel = '".$customer_tel."',
    			is_active = '".$is_active."', 
    			update_by = '".$update_by."', 
    			update_at = '".$update_at."'";

    $where_arr = "id = '".$customer_id."'";
    $data_update = updateCustomer($set_arr, $where_arr);

    if ($data_update) {
    	echo '<script>
            Swal.fire({
                title: "สำเร็จ!",
                text: "แก้ไขข้อมูลลูกค้าสำเร็จ",
                icon: "success",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/detail.php?id='.$customer_id.'";
            });
            </script>';
    }
    else {
    	echo '<script>
            Swal.fire({
                title: "ไม่สำเร็จ!",
                text: "แก้ไขข้อมูลลูกค้าไม่สำเร็จ",
                icon: "error",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/";
            });
            </script>';
    }
}

function addCustomerWarehouse() {
    global $conn;

    $wh_code            = $_POST['wh_code'];
    $wh_name            = $_POST['wh_name'];
    $wh_district        = $_POST['wh_district'];
    $wh_provinces       = $_POST['wh_provinces'];
    $customer_id        = $_POST['customer_id'];
    $is_active          = $_POST['is_active'];
    $create_by          = $_POST['create_by'];
    $create_at          = date("Y-m-d H:i:s");
    $update_by          = $_POST['create_by'];
    $update_at          = date("Y-m-d H:i:s");

    $col_arr = "wh_code,
                wh_name,
                wh_district,
                wh_provinces,
                customer_id,
                is_active,
                create_by,
                create_at,
                update_by,
                update_at";

    $val_arr = "'".$wh_code."',
                '".$wh_name."',
                '".$wh_district."',
                '".$wh_provinces."',
                '".$customer_id."',
                '".$is_active."',
                '".$create_by."',
                '".$create_at."',
                '".$update_by."',
                '".$update_at."'";

    $data_insert = insertWarehouse($col_arr, $val_arr);

    if ($data_insert) {
        $wh_id = mysqli_insert_id($conn);

        echo '<script>
            Swal.fire({
                title: "สำเร็จ!",
                text: "เพิ่มคลังสินค้าสำเร็จ",
                icon: "success",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/detail.php?id='.$customer_id.'";
            });
            </script>';
    }
    else {
        echo '<script>
            Swal.fire({
                title: "ไม่สำเร็จ!",
                text: "เพิ่มคลังสินค้าไม่สำเร็จ",
                icon: "error",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/";
            });
            </script>';
    }
}

function editCustomerWarehouse() {
    global $conn;

    $wh_id              = $_POST['wh_id'];
    $wh_code            = $_POST['wh_code'];
    $wh_name            = $_POST['wh_name'];
    $wh_district        = $_POST['wh_district'];
    $wh_provinces       = $_POST['wh_provinces'];
    $customer_id        = $_POST['customer_id'];
    $is_active          = $_POST['is_active'];
    $update_by          = $_POST['update_by'];
    $update_at          = date("Y-m-d H:i:s");

    $set_arr = "wh_code = '".$wh_code."',
                wh_name = '".$wh_name."',
                wh_district = '".$wh_district."',
                wh_provinces = '".$wh_provinces."',
                customer_id = '".$customer_id."',
                is_active = '".$is_active."', 
                update_by = '".$update_by."', 
                update_at = '".$update_at."'";

    $where_arr = "id = '".$wh_id."'";
    $data_update = updateWarehouse($set_arr, $where_arr);

    if ($data_update) {

        echo '<script>
            Swal.fire({
                title: "สำเร็จ!",
                text: "แก้ไขคลังสินค้าสำเร็จ",
                icon: "success",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/detail.php?id='.$customer_id.'";
            });
            </script>';
    }
    else {
        echo '<script>
            Swal.fire({
                title: "ไม่สำเร็จ!",
                text: "แก้ไขคลังสินค้าไม่สำเร็จ",
                icon: "error",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/";
            });
            </script>';
    }
}

function addCustomerItemGoods() {
    global $conn;

    $customer_id                    = $_POST['customer_id'];
    $customer_item_cuscode          = $_POST['customer_item_cuscode'];
    $customer_item_goods            = $_POST['customer_item_goods'];
    $customer_item_max              = $_POST['customer_item_max'];
    $customer_item_min              = $_POST['customer_item_min'];
    $customer_item_unit_price       = floatval(preg_replace("/[^-0-9\.]/","", $_POST['customer_item_unit_price']));
    $customer_item_total_price      = floatval(preg_replace("/[^-0-9\.]/","", $_POST['customer_item_total_price']));
    $is_active                      = $_POST['is_active'];
    $create_by                      = $_POST['create_by'];
    $create_at                      = date("Y-m-d H:i:s");
    $update_by                      = $_POST['create_by'];
    $update_at                      = date("Y-m-d H:i:s");


    $col_arr_item = "customer_id,
                     customer_item_cuscode,
                     customer_item_goods,
                     customer_item_min,
                     customer_item_max,
                     customer_item_unit_price,
                     customer_item_total_price,
                     is_active,
                     create_by,
                     create_at,
                     update_by,
                     update_at";

    $val_arr_item = "'".$customer_id."',
                    '".$customer_item_cuscode."',
                    '".$customer_item_goods."',
                    '".$customer_item_min."',
                    '".$customer_item_max."',
                    '".$customer_item_unit_price."',
                    '".$customer_item_total_price."',
                    '".$is_active."',
                    '".$create_by."',
                    '".$create_at."',
                    '".$update_by."',
                    '".$update_at."'";
    $data_insert_item = insertCustomerItem($col_arr_item, $val_arr_item);

    if ($data_insert_item) {

        echo '<script>
            Swal.fire({
                title: "สำเร็จ!",
                text: "เพิ่มสินค้าและราคาสำเร็จ",
                icon: "success",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/detail.php?id='.$customer_id.'";
            });
            </script>';
    }
    else {
        echo '<script>
            Swal.fire({
                title: "ไม่สำเร็จ!",
                text: "เพิ่มสินค้าและราคาไม่สำเร็จ",
                icon: "error",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/";
            });
            </script>';
    }
}

function editCustomerItemGoods() {
    global $conn;

    $customer_id                    = $_POST['customer_id'];
    $customer_item_id               = $_POST['customer_item_id'];
    $customer_item_cuscode          = $_POST['customer_item_cuscode'];
    $customer_item_goods            = $_POST['customer_item_goods'];
    $customer_item_max              = $_POST['customer_item_max'];
    $customer_item_min              = $_POST['customer_item_min'];
    $customer_item_unit_price       = floatval(preg_replace("/[^-0-9\.]/","", $_POST['customer_item_unit_price']));
    $customer_item_total_price      = floatval(preg_replace("/[^-0-9\.]/","", $_POST['customer_item_total_price']));
    $is_active                      = $_POST['is_active'];
    $update_by                      = $_POST['update_by'];
    $update_at                      = date("Y-m-d H:i:s");

    $set_arr = "customer_item_cuscode = '".$customer_item_cuscode."',
                customer_item_goods = '".$customer_item_goods."',
                customer_item_min = '".$customer_item_min."',
                customer_item_max = '".$customer_item_max."',
                customer_item_unit_price = '".$customer_item_unit_price."',
                customer_item_total_price = '".$customer_item_total_price."',
                is_active = '".$is_active."', 
                update_by = '".$update_by."', 
                update_at = '".$update_at."'";

    $where_arr = "id = '".$customer_item_id."'";
    $data_update = updateCustomerItem($set_arr, $where_arr);

    if ($data_update) {

        echo '<script>
            Swal.fire({
                title: "สำเร็จ!",
                text: "แก้ไขสินค้าและราคาสำเร็จ",
                icon: "success",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/detail.php?id='.$customer_id.'";
            });
            </script>';
    }
    else {
        echo '<script>
            Swal.fire({
                title: "ไม่สำเร็จ!",
                text: "แก้ไขสินค้าและราคาไม่สำเร็จ",
                icon: "error",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/customer/";
            });
            </script>';
    }
}



function selectCustomer($select = '', $where = '', $groupby = '', $orderby = '', $orderby_key) {
    global $conn;
    if (!empty($where)) { $where_all = "WHERE $where"; } 
    else { $where_all = ""; }

    if (!empty($groupby)) { $groupby_all = "GROUP BY $groupby"; }
    else { $groupby_all = ""; }

    if (!empty($orderby)) { $orderby_all = "ORDER BY $orderby $orderby_key"; }
    else { $orderby_all = ""; }

    $sql = "SELECT $select FROM customer $where_all $groupby_all $orderby_all";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function joinCustomer($select = '', $table = '', $join = '', $where = '', $groupby = '', $orderby = '', $orderby_key = '') {
    global $conn;
    if (!empty($where)) { $where_all = "WHERE $where"; } 
    else { $where_all = ""; }

    if (!empty($groupby)) { $groupby_all = "GROUP BY $groupby"; }
    else { $groupby_all = ""; }

    if (!empty($orderby)) { $orderby_all = "ORDER BY $orderby $orderby_key"; }
    else { $orderby_all = ""; }

    $sql = "SELECT $select FROM $table $join $where_all $groupby_all $orderby_all";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function deleteCustomer($key, $id) {
    global $conn;
    $sql = "DELETE FROM customer WHERE $key ='$id'";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function insertCustomer($col_arr, $val_arr) {
    global $conn;
    $sql = "INSERT INTO customer($col_arr) VALUES ($val_arr)";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function updateCustomer($set_arr, $where_arr) {
    global $conn;
    $sql = "UPDATE customer SET $set_arr WHERE $where_arr";
    $result = mysqli_query($conn, $sql);

    return $result;
}

?>