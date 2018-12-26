<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    avant
    <br>
    
    
    <?php
        $dayhash = md5(date('Ymd'));
        echo $dayhash;
        echo "<br>";
        
		$room = htmlspecialchars($_GET["room"]);
		echo $room;
		echo "<br>";
		
		$roomTable = $dayhash . "_" . $room;
		echo $roomTable;
    ?>
    
    
    <br>
    apres
</body>
</html>