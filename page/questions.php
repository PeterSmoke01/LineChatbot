<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/hr-linebot/config/include.php');
require_once(home_path().'controller/fn-users.php');
require_once(home_path().'assets/PHPExcel/PHPExcel.php');
require_once(home_path().'assets/PHPExcel/PHPExcel/RichText.php');
require_once(home_path().'assets/PHPExcel/PHPExcel/IOFactory.php');

global $conn;
date_default_timezone_set("Asia/Bangkok");

// ตรวจสอบการ login
is_login();

// Current User
$current_user = current_user();
$dateNow = date("Y-m-d");

// Get employee_id from URL
$employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : '';

// ดึงข้อมูลคำถามของพนักงานตาม employee_id และอันที่ response มีค่าและไม่เป็นค่าว่าง
$query = "SELECT uq.user_id, uq.question, uq.response, uq.created_at, up.employee_id
          FROM user_questions uq 
          JOIN user_profile up 
          ON uq.user_id = up.uid 
          WHERE up.employee_id = '$employee_id' AND uq.response IS NOT NULL AND uq.response != ''
          ORDER BY uq.created_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$user_questions = [];
while ($row = $result->fetch_assoc()) {
    $user_questions[] = $row;
}

// Generate Excel file
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'รหัสพนักงาน')
                ->setCellValue('B1', 'คำถาม')
                ->setCellValue('C1', 'คำตอบ')
                ->setCellValue('D1', 'เวลาถาม');

    // การจัดแนวซ้ายสำหรับเซลล์
    $AlignLeft = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        ),
    );

    // การจัดสไตล์ให้กับหัวตาราง
    $headerStyle = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => 'FFFFFF'),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4F81BD'),
        ),
    );

    // // การจัดสไตล์ให้กับเซลล์ข้อมูล
    // $dataStyle = array(
    //     'borders' => array(
    //         'allborders' => array(
    //             'style' => PHPExcel_Style_Border::BORDER_THIN,
    //             'color' => array('rgb' => '000000'),
    //         ),
    //     ),
    // );

    // ปรับใช้สไตล์ให้กับหัวตาราง
    $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($headerStyle);

    $rowCount = 2;
    foreach ($user_questions as $question) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $question['employee_id']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $question['question']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, $question['response']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, $question['created_at']);
        
        // ตัดคำอัตโนมัติในคอลัมน์ C
        $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->getAlignment()->setWrapText(true);
        
        $objPHPExcel->getSheet(0)->getStyle('A'.$rowCount)->applyFromArray($AlignLeft);
        $objPHPExcel->getSheet(0)->getStyle('B'.$rowCount)->applyFromArray($AlignLeft);
        $objPHPExcel->getSheet(0)->getStyle('D'.$rowCount)->applyFromArray($AlignLeft);
        $objPHPExcel->getSheet(0)->getRowDimension($rowCount)->setRowHeight(-1); // ปรับความสูงอัตโนมัติ
        // $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':D'.$rowCount)->applyFromArray($dataStyle);
        
        $rowCount++;
    }

    // กำหนดความกว้างของคอลัมน์
    foreach(range('A', 'D') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }

    // กำหนด worksheet ที่ต้องการให้เปิดมาแล้วแสดง ค่าจะเริ่มจาก 0 , 1 , 2 , ......
    $objPHPExcel->setActiveSheetIndex(0);
    
    // ชื่อไฟล์
    $saveFileName = "คำถามและคำตอบทั้งหมด-".$employee_id.".xlsx";

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();
    header('Content-Type: application/vnd.ms-excel'); 
    header('Content-Disposition: attachment;filename="'.$saveFileName.'"'); 
    header('Cache-Control: max-age=0'); 

    $objWriter->save('php://output');  
}
?>

<!-- include header start -->
<?php require_once(home_path().'config/header/header-page.php'); ?>
<!-- include header end -->

<div class="pc-container">
    <div class="pcoded-content">
        <!-- breadcrumb start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10"><i data-feather="message-circle"></i> คำถามและคำตอบ</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item">Questions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- Main Content start -->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-xl-8">
                                <h5>คำถามและคำตอบทั้งหมด</h5>
                            </div>
                            <div class="col-xl-4 text-right">
                                <a href="?employee_id=<?php echo $employee_id; ?>&export=excel" class="btn btn-primary">Export to Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-questions" class="table table-hover dataTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>รหัสพนักงาน</th>
                                        <th>คำถาม</th>
                                        <th>คำตอบ</th>
                                        <th>เวลาถาม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($user_questions as $question): ?>
                                <tr>
                                    <td><?php echo $question['employee_id']; ?></td>
                                    <td><?php echo $question['question']; ?></td>
                                    <td><?php echo $question['response']; ?></td>
                                    <td><?php echo $question['created_at']; ?></td>
                                </tr>
                                <?php endforeach; ?>
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

<!-- include footer start -->
<?php require_once(home_path().'config/footer/footer.php'); ?>
<!-- include footer end -->

<script type="text/javascript">
    $('#table-questions').DataTable();
</script>
