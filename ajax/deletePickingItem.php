<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/consignment/config/include.php');
global $conn;

if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];

    $sql1 = "DELETE FROM question_ans WHERE id ='$id'";
    $query1 = mysqli_query($conn, $sql1);
    echo 'true';
    // if ($query1) {
    //     $sql2 = "DELETE FROM stock WHERE stock_doc_id ='$picking_id' and stock_doc_type = 'picking' and stock_doc_item_id = '$picking_item_id' and stock_serial = '$picking_serial' and stock_goods = '$picking_goods_id' and stock_flag = '0'";
    //     $query2 = mysqli_query($conn, $sql2);
        
    //     echo 'true';
    // }
    // else {
    //     echo 'false';
    // }
} 
else {
    echo 'false';
}

?>