<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ขจรศักดิ์ จันทรเสนา(ฮาร์ท)</title>
</head>

<body>
	<h1>เพิ่มข้อมูลนิสิต -- ขจรศักดิ์ จันทรเสนา(ฮาร์ท)</h1>
    
       <form method="post" action="">
    	รหัสนิสิต <input type="text" name="sid" autofocus required><br>
        ชื่อนิสิต <input type="text" name="sname" required><br>
        ที่อยู่ <br>
        <textarea name="saddress"></textarea><br>
        เกรดเฉลี่ย <input type="text" name="sgpax" required><br>
        
        คณะ<select name="fid">
        <?php
    	include("connectdb.php");
		$sql2 = "SELECT * FROM faculty";
		$rs2 = mysqli_query($conn,$sql2);
		while ($data2 = mysqli_fetch_array($rs2)) {
	?>
        	<option value="<?php echo $data2['f_id'];?>"><?php echo $data2['f_name'];?>
            </option>
            <?php } ?>
        </select>
        <br><br>
        <button type="submit" name="Submit">บันทึก</button>
	</form>
    <hr>
    
    <?php
    	if (isset($_POST['Submit'])){
			include("connectdb.php");
			$sid = $_POST['sid'];
			$sname = $_POST['sname'];
			$saddress = $_POST['saddress'];
			$sgpax = $_POST['sgpax'];
			$fid = $_POST['fid'];
			$sql = "INSERT INTO student(s_id, s_name,s_address,s_gpax,f_id) VALUES ('{$sid}' , '{$sname}' , '{$saddress}' , '{$sgpax}' , '{$fid}');";
			mysqli_query($conn,$sql) or die ("insert error") ;
			
			echo "<script>";
			echo "alert('บันทึกข้อมูลสำเร็จ');";
			echo "window_location = 'select_student.php';";
			echo "</script>";
				
		}
	?>

</body>
</html>