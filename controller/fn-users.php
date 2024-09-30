<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/hr-linebot/config/include.php');
date_default_timezone_set("Asia/Bangkok");

function getUsersAll() {
    global $conn;
    $result = array();

    $select = "*";
    $where = "";
    $groupby = "";
    $orderby = "id";
    $orderby_key = "asc";

    $query = selectUsers($select, $where, $groupby, $orderby, $orderby_key);
    while($arr = mysqli_fetch_assoc($query)) {
        $data = array(
        'id'                   => $arr['id'],
        'company'              => $arr['company'],
        'title'                => $arr['title'], 
        'subtitle'             => $arr['subtitle'],
        'description'          => $arr['description'], 
        // 'is_active'         => $arr['is_active'],
        // 'create_by'         => $arr['create_by'],
        // 'create_at'         => $arr['create_at'],
        // 'update_by'         => $arr['update_by'], 
        // 'update_at'         => $arr['update_at']
        );

        $result[] = $data;
    }

    return $result;
}

function getUsersList() {
    global $conn;
    $result = array();

    $select = "*";
    $where = "is_active = 'Y'";
    $groupby = "";
    $orderby = "id";
    $orderby_key = "asc";

    $query = selectUsers($select, $where, $groupby, $orderby, $orderby_key);
    while($arr = mysqli_fetch_assoc($query)) {
        $data = array(
        'id'                => $arr['id'],
        'user_fullname'     => $arr['user_fullname'], 
        'user_email'        => $arr['user_email'], 
        'user_username'     => $arr['user_username'],
        'create_by'         => $arr['create_by'],
        'create_at'         => $arr['create_at'],
        'update_by'         => $arr['update_by'], 
        'update_at'         => $arr['update_at']);

        $result[] = $data;
    }

    return $result;
}

function getUsersById($id) {
    global $conn;
    $result = array();

    $select = "*";
    $where = "id = '".$id."'";
    $groupby = "";
    $orderby = "id";
    $orderby_key = "asc";

    $query = selectUsers($select, $where, $groupby, $orderby, $orderby_key);
    while($arr = mysqli_fetch_assoc($query)) {
        $data = array(
        'id'                => $arr['id'],
        'company'           => $arr['company'],
        'title'             => $arr['title'], 
        'subtitle'          => $arr['subtitle'], 
        'description'       => $arr['description'], );
        

        $result[] = $data;
    }

    return $result;
}

function addRule() {
    global $conn;
    $company               = $_POST['company'];
    $title                 = $_POST['title'];
    $subtitle              = $_POST['subtitle'];
    $description           = $_POST['description'];

    // $user_fullname      = $_POST['user_fullname'];
    // $user_email         = $_POST['user_email'];
    // $user_username      = $_POST['user_username'];
    // $create_by          = $_POST['create_by'];
    // $create_at          = date("Y-m-d H:i:s");
    // $update_by          = $_POST['create_by'];
    // $update_at          = date("Y-m-d H:i:s");

    $col_arr = "title,subtitle,description";
    $val_arr = "'".$title."','".$subtitle."','".$description."'";
    // $col_arr = "user_fullname,user_email,user_username,create_by,create_at,update_by,update_at";
    // $val_arr = "'".$user_fullname."','".$user_email."','".$user_username."','".$create_by."','".$create_at."','".$update_by."','".$update_at."'";
    $data_insert = insertUsers($col_arr, $val_arr);

    if ($data_insert) {
        $id = mysqli_insert_id($conn);

        echo '<script>
            Swal.fire({
                title: "สำเร็จ!",
                text: "เพิ่มผู้ใช้งานสำเร็จ",
                icon: "success",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/users";
            });
            </script>';
    }
    else {
        echo '<script>
            Swal.fire({
                title: "ไม่สำเร็จ!",
                text: "เพิ่มผู้ใช้งานไม่สำเร็จ",
                icon: "error",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/users/";
            });
            </script>';
    }
}


function editUsers() {
    global $conn;
    $id                    = $_POST['id'];
    $company               = $_POST['company'];
    $title                 = $_POST['title'];
    $subtitle              = $_POST['subtitle'];
    $description           = $_POST['description'];
    // $user_id            = $_POST['user_id'];
    // $user_fullname      = $_POST['user_fullname'];
    // $user_email         = $_POST['user_email'];
    // $is_active          = $_POST['is_active'];
    // $update_by          = $_POST['update_by'];
    // $update_at          = date("Y-m-d H:i:s");
    $set_arr = "company = '".$company."',
                title = '".$title."',
                subtitle = '".$subtitle."',
                description = '".$description."'";


    // $set_arr = "user_fullname = '".$user_fullname."',
    //             user_email = '".$user_email."',
    //             update_by = '".$update_by."', 
    //             update_at = '".$update_at."'";

    $where_arr = "id = '".$id."'";
    $data_update = updateUsers($set_arr, $where_arr);

    if ($data_update) {
        echo '<script>
            Swal.fire({
                title: "สำเร็จ!",
                text: "แก้ไขผู้ใช้งานสำเร็จ",
                icon: "success",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/users";
            });
            </script>';
    }
    else {
        echo '<script>
            Swal.fire({
                title: "ไม่สำเร็จ!",
                text: "แก้ไขผู้ใช้งานไม่สำเร็จ",
                icon: "error",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/users/";
            });
            </script>';
    }
}

function changePassword() {
    global $conn;

    $user_id                = $_POST['user_id'];
    $repass_username        = $_POST['repass_username'];
    $repass_password_old    = md5($_POST['repass_password_old']);
    $repass_password        = md5($_POST['repass_password']);
    $repass_at              = date("Y-m-d H:i:s");
    $is_login               = 'N';
    $is_last_login          = '0000-00-00 00:00:00';

    if (count(getUsersById($user_id)) != 0) {
        foreach (getUsersById($user_id) as $key_user => $value_user) {
            if ($value_user['user_password'] == $repass_password_old) {

                $set_arr = "user_password = '".$repass_password."',
                            is_login = '".$is_login."',
                            is_last_login = '".$is_last_login."',
                            is_change_pwd = '".$repass_at."'";
                $where_arr = "id = '".$user_id."'";
                $data_update = updateUsers($set_arr, $where_arr);

                if ($data_update) {
                    $repass_type = 'change password';
                    $repass_msg = 'เปลี่ยนรหัสผ่านสำเร็จ';

                    $col_user_log = "log_type, log_by, log_at, log_msg";
                    $val_user_log = "'".$repass_type."','".$user_id."','".$repass_at."','".$repass_msg."'";
                    // $insert_user_log = insertUserLog($col_user_log, $val_user_log);

                    echo '<script>
                        Swal.fire({
                            title: "เปลี่ยนรหัสผ่านสำเร็จ!",
                            text: "สามารถใช้รหัสผ่านใหม่ล็อกอินเข้าใช้งานระบบได้แล้ว กรุณาล็อกเอาท์ออกจากระบบ",
                            icon: "info",
                            showCancelButton: false,
                            confirmButtonColor: "#1690ed",
                            confirmButtonText: "ออกจากระบบ",
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "'.home_url().'logout.php?uid='.$user_id.'";
                            }
                        });
                        </script>';
                }
                else {
                    $repass_type = 'change password';
                    $repass_msg = 'เปลี่ยนรหัสผ่านไม่สำเร็จ ระบบไม่สามารถเปลี่ยนรหัสผ่านให้ได้';

                    $col_user_log = "log_type, log_by, log_at, log_msg";
                    $val_user_log = "'".$repass_type."','".$user_id."','".$repass_at."','".$repass_msg."'";
                    // $insert_user_log = insertUserLog($col_user_log, $val_user_log);

                    echo '<script>
                        Swal.fire({
                            title: "เปลี่ยนรหัสผ่านไม่สำเร็จ!",
                            text: "ระบบไม่สามารถเปลี่ยนรหัสผ่านให้ได้ กรุณาติดต่อแอดมิน",
                            icon: "error",
                            confirmButtonColor: "#1690ed",
                        }).then(function() {
                            window.location = "'.home_url().'page/account/";
                        });
                        </script>';
                }
            }
            else {
                $repass_type = 'change password';
                $repass_msg = 'เปลี่ยนรหัสผ่านไม่สำเร็จ เนื่องจากระบุรหัสผ่านเดิมไม่ถูกต้อง';

                $col_user_log = "log_type, log_by, log_at, log_msg";
                $val_user_log = "'".$repass_type."','".$user_id."','".$repass_at."','".$repass_msg."'";
                // $insert_user_log = insertUserLog($col_user_log, $val_user_log);

                echo '<script>
                    Swal.fire({
                        title: "เปลี่ยนรหัสผ่านไม่สำเร็จ!",
                        text: "เนื่องจากระบุรหัสผ่านเดิมไม่ถูกต้อง",
                        icon: "warning",
                        confirmButtonColor: "#1690ed",
                    }).then(function() {
                        window.location = "'.home_url().'page/account/";
                    });
                </script>';
            }
        }
    }
    else {
        $repass_type = 'change password';
        $repass_msg = 'เปลี่ยนรหัสผ่านไม่สำเร็จ ไม่มีชื่อผู้ใช้งานนี้ในระบบแล้ว';

        $col_user_log = "log_type, log_by, log_at, log_msg";
        $val_user_log = "'".$repass_type."','".$user_id."','".$repass_at."','".$repass_msg."'";
        // $insert_user_log = insertUserLog($col_user_log, $val_user_log);

        echo '<script>
            Swal.fire({
                title: "เปลี่ยนรหัสผ่านไม่สำเร็จ!",
                text: "ไม่มีชื่อผู้ใช้งานนี้ในระบบแล้ว",
                icon: "warning",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/account/";
            });
        </script>';
    }
}

function resetPassword() {
    global $conn;

    $user_id                = $_POST['user_id'];
    $repass_username        = $_POST['repass_username'];
    $repass_password        = md5($_POST['repass_password']);
    $repass_at              = date("Y-m-d H:i:s");
    $is_login               = 'N';
    $is_last_login          = '0000-00-00 00:00:00';

    if (count(getUsersById($user_id)) != 0) {
        foreach (getUsersById($user_id) as $key_user => $value_user) {
            $set_arr = "user_password = '".$repass_password."',
                        is_login = '".$is_login."',
                        is_last_login = '".$is_last_login."',
                        is_change_pwd = '".$repass_at."'";
            $where_arr = "id = '".$user_id."'";
            $data_update = updateUsers($set_arr, $where_arr);

            if ($data_update) {
                $repass_type = 'reset password';
                $repass_msg = 'รีเซ็ตรหัสผ่านใหม่สำเร็จ';

                $col_user_log = "log_type, log_by, log_at, log_msg";
                $val_user_log = "'".$repass_type."','".$user_id."','".$repass_at."','".$repass_msg."'";
                // $insert_user_log = insertUserLog($col_user_log, $val_user_log);

                echo '<script>
                    Swal.fire({
                        title: "รีเซ็ตรหัสผ่านสำเร็จ!",
                        text: "ระบบดำเนินการรีเซ็ตรหัสผ่านสำเร็จ",
                        icon: "success",
                        confirmButtonColor: "#1690ed",
                    }).then(function() {
                        window.location = "'.home_url().'page/users/detail.php?id='.$user_id.'";
                    });
                    </script>';
            }
            else {
                $repass_type = 'reset password';
                $repass_msg = 'รีเซ็ตรหัสผ่านใหม่สำเร็จ ระบบไม่สามารถเปลี่ยนรหัสผ่านให้ได้';

                $col_user_log = "log_type, log_by, log_at, log_msg";
                $val_user_log = "'".$repass_type."','".$user_id."','".$repass_at."','".$repass_msg."'";
                // $insert_user_log = insertUserLog($col_user_log, $val_user_log);

                echo '<script>
                    Swal.fire({
                        title: "รีเซ็ตรหัสผ่านไม่สำเร็จ!",
                        text: "ระบบไม่สามารถเปลี่ยนรหัสผ่านให้ได้ กรุณาติดต่อแอดมิน",
                        icon: "error",
                        confirmButtonColor: "#1690ed",
                    }).then(function() {
                        window.location = "'.home_url().'page/users/detail.php?id='.$user_id.'";
                    });
                    </script>';
            }
        }
    }
    else {
        $repass_type = 'reset password';
        $repass_msg = 'รีเซ็ตรหัสผ่านใหม่สำเร็จ ไม่มีชื่อผู้ใช้งานนี้ในระบบแล้ว';

        $col_user_log = "log_type, log_by, log_at, log_msg";
        $val_user_log = "'".$repass_type."','".$user_id."','".$repass_at."','".$repass_msg."'";
        // $insert_user_log = insertUserLog($col_user_log, $val_user_log);

        echo '<script>
            Swal.fire({
                title: "รีเซ็ตรหัสผ่านไม่สำเร็จ!",
                text: "ไม่มีชื่อผู้ใช้งานนี้ในระบบแล้ว",
                icon: "warning",
                confirmButtonColor: "#1690ed",
            }).then(function() {
                window.location = "'.home_url().'page/users/detail.php?id='.$user_id.'";
            });
        </script>';
    }
}

function selectUsers($select = '', $where = '', $groupby = '', $orderby = '', $orderby_key) {
    global $conn;
    if (!empty($where)) { $where_all = "WHERE $where"; } 
    else { $where_all = ""; }

    if (!empty($groupby)) { $groupby_all = "GROUP BY $groupby"; }
    else { $groupby_all = ""; }

    if (!empty($orderby)) { $orderby_all = "ORDER BY $orderby $orderby_key"; }
    else { $orderby_all = ""; }

    $sql = "SELECT $select FROM question_ans $where_all $groupby_all $orderby_all";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function joinUsers($select = '', $table = '', $join = '', $where = '', $groupby = '', $orderby = '', $orderby_key = '') {
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

function deleteUsers($key, $id) {
    global $conn;
    $sql = "DELETE FROM question_ans WHERE $key ='$id'";
    $result   = mysqli_query($conn, $sql);

    return $result;
}

function insertUsers($col_arr, $val_arr) {
    global $conn;
    $sql = "INSERT INTO question_ans($col_arr) VALUES ($val_arr)";
    $result = mysqli_query($conn, $sql);
    return $result;

}

function updateUsers($set_arr, $where_arr) {
    global $conn;
    $sql = "UPDATE question_ans SET $set_arr WHERE $where_arr";
    $result = mysqli_query($conn, $sql);
    return $result;
}

?>