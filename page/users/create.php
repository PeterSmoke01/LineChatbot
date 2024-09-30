<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/hr-linebot/config/include.php');
require_once(home_path().'controller/fn-users.php');
global $conn;
date_default_timezone_set("Asia/Bangkok");

// // ตรวจสอบการ login
// is_login();

// // Current User
// $current_user = current_user();
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
                            <h5 class="m-b-10"><i data-feather="plus"></i> เพิ่มหัวเรื่อง</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">หัวเรื่อง</li>
                            <li class="breadcrumb-item">หัวเรื่องย่อ่ย</li>
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
                <form id="create_users_form" class="needs-validation" method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <a href="<?=home_url()?>page/users/" class="btn btn-primary"><i data-feather="list"></i> หัวเรื่องทั้งหมด</a>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8">
                                            <h5>เพิ่มหัวเรื่อง</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-xl-5 col-lg-8 col-md-6 col-sm-12 col-12 ">
                                        <label for="company" class="form-label">สังกัด<span class="mark">*</span></label>
                                        <select class="form-control select2" id="company" name="company" data-placeholder="เลือกสังกัด...">
                                            <option></option>
                                            <option value="SCA">SCA</option>
                                            <option value="SCE">SCE</option>
                                            <option value="SCO">SCO</option>
                                            <option value="SCR">SCR</option>
                                            <option value="SC">SC</option>
                                            <option value="SCORP">SCORP</option>
                                            <option value="SCINNO">SCINNO</option>
                                            <option value="WCM">WCM</option>
                                            <option value="SAS">SAS</option>
                                        </select>
                                        <label id="company-error" class="mb-0" for="company"></label>
                                    </div>
                                    <div class='row'>
                                        <div class="col-xl-5 col-lg-8 col-md-6 col-sm-12 col-12">
                                            <label for="title" class="form-label">หัวเรื่อง<span class="mark">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title" value="">
                                            <label id="title-error" class="mb-0" for="title"></label>
                                        </div>
                                        <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12">
                                            <label for="subtitle" class="form-label">หัวเรื่องย่อย<span class="mark">*</span></label>
                                            <input type="text" class="form-control" id="subtitle" name="subtitle" value="">
                                            <label id="subtitle-error" class="mb-0" for="subtitle"></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-8 col-md-6 col-sm-12 col-12">
                                        <label for="description" class="form-label">รายละเอียด<span class="mark">*</span></label>
                                        <textarea type="text" class="form-control" id="description" name="description" rows="4" style="width: 100%;"></textarea>
                                        <label id="description-error" class="mb-0" for="description"></label>
                                    </div>
                                            <!-- <h5 class="mt-4 text-decoration-underline">ข้อมูลผู้บันทึก</h5>
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
                                            </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <button type="submit" id="addRule" name="addRule" class="btn btn-success float-right ml-1"><i data-feather="download"></i> บันทึกข้อมูล</button>
                            <a href="<?=home_url()?>page/users/" class="btn btn-secondary float-right ml-1"><i data-feather="x"></i> ยกเลิก</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Main Content end -->

    </div>
</div>

<?php require_once(home_path().'/config/footer/footer.php'); ?>

<script type="text/javascript">
$(document).ready(function () {
    $(function() {
        $('.hide-show-userpass').show();
        $('.hide-show-userpass i').addClass('show')
        $('.hide-show-userpass i').click(function() {
            if ($(this).hasClass('show')) {
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
                $('input[name="user_password"]').attr('type', 'text');
                $(this).removeClass('show');
            } else {
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
                $('input[name="user_password"]').attr('type', 'password');
                $(this).addClass('show');
            }
        });
        $('form button#addUsers').on('click', function() {
            $('.hide-show-userpass i').addClass('show', 'fa-eye');
            $('.hide-show-userpass').parent().find('input[name="user_password"]').attr('type', 'password');
        });
    });

    $(function() {
        $('.hide-show-userconfirmpass').show();
        $('.hide-show-userconfirmpass i').addClass('show')
        $('.hide-show-userconfirmpass i').click(function() {
            if ($(this).hasClass('show')) {
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
                $('input[name="user_password_confirm"]').attr('type', 'text');
                $(this).removeClass('show');
            } else {
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
                $('input[name="user_password_confirm"]').attr('type', 'password');
                $(this).addClass('show');
            }
        });
        $('form button#addUsers').on('click', function() {
            $('.hide-show-userconfirmpass i').addClass('show', 'fa-eye');
            $('.hide-show-userconfirmpass').parent().find('input[name="user_password_confirm"]').attr('type', 'password');
        });
    });
});
</script>

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

    $("#create_users_form").validate({
        ignore: ":hidden",
        validClass: "is-valid",
        errorClass: "is-invalid",
        errorElement: "label",
        rules: {
            title: {
                required: true,
                maxlength: 40,
            },
            subtitle: {
                required: true,
                maxlength: 40,
            },
            description: {required: true},
            // title: {
            //     required: true,
            //     regex: "^[A-Za-z][A-Za-z0-9_]{4,}$",
            //     maxlength: 20,
            //     remote: {
            //         url: "<?=home_url()?>ajax/validateUsername.php",
            //         type: "POST",
            //         data: {
            //             title: function() {
            //                 return $("#title").val();
            //             }
            //         }
            //     },
            // },
            // is_active: {required: true},
            // create_by: {required: true},
            // create_at: {required: true},
        },
        messages: {
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
            // user_username: {
            //     required: 'โปรดระบุชื่อผู้ใช้งาน...',
            //     regex: 'โปรดระบุชื่อผู้ใช้งานให้ถูกต้องตามเงื่อนไข...',
            //     maxlength: 'โปรดระบุอย่างน้อย 5 ตัว แต่ไม่เกิน 20 ตัว...',
            //     remote: 'ชื่อผู้ใช้งานนี้ มีในระบบแล้ว...'
            // },
            // user_password: { 
            //     required: 'โปรดกำหนดรหัสผ่าน...', 
            //     regex: 'โปรดระบุรหัสผ่านให้ถูกต้องตามเงื่อนไข...',
            //     maxlength: 'โปรดระบุอย่างน้อย 8 ตัว แต่ไม่เกิน 16 ตัว...',
            // },
            // user_password_confirm: { 
            //     required: 'โปรดยืนยันรหัสผ่าน...',
            //     equalTo: 'โปรดระบุรหัสผ่านให้ตรงกัน...', 
            // },
            // user_role: {required: 'โปรดระบุบทบาทผู้ใช้งาน...'},
            // customer_id: {required: 'โปรดระบุกลุ่มลูกค้า...'},
            // is_active: {required: 'โปรดระบุ...'},
            // create_by: {required: 'โปรดระบุ...'},
            // create_at: {required: 'โปรดระบุ...'},
        },
        errorPlacement: function(error, element) {
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

            // if (element.attr("name") == "user_email" ) {
            //    error.appendTo('#user_email-error');
            // }

            // if (element.attr("name") == "user_password" ) {
            //    error.appendTo('#user_password-error');
            // }

            // if (element.attr("name") == "user_password_confirm" ) {
            //    error.appendTo('#user_password_confirm-error');
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
if(isset($_POST['addRule'])) {
    addRule();
}
?>