<?php 
date_default_timezone_set("Asia/Bangkok");
require_once('main.php');
require_once(home_path().'assets/PHPMailer/PHPMailerAutoload.php');
require_once(home_path().'assets/PHPMailer/class.smtp.php');

function sendMail($sender_name, $sender_email, $receiver_email, $subject, $content, $create_by) {
    global $conn;
    date_default_timezone_set("Asia/Bangkok");

    header('Content-Type: text/html; charset=utf-8');
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'mail.sangchaigroup.com';
    $mail->Port       = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth   = true;
    $mail->Username = 'itsce@sangchaigroup.com';
    $mail->Password = '10$zfA$@08x3';
    $mail->IsHTML(true); 
    $mail->CharSet = "utf-8";
    $mail->setFrom($sender_email, $sender_name);
    $mail->addAddress($receiver_email);
    $mail->Subject = $subject;

    $sendmail_at = date("Y-m-d H:i:s");

    if ($receiver_email) {
        $mail->msgHTML($content);
        if (!$mail->send()) {
            $sendmail_log = $mail->ErrorInfo;
            $sendmail_status = "unsuccess";
            
            $col_arr = "log_sender,log_receiver,log_subject,log_status,log_msg,log_by,log_at";
            $val_arr = "'".$sender_email."','".$receiver_email."','".$subject."','".$sendmail_status."','".$sendmail_log."','".$create_by."','".$sendmail_at."'";
            $sql = "INSERT INTO s_sendmail_log($col_arr) VALUES ($val_arr)";
            $result = mysqli_query($conn, $sql);

            return $sendmail_status;
        }
        else {
            $sendmail_log = "";
            $sendmail_status = "success";

            $col_arr = "log_sender,log_receiver,log_subject,log_status,log_msg,log_by,log_at";
            $val_arr = "'".$sender_email."','".$receiver_email."','".$subject."','".$sendmail_status."','".$sendmail_log."','".$create_by."','".$sendmail_at."'";
            $sql = "INSERT INTO s_sendmail_log($col_arr) VALUES ($val_arr)";
            $result = mysqli_query($conn, $sql);

            return $sendmail_status;
        }
    }
}

function sendLineNotify($sMessage) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set("Asia/Bangkok");

    $sToken = "fXiFdLUjoivcKxacGsrlaZGDXFACH2Sy2OEUdooikjz";
    //$sMessage = "แจ้งขออนุมัติแบบฟอร์มของ".$emp_name."\n"."เลขที่การอนุมัติ : ".$appv_form_code."\n"."ลิ้งค์อนุมัติ : ".$appv_form_link;

    $chOne = curl_init(); 
    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt( $chOne, CURLOPT_POST, 1); 
    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
    $result = curl_exec( $chOne ); 

    //Result error 
    if(curl_error($chOne)) 
    { 
        //echo 'error:' . curl_error($chOne); 
    } 
    else { 
        $result_ = json_decode($result, true); 
        //echo "status : ".$result_['status']; echo "message : ". $result_['message'];
    } 

    curl_close( $chOne ); 
}

//=============================================== //
//== Config Function                           == //
//=============================================== //
function getDateTimeThai ($currDateTime) {
    global $conn;
    date_default_timezone_set("Asia/Bangkok");
    $date_time      = date("d/m/Y", strtotime("$currDateTime"));
    $date_explode   = explode('/', $date_time);
    $year_thai      = $date_explode[2] + 543;
    $result_date    = $date_explode[0].'/'.$date_explode[1].'/'.$year_thai." ".date("H:i:s", strtotime("$currDateTime"));
    return $result_date;
}

function getDateThai ($currDate) {
    global $conn;
    date_default_timezone_set("Asia/Bangkok");

    if ($currDate != "0000-00-00 00:00:00") {
        $date_time      = date("d/m/Y", strtotime("$currDate"));
        $date_explode   = explode('/', $date_time);
        $year_thai      = $date_explode[2] + 543;
        $result_date    = $date_explode[0].'/'.$date_explode[1].'/'.$year_thai;
    }
    else {
        $result_date = "";
    }
    return $result_date;
}

function getDateFullThai ($currDate) {
    global $conn;
    date_default_timezone_set("Asia/Bangkok");

    if ($currDate != "0000-00-00 00:00:00") {
        $date_time      = date("d/m/Y", strtotime("$currDate"));
        $date_explode   = explode('/', $date_time);
        $month_thai     = monthsShort($date_explode[1]);
        $year_thai      = $date_explode[2] + 543;
        $result_date    = $date_explode[0].' '.$month_thai.' '.$year_thai;
    }
    else {
        $result_date = "";
    }
    return $result_date;
}

function convertDateYmd($old_date, $old_prefix, $new_format) {
    $datetime = date("d/m/Y", strtotime("$old_date"));
    $ex_old_date = explode('/', $datetime);
    $year_eng = $ex_old_date[2] - 543;
    $old_date_eng = $year_eng.'/'.$ex_old_date[1].'/'.$ex_old_date[0];
    $new_date = date($new_format, strtotime($old_date_eng));

    return $new_date;
}

function getCurrentDate ($format) {
    date_default_timezone_set("Asia/Bangkok");
    $currDate = date($format);

    return $currDate;
}

function getCurrentDateTime ($format) {
    date_default_timezone_set("Asia/Bangkok");
    $currDateTime = date($format);

    return $currDateTime;
}

function getCurrentTime ($format) {
    date_default_timezone_set("Asia/Bangkok");
    $currTime = date($format);

    return $currTime;
}

function roundDown($value) {
    $floor = $value-floor($value);
    if ($floor >= 0.5) {
        $result = floor($value)+0.5;
    }
    else {
        $result = floor($value)+0;
    }

    return $result;
}

function timeago($date) {
    date_default_timezone_set("Asia/Bangkok");
    $timestamp = strtotime($date);   
       
    $strTime = array("วินาที", "นาที", "ชั่วโมง", "วัน", "สัปดาห์", "เดือน", "ปี");
    $length = array("60","60","24","30","7","12","10");

    $currentTime = time();
    if($currentTime >= $timestamp) {
        $diff     = time()- $timestamp;
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
        }

        $diff = round($diff);
        switch ($strTime[$i]) {
            case 'วินาที':
                $str = "ที่ผ่านมา";
                break;

            case 'นาที':
                $str = "ที่ผ่านมา";
                break;

            case 'ชั่วโมง':
                $str = "ที่ผ่านมา";
                break;

            case 'วัน':
                $str = "ที่ผ่านมา";
                break;

            case 'สัปดาห์':
                $str = "ที่แล้ว";
                break;

            case 'เดือน':
                $str = "ที่แล้ว";
                break;

            case 'ปี':
                $str = "ที่แล้ว";
                break;
        }

        return $diff . " " . $strTime[$i] . $str;
    }
}

function getTimeAgo($datetime) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'ปี',
        'm' => 'เดือน',
        'w' => 'สัปดาห์',
        'd' => 'วัน',
        'h' => 'ชั่วโมง',
        'i' => 'นาที',
        's' => 'วินาที',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            switch ($v) {
                case 'วินาที':
                    $str = "ที่ผ่านมา";
                    break;

                case 'นาที':
                    $str = "ที่ผ่านมา";
                    break;

                case 'ชั่วโมง':
                    $str = "ที่ผ่านมา";
                    break;

                case 'วัน':
                    $str = "ที่ผ่านมา";
                    break;

                case 'สัปดาห์':
                    $str = "ที่แล้ว";
                    break;

                case 'เดือน':
                    $str = "ที่แล้ว";
                    break;

                case 'ปี':
                    $str = "ที่แล้ว";
                    break;
            }

            $v = $diff->$k . ' ' . $v.$str;

        } 
        else {
            unset($string[$k]);
        }
    }

    $string = array_slice($string, 0, 1);
    return implode(', ', $string);
}

function getTimeLeft($datetime) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->days >= 1) {
        $string = $diff->days." วัน";
    }
    else {
        if ($diff->h >= 1) {
            $string = $diff->h." ชั่วโมง";
        }
        else {
            $string = $diff->i." นาที";
        }
    } 

    return $string;
}

function monthsShort($month) {
    switch ($month) {
        case '01':
            $month_full = "ม.ค.";
            break;
        case '02':
            $month_full = "ก.พ.";
            break;
        case '03':
            $month_full = "มี.ค.";
            break;
        case '04':
            $month_full = "เม.ย.";
            break;
        case '05':
            $month_full = "พ.ค.";
            break;
        case '06':
            $month_full = "มิ.ย.";
            break;
        case '07':
            $month_full = "ก.ค.";
            break;
        case '08':
            $month_full = "ส.ค.";
            break;
        case '09':
            $month_full = "ก.ย.";
            break;
        case '10':
            $month_full = "ต.ค.";
            break;
        case '11':
            $month_full = "พ.ย.";
            break;
        case '12':
            $month_full = "ธ.ค.";
            break;
        default:
            $month_full = "";
            break;
    }

    return $month_full;
}

function textFormat( $text = '', $pattern = '', $ex = '' ) {
   $cid = ( $text == '' ) ? '0000000000000' : $text;
   $pattern = ( $pattern == '' ) ? '_-____-_____-__-_' : $pattern;
   $p = explode( '-', $pattern );
   $ex = ( $ex == '' ) ? '-' : $ex;
   $first = 0;
   $last = 0;
   for ( $i = 0; $i <= count( $p ) - 1; $i++ ) {
      $first = $first + $last;
      $last = strlen( $p[$i] );
      $returnText[$i] = substr( $cid, $first, $last );
   }
 
   return implode( $ex, $returnText );
}

function telFormat( $text = '', $pattern = '', $ex = '' ) {
   $cid = ( $text == '' ) ? '0000000000' : $text;
   $pattern = ( $pattern == '' ) ? '__-________' : $pattern;
   $p = explode( '-', $pattern );
   $ex = ( $ex == '' ) ? '-' : $ex;
   $first = 0;
   $last = 0;
   for ( $i = 0; $i <= count( $p ) - 1; $i++ ) {
      $first = $first + $last;
      $last = strlen( $p[$i] );
      $returnText[$i] = substr( $cid, $first, $last );
   }
 
   return implode( $ex, $returnText );
}

function quickRandom($length) {
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

function numberRandom($length) {
    $pool = '0123456789';
    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

function randomOtpRef($length) {
    $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

function obfuscate_email($email) {
    $em   = explode("@",$email);
    $name = implode('@', array_slice($em, 0, count($em)-1));
    $len  = floor(strlen($name)/2);

    return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);   
}

function generateRunningNumber($type, $running_customer) {
    global $conn;
    date_default_timezone_set("Asia/Bangkok");

    $running_generate   = "";
    $datetime_now       = date("Y-m-d H:i:s");
    $year_now           = date("y")+43;
    $month_now          = date("m");

    $sql = "SELECT * from running_number where running_type = '$type' and running_customer = '$running_customer'";
    $query = mysqli_query($conn, $sql);
    while($arr = mysqli_fetch_assoc($query)) {
        $running_id     = $arr['id'];
        $running_prefix = $arr['running_prefix'];
        $running_number = $arr['running_number'];
        $running_year   = $arr['running_year'];

        if ($running_year == $year_now) {
            $number_next        = $running_number + 1;
            $number_seq         = substr("00000" . $number_next, -4, 4);
            $running_generate   = $running_prefix.$year_now.$month_now.$number_seq;
        } 
        else {
            $number_next = 1;
            $number_seq = substr("00000" . $number_next, -4, 4);
            $running_generate = $running_prefix.$year_now.$month_now.$number_seq;
        }
    }

    return $running_generate;
}

function updateRunningNumber($type, $running_customer) {
    global $conn;
    date_default_timezone_set("Asia/Bangkok");

    $running_generate   = "";
    $datetime_now       = date("Y-m-d H:i:s");
    $year_now           = date("y")+43;
    $month_now          = date("m");

    $sql = "SELECT * from running_number where running_type = '$type' and running_customer = '$running_customer'";
    $query = mysqli_query($conn, $sql);
    while($arr = mysqli_fetch_assoc($query)) {
        $running_id     = $arr['id'];
        $running_prefix = $arr['running_prefix'];
        $running_number = $arr['running_number'];
        $running_year   = $arr['running_year'];

        if ($running_year == $year_now) {
            $number_next        = $running_number + 1;
            $number_seq         = substr("00000" . $number_next, -4, 4);
            $running_generate   = $running_prefix.$year_now.$month_now.$number_seq;

            $sql1 = "UPDATE running_number SET running_year = '$year_now', running_number = '$number_next', running_generate = '$running_generate', update_at = '$datetime_now' WHERE id = '$running_id'";
            $query1 = mysqli_query($conn, $sql1);
        } 
        else {
            $number_next = 1;
            $number_seq = substr("00000" . $number_next, -4, 4);
            $running_generate = $running_prefix.$year_now.$month_now.$number_seq;

            $sql2 = "UPDATE running_number SET running_year = '$year_now', running_number = '$number_next', running_generate = '$running_generate', update_at = '$datetime_now' WHERE id = '$running_id'";
            $query2 = mysqli_query($conn, $sql2);
        }
    }

    return $running_generate;
}
