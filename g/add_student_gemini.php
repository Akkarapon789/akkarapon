<?php
// ในความเป็นจริง ไฟล์นี้จะรวมเนื้อหาของ connectdb.php ไว้
// เพื่อให้เป็นไฟล์เดี่ยวตามที่ร้องขอ
// ถ้าคุณมีไฟล์ connectdb.php อยู่แล้ว กรุณานำโค้ดภายในมาวางที่นี่
// หรือเพียงแค่เปลี่ยนบรรทัดนี้เป็น include_once 'connectdb.php';

$servername = "localhost"; // หรือชื่อ server ของคุณ
$username = "root"; // ชื่อผู้ใช้ฐานข้อมูลของคุณ
$password = ""; // รหัสผ่านฐานข้อมูลของคุณ
$dbname = "msu"; // ชื่อฐานข้อมูลของคุณ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// สร้างตัวแปรสำหรับเก็บข้อความแจ้งเตือน
$message = "";
$message_class = "";

// ส่วนจัดการข้อมูลเมื่อฟอร์มถูก submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $s_id = $_POST['s_id'];
    $s_name = $_POST['s_name'];
    $s_address = $_POST['s_address'];
    $s_gpax = $_POST['s_gpax'];
    $f_id = $_POST['f_id'];

    // เตรียม SQL query แบบ Prepared Statement เพื่อป้องกัน SQL Injection
    $sql_insert = "INSERT INTO student (s_id, s_name, s_address, s_gpax, f_id) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql_insert);
    
    // ผูกค่าตัวแปรกับ placeholder ใน query
    $stmt->bind_param("sssid", $s_id, $s_name, $s_address, $s_gpax, $f_id);
    
    // ตรวจสอบการเพิ่มข้อมูล
    if ($stmt->execute()) {
        $message = "เพิ่มข้อมูลนิสิตสำเร็จ!";
        $message_class = "alert-success";
    } else {
        $message = "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->error;
        $message_class = "alert-danger";
    }
    
    // ปิด prepared statement
    $stmt->close();
}

// ส่วนดึงข้อมูลคณะจากตาราง faculty เพื่อใช้ใน dropdown
$sql_faculty = "SELECT f_id, f_name FROM faculty ORDER BY f_name ASC";
$result_faculty = $conn->query($sql_faculty);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟอร์มเพิ่มข้อมูลนิสิต</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 700px;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 1rem 1rem 0 0;
            text-align: center;
        }
        .btn-primary {
            width: 100%;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="card">
        <div class="card-header py-3">
            <h4 class="mb-0">ฟอร์มเพิ่มข้อมูลนิสิต</h4>
        </div>
        <div class="card-body p-4">
            <!-- แสดงข้อความแจ้งเตือน -->
            <?php if ($message): ?>
                <div class="alert <?php echo $message_class; ?> rounded-3" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="s_id" class="form-label">รหัสนิสิต</label>
                    <input type="text" class="form-control rounded-3" id="s_id" name="s_id" required>
                </div>
                <div class="mb-3">
                    <label for="s_name" class="form-label">ชื่อ-นามสกุล</label>
                    <input type="text" class="form-control rounded-3" id="s_name" name="s_name" required>
                </div>
                <div class="mb-3">
                    <label for="s_address" class="form-label">ที่อยู่</label>
                    <textarea class="form-control rounded-3" id="s_address" name="s_address" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="s_gpax" class="form-label">เกรดเฉลี่ย (GPAX)</label>
                    <input type="number" step="0.01" class="form-control rounded-3" id="s_gpax" name="s_gpax" required>
                </div>
                <div class="mb-4">
                    <label for="f_id" class="form-label">คณะ</label>
                    <select class="form-select rounded-3" id="f_id" name="f_id" required>
                        <option selected disabled value="">เลือกคณะ...</option>
                        <?php
                        // วนลูปเพื่อแสดงข้อมูลคณะจากฐานข้อมูลใน dropdown
                        if ($result_faculty->num_rows > 0) {
                            while($row = $result_faculty->fetch_assoc()) {
                                echo "<option value='{$row['f_id']}'>{$row['f_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>