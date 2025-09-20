<?php
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
include('connectdb.php');

// ตรวจสอบการ submit ฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $s_id = $_POST['s_id'];
    $s_name = $_POST['s_name'];
    $s_address = $_POST['s_address'];
    $s_gpax = $_POST['s_gpax'];
    $f_id = $_POST['f_id'];

    // เตรียมคำสั่ง SQL
    $sql = "INSERT INTO student (s_id, s_name, s_address, s_gpax, f_id) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdi", $s_id, $s_name, $s_address, $s_gpax, $f_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>บันทึกข้อมูลสำเร็จ</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>เกิดข้อผิดพลาด: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มข้อมูลนิสิต</title>
    <!-- Bootstrap v5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-primary text-white text-center">
            <h4>เพิ่มข้อมูลนิสิต</h4>
        </div>
        <div class="card-body">

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">รหัสนิสิต</label>
                    <input type="text" name="s_id" class="form-control" required maxlength="11">
                </div>

                <div class="mb-3">
                    <label class="form-label">ชื่อนิสิต</label>
                    <input type="text" name="s_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">ที่อยู่</label>
                    <textarea name="s_address" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">GPAX</label>
                    <input type="number" step="0.01" min="0" max="4" name="s_gpax" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">คณะ</label>
                    <select name="f_id" class="form-select" required>
                        <option value="">-- เลือกคณะ --</option>
                        <?php
                        $sql_fac = "SELECT * FROM faculty";
                        $result_fac = $conn->query($sql_fac);
                        while ($row = $result_fac->fetch_assoc()) {
                            echo "<option value='" . $row['f_id'] . "'>" . $row['f_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">บันทึก</button>
                    <button type="reset" class="btn btn-secondary px-4">ล้างข้อมูล</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
