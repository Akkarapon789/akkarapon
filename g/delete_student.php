<meta charset="utf-8">

    <?php
		if (isset($_GET['id'])) {
			include("connectdb.php");
			$sql = "DELETE FROM student WHERE s_id='{$_GET['id']}' ";
			mysqli_query($conn,$sql) or die ("ลบข้อมูลไม่ได้");
			
			echo "<script>";
			echo "window.location='select_student2.php'; ";
			echo "</script>";
		
		}
	?>

</body>
</html>