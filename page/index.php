<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/hr-linebot/config/include.php');
require_once(home_path().'controller/fn-users.php');
require_once(home_path().'assets/PHPExcel/PHPExcel.php');
require_once(home_path().'assets/PHPExcel/PHPExcel/RichText.php');
require_once(home_path().'assets/PHPExcel/PHPExcel/IOFactory.php');

global $conn;
date_default_timezone_set("Asia/Bangkok");

is_login();

$current_user = current_user();
$dateNow = date("Y-m-d");

$query = "SELECT uq.user_id, uq.question, uq.response, uq.created_at, up.employee_id 
        FROM user_questions uq 
        JOIN user_profile up 
        ON uq.user_id = up.uid
        ORDER BY up.employee_id";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$user_questions = [];
while ($row = $result->fetch_assoc()) {
    $user_questions[] = $row;
}

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
        
        $rowCount++;
    }

    // กำหนดความกว้างของคอลัมน์
    foreach(range('A', 'D') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }

    // กำหนด worksheet ที่ต้องการให้เปิดมาแล้วแสดง ค่าจะเริ่มจาก 0 , 1 , 2 , ......
    $objPHPExcel->setActiveSheetIndex(0);
    
    // ชื่อไฟล์
    $saveFileName = "คำถามและคำตอบทั้งหมด-". $dateNow .".xlsx";

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();
    header('Content-Type: application/vnd.ms-excel'); 
    header('Content-Disposition: attachment;filename="'.$saveFileName.'"'); 
    header('Cache-Control: max-age=0'); 

    $objWriter->save('php://output');  
    exit;
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
                            <h5 class="m-b-10"><i data-feather="bar-chart-2"></i> Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">Dashboard</li>
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
                                <h5>จำนวนคำถามและคำตอบตามพนักงาน</h5>
                            </div>
                            <div class="col-xl-4 text-right">
                                <a href="?export=excel" class="btn btn-primary">Export to Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="userQuestionsChart"></canvas>
                            </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var userQuestions = <?php echo json_encode($user_questions); ?>;
        
        // Create a dictionary to count questions per user
        var questionCounts = {};
        var employeeIds = {};

        userQuestions.forEach(function(item) {
            if (item.response) { // ตรวจสอบว่ามี response
                if (questionCounts[item.user_id]) {
                    questionCounts[item.user_id]++;
                } else {
                    questionCounts[item.user_id] = 1;
                    employeeIds[item.user_id] = item.employee_id;
                }
            }
        });

        var userIds = Object.keys(questionCounts);
        var questionCountsData = Object.values(questionCounts);
        var employeeIdsData = userIds.map(id => employeeIds[id]);

        var ctx = document.getElementById('userQuestionsChart').getContext('2d');
        var userQuestionsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: employeeIdsData,
                datasets: [{
                    label: 'จำนวนคำถาม',
                    data: questionCountsData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'จำนวนการถาม/ตอบ'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'รหัสพนักงาน'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        var clickedIndex = elements[0].index;
                        var clickedEmployeeId = employeeIdsData[clickedIndex];
                        window.location.href = 'questions.php?employee_id=' + clickedEmployeeId;
                    }
                }
            }
        });
    });
</script>
