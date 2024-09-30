$(document).ready(function() {
   $('.select2').select2({
    dropdownAutoWidth: true
   });

   // $('select').on('change', function() {
   //    $(this).valid();
   //    $(this).removeClass('is-invalid').addClass('is-valid');
   // });
   
   $(".datepicker").datepicker({ 
      autoclose: true, 
      todayHighlight: true,
      format:'dd-mm-yyyy',
      language: 'th',
   }).datepicker();


   // $('#table-result-upload').DataTable();

   $(".datepicker").keypress(function(event) {
      event.preventDefault();
   });

   $(function(){
      var today = new Date();
      var minYear = today.getFullYear()-10;
      var maxYear = today.getFullYear()+2;
      // $('.combodate').combodate({
      //    minYear: minYear,
      //    maxYear: maxYear,
      //    customClass: 'form-control',
      // });    
   });

   //auto size
   autosize($('.autosize'));

   $(function () {
      $('[data-toggle="tooltip"]').tooltip();
   });

   $('.modal').on('shown.bs.modal', function () {
         var textarea = document.querySelectorAll('textarea');
         autosize(textarea);
         autosize.update(textarea);
    });

   // $(window).scroll(function() {
   //      var window_top = $(window).scrollTop() + 1;
   //      if (window_top > 300) {
   //          $('.customer-service-menu').addClass('sticky-action sticky');
   //          $('.customer-service-menu').removeClass('card-menu');
   //      } else {
   //          $('.customer-service-menu').removeClass('sticky-action sticky');
   //          $('.customer-service-menu').addClass('card-menu');
   //      }
   //  });

   $(function() {
        $('.hide-show-login').show();
        $('.hide-show-login i').addClass('show')
        $('.hide-show-login i').click(function() {
            if ($(this).hasClass('show')) {
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
                $('input[name="password"]').attr('type', 'text');
                $(this).removeClass('show');
            } else {
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
                $('input[name="password"]').attr('type', 'password');
                $(this).addClass('show');
            }
        });
        $('form button#userLogin').on('click', function() {
            $('.hide-show-login i').addClass('show', 'fa-eye');
            $('.hide-show-login').parent().find('input[name="password"]').attr('type', 'password');
        });
    });

    $(function() {
        $('.hide-show-repass').show();
        $('.hide-show-repass i').addClass('show')
        $('.hide-show-repass i').click(function() {
            if ($(this).hasClass('show')) {
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
                $('input[name="repass_password"]').attr('type', 'text');
                $(this).removeClass('show');
            } else {
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
                $('input[name="repass_password"]').attr('type', 'password');
                $(this).addClass('show');
            }
        });
        $('form button#changePassword').on('click', function() {
            $('.hide-show-repass i').addClass('show', 'fa-eye');
            $('.hide-show-repass').parent().find('input[name="repass_password"]').attr('type', 'password');
        });
    });

    $(function() {
        $('.hide-show-confirmpass').show();
        $('.hide-show-confirmpass i').addClass('show')
        $('.hide-show-confirmpass i').click(function() {
            if ($(this).hasClass('show')) {
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
                $('input[name="repass_password_confirm"]').attr('type', 'text');
                $(this).removeClass('show');
            } else {
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
                $('input[name="repass_password_confirm"]').attr('type', 'password');
                $(this).addClass('show');
            }
        });
        $('form button#changePassword').on('click', function() {
            $('.hide-show-confirmpass i').addClass('show', 'fa-eye');
            $('.hide-show-confirmpass').parent().find('input[name="repass_password_confirm"]').attr('type', 'password');
        });
    });

    $(function() {
        $('.hide-show-oldpass').show();
        $('.hide-show-oldpass i').addClass('show')
        $('.hide-show-oldpass i').click(function() {
            if ($(this).hasClass('show')) {
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
                $('input[name="repass_password_old"]').attr('type', 'text');
                $(this).removeClass('show');
            } else {
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
                $('input[name="repass_password_old"]').attr('type', 'password');
                $(this).addClass('show');
            }
        });
        $('form button#changePasswordByUser').on('click', function() {
            $('.hide-show-oldpass i').addClass('show', 'fa-eye');
            $('.hide-show-oldpass').parent().find('input[name="repass_password_old"]').attr('type', 'password');
        });
    });

    // Reset Password
    $('#repass_password').on('keyup', function() {
        let textElement = $(this).val()
        let strength = 0

        if (textElement.length > 0) {
            let sizeElements = textElement.length

            if (sizeElements > 10) {

                strength += 30

            } else {
                let calcMath = (sizeElements * 2)

                strength += calcMath

            }

        }

        let lowerCase = new RegExp(/[a-z]/)
        if (lowerCase.test(textElement)) {
            strength += 16
        }

        let upperCase = new RegExp(/[A-Z]/)
        if (upperCase.test(textElement)) {
            strength += 18
        }

        let regularNumber = new RegExp(/[0-9]/i)
        if (regularNumber.test(textElement)) {
            strength += 16
        }

        let specialChars = new RegExp(/[!@#$&*]/i)
        if (specialChars.test(textElement)) {
            strength += 20
        }

        //============end Business rules==============
        //======Results Rendering=====================
        if (strength < 21) {
            //red very weak password
            $('#strength_password').html(`
                <div class="progress">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: ${strength}%" aria-valuenow="${strength}" aria-valuemin="0" aria-valuemax="100"><span>${strength}%</span></div>
                </div>
                <p class="text-danger mb-0" style="font-style: italic; font-size: 12px;">Very Weak</p>`)
        } else
        if (strength > 20 && strength < 41) {
            //orange weak password
            $('#strength_password').html(`
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: ${strength}%" aria-valuenow="${strength}" aria-valuemin="0" aria-valuemax="100"><span>${strength}%</span></div>
                    </div>
                    <p class="text-warning mb-0" style="font-style: italic; font-size: 12px;">Weak</p>`)
        } else
        if (strength > 40 && strength < 61) {
            //medium password
            $('#strength_password').html(`
                    <div class="progress">
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: ${strength}%" aria-valuenow="${strength}" aria-valuemin="0" aria-valuemax="100"><span>${strength}%</span></div>
                    </div>
                    <p class="text-secondary mb-0" style="font-style: italic; font-size: 12px;">Medium </p>`)
        } else
        if (strength > 60 && strength < 81) {
            // strong password
            $('#strength_password').html(`
                    <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar" style="width: ${strength}%" aria-valuenow="${strength}" aria-valuemin="0" aria-valuemax="100"><span>${strength}%</span></div>
                    </div>
                    <p class="text-info mb-0" style="font-style: italic; font-size: 12px;">Strong</p>`)
        } else {
            //very strong password
            $('#strength_password').html(`
                <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: ${strength}%" aria-valuenow="${strength}" aria-valuemin="0" aria-valuemax="100"><span>${strength}%</span></div>
                    </div>
                    <p class="text-success mb-0" style="font-style: italic; font-size: 12px;">Very Strong </p>`)
        }
        //======Results Rendering=====================
        
        //======Hide the div containing the result====
        if (strength == 0) {
            $('#strength_password').addClass('showHidden')
        } else {
            $('#strength_password').removeClass('showHidden')
        }
    });
});

$(document).ready(function () {

    var base_url = $('#home_url').val();

    $('#user_logout').click(function() {
        var LOGOUT_URL = $('#logout_url').val();
        var CURRENT_URL = window.location.href.split("#")[0];

        Swal.fire({
            title: "ออกจากระบบ",
            text: "ท่านต้องการออกจากระบบ ใช่หรือไม่",
            icon: "info",
            showCancelButton: true,
            cancelButtonText: "ไม่ใช่",
            confirmButtonColor: "#1690ed",
            confirmButtonText: "ใช่",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = LOGOUT_URL;
            }
        });
    });

    $('#dropdown_user_logout').click(function() {
        var LOGOUT_URL = $('#logout_url').val();
        var CURRENT_URL = window.location.href.split("#")[0];
        
        Swal.fire({
            title: "ออกจากระบบ",
            text: "ท่านต้องการออกจากระบบ ใช่หรือไม่",
            icon: "info",
            showCancelButton: true,
            cancelButtonText: "ไม่ใช่",
            confirmButtonColor: "#1690ed",
            confirmButtonText: "ใช่",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = LOGOUT_URL;
            }
        });
    });

});

$(document)
    .one('focus.textarea', '.auto-expand', function(){
        var savedValue = this.value;
            this.value = '';
            this.baseScrollHeight = this.scrollHeight;
            this.value = savedValue;
    })
    .on('input.textarea', '.auto-expand', function(){
        var minRows = this.getAttribute('data-min-rows')|1,
            rows;
            this.rows = minRows;
            rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 20);
            this.rows = minRows + rows;
});


function autoFormat(obj, typeCheck) {
    if(typeCheck == "phone"){
        var pattern = new String("__-____-____");// กำหนดรูปแบบในนี้
        var pattern_ex = new String("-");// กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้     
    }
    else if (typeCheck == "id_card") {
        var pattern = new String("_-____-_____-_-__");
        var pattern_ex = new String("-"); 
    }
    else{
        var pattern = new String("__-____-____");
        var pattern_ex = new String("-");                 
    }

    var returnText = new String("");
    var obj_l = obj.value.length;
    var obj_l2 = obj_l - 1;

    for(i=0;i<pattern.length;i++){           
        if(obj_l2 == i && pattern.charAt(i+1) == pattern_ex){
            returnText += obj.value + pattern_ex;
            obj.value = returnText;
        }
    }

    if(obj_l >= pattern.length){
        obj.value = obj.value.substr(0, pattern.length);           
    }
}


// Select thead titles from Dom
const headTitleCode = document.querySelector(
    ".responsive-table__head__title--code"
);
const headTitleName = document.querySelector(
    ".responsive-table__head__title--name"
);
const headTitleMax = document.querySelector(
    ".responsive-table__head__title--max"
);
const headTitleMin = document.querySelector(
    ".responsive-table__head__title--min"
);
const headTitleUnit = document.querySelector(
    ".responsive-table__head__title--unit"
);
const headTitleTotal = document.querySelector(
    ".responsive-table__head__title--total"
);
const headTitleEdit = document.querySelector(
    ".responsive-table__head__title--edit"
);

// Select tbody text from Dom
const bodyTextCode = document.querySelectorAll(
    ".responsive-table__body__text--code"
);
const bodyTextName = document.querySelectorAll(
    ".responsive-table__body__text--name"
);
const bodyTextMax = document.querySelectorAll(
    ".responsive-table__body__text--max"
);
const bodyTextMin = document.querySelectorAll(
    ".responsive-table__body__text--min"
);
const bodyTextUnit = document.querySelectorAll(
    ".responsive-table__body__text--unit"
);
const bodyTextTotal = document.querySelectorAll(
    ".responsive-table__body__text--total"
);
const bodyTextEdit = document.querySelectorAll(
    ".responsive-table__body__text--edit"
);

// Select all tbody table row from Dom
const totalTableBodyRow = document.querySelectorAll(
    ".responsive-table__body .responsive-table__row"
);

// Get thead titles and append those into tbody table data items as a "data-title" attribute
for (let i = 0; i < totalTableBodyRow.length; i++) {
    bodyTextCode[i].setAttribute("data-title", headTitleCode.innerText);
    bodyTextName[i].setAttribute("data-title", headTitleName.innerText);
    bodyTextMax[i].setAttribute("data-title", headTitleMax.innerText);
    bodyTextMin[i].setAttribute("data-title", headTitleMin.innerText);
    bodyTextUnit[i].setAttribute("data-title", headTitleUnit.innerText);
    bodyTextTotal[i].setAttribute("data-title", headTitleTotal.innerText);
    bodyTextEdit[i].setAttribute("data-title", headTitleEdit.innerText);
}
