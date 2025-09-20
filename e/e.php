<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ขจรศักดิ์ จันทรเสนา(ฮาร์ท)</title>
</head>

<body>
	<h1>ขจรศักดิ์ จันทรเสนา(ฮาร์ท)</h1>
    
    <form method="post" action="">
    กรอกชื่อสัตว์<input type="text" name ="a" autofocus>
    <input type="submit" name ="Submit" value="OK">
    </form>
    <hr>
    
    <?php
	if (isset($_POST['Submit'])){
    	$a = $_POST['a'];
		if($a == "dog" or  $a ==  "หมา" or  $a ==  "สุนัข"){
			echo "<img src ='1.jpg' width='500'>";
		}
		if($a == "cat" or $a ==  "แมว" or $a == "เหมียว"){
			echo "<img src ='2.jpg' width='500'>";
		}
		else if($a == "tiger"  or $a ==  "เสีย"  or $a == "เสือ"){
			echo "<img src ='3.jpg' width='500'>";
		}
	}
	?>
    
</body>
</html>