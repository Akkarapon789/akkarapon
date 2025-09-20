<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ขจรศักดิ์ จันทรเสนา(ฮาร์ท)</title>
</head>

<body>
	<h1>แสดงข้อมูลนิสิต -- ขจรศักดิ์ จันทรเสนา(ฮาร์ท)</h1>
    
    <?php
    	include("connectdb.php");
		$sql = "SELECT * FROM student";
		$rs = mysqli_query($conn,$sql);
		while ($data = mysqli_fetch_array($rs)) {
			$y = substr($data['s_id'],0,2);
			echo "<img src='http://202.28.32.211/picture/student/{$y}/{$data['s_id']}.jpg' width='260'> <br>";
			echo $data['s_id']."<br>";
			echo $data['s_name']."<br>";
			echo $data['s_address']."<br>";
			echo $data['s_gpax']."<br>";
			echo $data['f_id']."<hr>";
		}
		
		mysqli_close($conn);
	?>

</body>
</html>