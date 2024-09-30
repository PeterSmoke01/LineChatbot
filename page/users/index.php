<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/hr-linebot/config/include.php');
require_once(home_path().'controller/fn-users.php');

date_default_timezone_set("Asia/Bangkok");
global $conn;

// ตรวจสอบการ login
is_login();

// Current User
$current_user = current_user();


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
                            <h5 class="m-b-10"><i data-feather="users"></i> หัวเรื่องทั้งหมด</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">หัวเรื่องทั้งหมด</li>
                            <li class="breadcrumb-item">หัวเรื่อง</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-3">
                <a href="<?=home_url()?>page/users/create.php" class="btn btn-primary"><i data-feather="plus"></i>เพิ่มหัวเรื่อง</a>
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-xl-8">
                                <h5>หัวเรื่องทั้งหมด</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-answers" class="table table-hover dataTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>สังกัด</th>
                                        <th>หัวเรื่อง</th>
                                        <th>หัวเรื่องย่อย</th>
                                        <th>รายละเอียด</th>
                                        <th>เครื่องมือ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $number_row = 1;
                                foreach (getUsersAll() as $key => $value) {
                                ?>
                                <tr>
                                    <td><?=$number_row?></td>
                                    <td><?=$value['company']?></td>
                                    <td><?=$value['title']?></td>
                                    <td><?=$value['subtitle']?></td>
                                    <td><?=$value['description']?></td>
                                    <td style="white-space: nowrap;">
                                        <?php
                                            // echo '<a href="'.home_url().'page/users/detail.php?id='.$value['title'].'" class="btn btn-icon btn-primary btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="รายละเอียด"><i class="fas fa-eye"></i></a>';
                                            echo '<a href="'.home_url().'page/users/edit.php?id='.$value['id'].'" class="btn btn-icon btn-warning btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="แก้ไข"><i class="fas fa-pencil-alt"></i></a>';
                                            echo '<a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm" onclick="deletePickingItem('.$value['id'].', \''.$value['title'].'\', \''.$value['subtitle'].'\', \'N\')" data-toggle="tooltip" data-placement="top" title="ปิดใช้งาน"><i class="fas fa-ban"></i></a>';
                                            // echo '<a href="javascript:void(0);" class="btn btn-icon btn-success btn-sm mr-1" onclick="updateIsActive('.$value['title'].', \''.$value['subtitle'].'\', '.$current_user['description'].', \'Y\')" data-toggle="tooltip" data-placement="top" title="เปิดใช้งาน"><i class="fas fa-check-circle"></i></a>';
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
    
    $('#table-answers').DataTable();

    function deletePickingItem(id, title, subtitle, description) {
        Swal.fire({
            title: "ลบรายการเบิกสินค้า",
            html: "ต้องการลบ <br>หัวเรื่อง: <b>"+title+"</b> หัวเรื่องย่อย: <b>"+subtitle+"</b> <br>ใช่หรือไม่?<br><span class='text-md text-danger'>ข้อควรระวัง : เป็นการลบออกจากระบบทันที โดยจะไม่สามารถกู้คืนได้</span>",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "ไม่ต้องการ",
            confirmButtonColor: "#1690ed",
            confirmButtonText: "ต้องการลบ",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : '<?=home_url()?>ajax/deletePickingItem.php',
                    type : 'POST',
                    // dataType: 'json',
                    data : {
                        id: id,
                        title: title,
                        subtitle: subtitle,
                    },
                    success : function(response) {
                        if (response == 'true') {
                            Swal.fire({
                                title: "สำเร็จ!",
                                html: "ลบ <br>หัวเรื่อง: <b>"+title+"</b> หัวเรื่องย่อย: <b>"+subtitle+"</b> สำเร็จ",
                                icon: "success",
                                confirmButtonColor: "#1690ed",
                            }).then(function() {
                                window.location = window.location.href.split("#")[0];
                            });
                        }
                        else {
                            Swal.fire({
                                title: "ไม่สำเร็จ!",
                                html: "ลบ <br>หัวเรื่อง: <b>"+title+"</b> หัวเรื่องย่อย: <b>"+subtitle+"</b> ไม่สำเร็จ",
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