<?php
//recuperation du _GET room
$room = htmlspecialchars($_GET["room"]);
if(htmlspecialchars($_GET["room"]) == "" ){
    $room = "default";
    //---------------------
    //modifier pour l'url en cours
    //---------------------
    header("Location: " . "https://" . $_SERVER['HTTP_HOST'] . "/getChat/index.php?room=" . $room . "#lastmessage");
};

//creation de la db
$db = createdb();

//redirection apres envoi du message
if(!empty($_GET['msg'])){
    sendmessage($_GET['msg']);
    //---------------------
    //modifier pour l'url en cours
    //---------------------
    header("Location: " . "https://" . $_SERVER['HTTP_HOST'] . "/getChat/index.php?room=" . $room . "#lastmessage");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>getChat</title>
</head>
<body onload="document.getChat.msg.focus();">
	
	<h1><?php echo $room; ?></h1>
    
	<article>
		<!--liste des message-->
		<ul id="contentMessage">
			<?php foreach (getmessages(25) as $msg) { ?>
			<li>
				<span style="color: rgb(<?php print($msg['rgb']); ?>);">Anon: </span>
				<?php print(htmlspecialchars($msg['message'])) ?>
			</li>
			<?php } ?>
		</ul>
	</article>
	
	<footer>
		<form method="get" name="getChat">
	        <input name="room" type="text" placeholder="<?php echo $room; ?>" value="<?php echo $room; ?>" required>
	    	<input name="msg" type="text" class="chatInput"  autocomplete="off"  placeholder="msg" />
	    	<input type="submit">
	    </form>
	</footer>
    
    
    <script>
		document.querySelector('#contentMessage li:last-child').id = 'lastmessage'
	</script>
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
		$dayhash = md5(date('Ymd'));
		$room = htmlspecialchars($_GET["room"]);
		$roomTable = $dayhash . "_" . $room;
		//creer une nouvelle table dont le nom est la room
		db()->exec("CREATE TABLE IF NOT EXISTS table_$roomTable (
						id INTEGER PRIMARY KEY,
						date TEXT,
						ip TEXT,
						rgb TEXT, 
						message TEXT)");
	}
	
	function get_ip() {
		//recuperer l'ip precise
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			// IP si internet partagé
			return $_SERVER['HTTP_CLIENT_IP'];
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			// IP derrière un proxy
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			// Sinon : IP normale
			return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
		}
	}
	
	function sendmessage($msg) {
		//envoi le message
		$dayhash = md5(date('Ymd'));
		$room = htmlspecialchars($_GET["room"]);
		$roomTable = $dayhash . "_" . $room;
		$date = date ("d/m/Y-G:i");
		query("INSERT INTO table_$roomTable (date, ip, rgb, message) 
					VALUES (?, ?, ?, ?)", array($date, get_ip(), rgbfromip(), $msg));
	}
	
	function getmessages($num=25) {
		//recupere les messages
		$dayhash = md5(date('Ymd'));
		$room = htmlspecialchars($_GET["room"]);
		$roomTable = $dayhash . "_" . $room;
		return query("SELECT * FROM table_$roomTable ORDER BY id ASC LIMIT :num", array($num));
	}
	
	function rgbfromip() {
		//genere un rgb depuis l'ip
		$h = array_map('ord', str_split(md5(get_ip(), true)));
		return "$h[0],$h[1],$h[2]";
	}
	
?>
