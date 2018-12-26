<?php
$room = htmlspecialchars($_GET["room"]);

if(htmlspecialchars($_GET["room"]) == "" ){
    $room = "default";
    header("Location: " . "https://" . $_SERVER['HTTP_HOST'] . "/minichat/formget.php?room=" . $room . "#lastmessage");
};

$db = createdb();
// if (!empty($_POST['yo'])) {
//   sendmessage($_POST['yo']);
//   header("Location: " . "https://" . $_SERVER['HTTP_HOST'] . "/minichat" . "#lastmessage");
//   exit();
// }

// if(!empty($_GET['getChat'])){
//     sendmessage($_GET['getChat']);
//     exit();
// }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>getChat</title>
</head>
<body>
	
	<?php echo $room; ?>
    
    <form method="get" name="getChat">
        <input name="room" type="text" placeholder="<?php echo $room; ?>" value="<?php echo $room; ?>">
    	<input name="msg" type="text" class="chatInput"  autocomplete="off"  placeholder="msg" />
    	<input type="submit">
    </form>
    
    <!--liste des message-->
    <div class="dschat">
		<ul id="contentMessage">
			
		</ul>
	</div>
    
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div id="lastmessage">message: <?php echo htmlspecialchars($_GET["msg"]); ?></div>
    
</body>
</html>






<?php
	// fonction pour le chat
	function db() {
		static $db;
		$db = $db ?: (new PDO('sqlite:./db2/dslab.sqlite3', 0, 0, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)));
		return $db;
	}
	
	function query($sql, $params = NULL) {
		$s = db()->prepare($sql);
		$s->execute(array_values((array) $params));
		return $s;
	}
	
	function createdb() {
		$room = htmlspecialchars($_GET["room"]);
		//creer une nouvelle table dont le nom est la date hashé en md5
		// $dayhash = md5(date('Ymd'));
		
		// db()->exec("CREATE TABLE IF NOT EXISTS messages_$dayhash (
		// 				id INTEGER PRIMARY KEY,
		// 				ip TEXT,
		// 				rgb TEXT, 
		// 				message TEXT)");
		
		db()->exec("CREATE TABLE IF NOT EXISTS messages_$room (
						id INTEGER PRIMARY KEY,
						ip TEXT,
						rgb TEXT, 
						message TEXT)");
	}
	
	// function get_ip() {
	// 	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
	// 		// IP si internet partagé
	// 		return $_SERVER['HTTP_CLIENT_IP'];
	// 	} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	// 		// IP derrière un proxy
	// 		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	// 	} else {
	// 		// Sinon : IP normale
	// 		return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	// 	}
	// }
	
	// function sendmessage($msg) {
	// 	$dayhash = md5(date('Ymd'));
	// 	query("INSERT INTO messages_$dayhash (ip, rgb, message) 
	// 				VALUES (?, ?, ?)", array(get_ip(), rgbfromip(), $msg));
	// }
	
	// function getmessages($num=25) {
	// 	$dayhash = md5(date('Ymd'));
	// 	return query("SELECT * FROM messages_$dayhash ORDER BY id ASC LIMIT :num", array($num));
	// }
	
	// function rgbfromip() {
	// 	$h = array_map('ord', str_split(md5(get_ip(), true)));
	// 	return "$h[0],$h[1],$h[2]";
	// }
	
?>
