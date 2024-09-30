<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/hr-linebot/config/include.php');
require_once(home_path().'controller/fn-users.php');
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
                            <h5 class="m-b-10"><i data-feather="edit"></i> แก้ไขหัวเรื่อง</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">หัวเรื่อง</li>
                            <li class="breadcrumb-item">หัวเรื่องย่อย</li>
                            <li class="breadcrumb-item">รายละเอียด</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-3">
                <form id="edit_users_form" class="needs-validation" method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <a href="<?=home_url()?>page/users/" class="btn btn-primary"><i data-feather="list"></i> หัวเรื่องทั้งหมด</a>
                        </div>
                        <?php 
                        $allrow = count(getUsersById($id));
                        if ($allrow != 0) {
                        foreach (getUsersById($id) as $key => $value) {
                        ?>
                        <input type="hidden" name="id" id="id" value="<?=$value['id']?>">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-12">
                                            <h5>แก้ไขหัวเรื่อง</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-xl-5 col-lg-8 col-md-6 col-sm-12 col-12 ">
                                        <label for="company" class="form-label">สังกัด<span class="mark">*</span></label>
                                        <select class="form-control select2" id="company" name="company" data-placeholder="เลือกสังกัด...">
                                            <option></option>
                                            <option value="SCA"     <?=($value['company'] == 'SCA') ? 'selected' : ''?>>SCA</option>
                                            <option value="SCE"     <?=($value['company'] == 'SCE') ? 'selected' : ''?>>SCE</option>
                                            <option value="SCO"     <?=($value['company'] == 'SCO') ? 'selected' : ''?>>SCO</option>
                                            <option value="SCR"     <?=($value['company'] == 'SCR') ? 'selected' : ''?>>SCR</option>
                                            <option value="SC"      <?=($value['company'] == 'SC') ? 'selected' : ''?>>SC</option>
                                            <option value="SCORP"   <?=($value['company'] == 'SCORP') ? 'selected' : ''?>>SCORP</option>
                                            <option value="SCINNO"  <?=($value['company'] == 'SCINNO') ? 'selected' : ''?>>SCINNO</option>
                                            <option value="WCM"     <?=($value['company'] == 'WCM') ? 'selected' : ''?>>WCM</option>
                                            <option value="SAS"     <?=($value['company'] == 'SAS') ? 'selected' : ''?>>SAS</option>
                                        </select>
                                        <label id="company-error" class="mb-0" for="company"></label>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-5 col-lg-8 col-md-6 col-sm-12 col-12">
                                            <label for="title" class="form-label">หัวเรื่อง<span class="mark">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title" value="<?=$value['title']?>">
                                            <label id="title-error" class="mb-0" for="title"></label>
                                        </div>
                                        <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12">
                                            <label for="subtitle" class="form-label">หัวเรื่องย่อย<span class="mark">*</span></label>
                                            <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?=$value['subtitle']?>">
                                            <label id="subtitle-error" class="mb-0" for="subtitle"></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-8 col-md-6 col-sm-12 col-12">
                                        <label for="description" class="form-label">รายละเอียด <span class="mark">*</span></label>
                                        <textarea class="form-control" id="description" name="description" rows="10"><?= $value['description'] ?></textarea>
                                        <label id="description-error" class="mb-0" for="description"></label>
                                    </div>
                                            <!-- <h5 class="mt-4 text-decoration-underline">ข้อมูลผู้บันทึก</h5>
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="is_active" class="form-label">สถานะการใช้งาน <span class="mark">*</span></label>
                                                    <select id="is_active" name="is_active" class="form-control select2">
                                                        <option value="Y" <?php if($value['is_active'] == 'Y') {echo "selected";} ?>>เปิดใช้งาน</option>
                                                        <option value="N" <?php if($value['is_active'] == 'N') {echo "selected";} ?>>ปิดใช้งาน</option>
                                                    </select>
                                                    <label id="is_active-error" class="mb-0" for="is_active"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="update_by" class="form-label">ผู้แก้ไข <span class="mark">*</span></label>
                                                    <select id="update_by" name="update_by" class="form-control mb-1" readonly>
                                                        <option value="<?=$current_user['user_id']?>" selected><?=$current_user['user_fullname']?></option>
                                                    </select>
                                                    <label id="update_by-error" class="mb-0" for="update_by"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                                                    <label for="update_at" class="form-label">วันที่แก้ไข <span class="mark">*</span></label>
                                                    <input type="text" class="form-control" id="update_at" name="update_at" value="<?=date("Y-m-d H:i:s")?>" readonly>
                                                    <label id="update_at-error" class="mb-0" for="update_at"></label>
                                                </div>
                                            </div> -->
                                        

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <button type="submit" id="editUsers" name="editUsers" class="btn btn-success float-right ml-1"><i data-feather="download"></i> บันทึกการแก้ไข</button>
                            <a href="<?=home_url()?>page/users/" class="btn btn-secondary float-right ml-1"><i data-feather="x"></i> ยกเลิก</a>
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
                                            <h5>แก้ไขผู้ใช้งาน</h5>
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
    $('#user_role').on('change', function () {
        if ($(this).val() == '3') {
            $('#customer_id_div').addClass('d-block').removeClass('d-none');
        }
        else {
            $('#customer_id_div').addClass('d-none').removeClass('d-block');
        }
    });
});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
    );

    $("#edit_users_form").validate({
        ignore: ":hidden",
        validClass: "is-valid",
        errorClass: "is-invalid",
        errorElement: "label",
        rules: {
            company: {
                required: true,
                maxlength: 11,
            },
            title: {
                required: true,
                maxlength: 40,
            },
            subtitle: {
                required: true,
                maxlength: 40,
            },
            description: {required: true},
            // user_fullname: {required: true},
            // user_email: {
            //     required: true,
            //     regex: "^[\\w_\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$",
            // },
            // user_role: {required: true},
            // customer_id: {
            //     required: function(element) {
            //         return $("#user_role").val() == '3';
            //     },
            // },
            // is_active: {required: true},
            // create_by: {required: true},
            // create_at: {required: true},
        },
        messages: {
            company: {
                required: 'โปรดระบุสังกัด...',
                maxlength: 'โปรดระบุอย่างน้อย 3 ตัว แต่ไม่เกิน 11 ตัว...',
            },
            title: {
                required: 'โปรดระบุหัวเรื่อง...',
                maxlength: 'โปรดระบุอย่างน้อย 5 ตัว แต่ไม่เกิน 40 ตัว...',
            },
            subtitle: {
                required: 'โปรดระบุหัวเรื่องย่อย...',
                maxlength: 'โปรดระบุอย่างน้อย 5 ตัว แต่ไม่เกิน 40 ตัว...',
                regex: 'โปรดระบุหัวเรื่องย่อยให้ถูกต้อง...',
            },
            description: {required: 'โปรดระบุเนื้อหา...'},
            // user_fullname: {required: 'โปรดระบุชื่อ-นามสกุล...'},
            // user_email: {
            //     required: 'โปรดระบุอีเมล...',
            //     regex: 'โปรดระบุรูปแบบอีเมลให้ถูกต้อง...',
            // },
            // user_role: {required: 'โปรดระบุบทบาทผู้ใช้งาน...'},
            // customer_id: {required: 'โปรดระบุกลุ่มลูกค้า...'},
            // is_active: {required: 'โปรดระบุ...'},
            // create_by: {required: 'โปรดระบุ...'},
            // create_at: {required: 'โปรดระบุ...'},
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "company" ) {
               error.appendTo('#company-error');
            }

            if (element.attr("name") == "title" ) {
               error.appendTo('#title-error');
            }

            if (element.attr("name") == "subtitle" ) {
               error.appendTo('#subtitle-error');
            }

            if (element.attr("name") == "description" ) {
               error.appendTo('#description-error');
            }
            
            // if (element.attr("name") == "user_fullname" ) {
            //    error.appendTo('#user_fullname-error');
            // }

            // if (element.attr("name") == "user_password" ) {
            //    error.appendTo('#user_email-error');
            // }

            // if (element.attr("name") == "user_role" ) {
            //    error.appendTo('#user_role-error');
            // }

            // if (element.attr("name") == "customer_id" ) {
            //    error.appendTo('#customer_id-error');
            // }

            // if (element.attr("name") == "is_active" ) {
            //    error.appendTo('#is_active-error');
            // }

            // if (element.attr("name") == "create_by" ) {
            //    error.appendTo('#create_by-error');
            // }

            // if (element.attr("name") == "create_at" ) {
            //    error.appendTo('#create_at-error');
            // }
        },  
    });
});
</script>

<?php 
if(isset($_POST['editUsers'])) {
    editUsers();
}
?>