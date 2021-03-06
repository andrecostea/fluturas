<?php
session_start();
require_once("../dbcon.php");

$name = $_GET['name'];

echo "welcome to room ".$name." user ".$_GET['user'];
echo "<script>";
echo "function updateLastSend(value){";
echo "var p=document.getElementById('c_talk');";
echo "document.location.hash='c_talk='+value;";
echo "p.innerHTML=document.URL.substring(document.URL.indexOf('c_talk=')+7,document.URL.length);";
echo "}";
echo "</script>";

$getRooms = "SELECT * FROM cubecartCubeCart_chatrooms WHERE name = '$name'";
$roomResults = mysql_query($getRooms);

if (mysql_num_rows($roomResults) < 1) {
      //  header("Location: ../chatroom_index.php");
    header("Location: " . $name);
    die();
}

$file = "";
while ($rooms = mysql_fetch_array($roomResults)) {
    $file = $rooms['file'];
}
$current_user = $_SESSION['CHATROOM_USER_EMAIL'];
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Welcome to: <?php echo $name; ?></title>
    <link rel="stylesheet" type="text/css" href="../main.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
    <script src="chat.js" type="text/javascript"></script>
    <script type="text/javascript">
    	var chat = new Chat('<?php echo $file; ?>');
        chat.init();
    	chat.getUsers(<?php echo "'" . $name ."','" .$_SESSION['CHATROOM_USER_EMAIL'] . "'"; ?>);
        var name = '<?php echo $_SESSION['CHATROOM_USER_FIRST'];?>';
        var room_to_invite = '<?php echo $name; ?>';
	var user_to_leave = '<?php echo $current_user; ?>';
    </script>
    <script type="text/javascript" src="settings.js"></script>
    <script type="text/javascript" src="inviting.js"></script>
</head>

<body>
    <div id="page-wrap">

    	<div id="header">
        
		<h4><a href="http://www.group17.com/CubeCart2/chatroom_index.php">back to room list</a></h4>
        </div>
        
        <div id="section">
            <div id="invite-user-div">
		<label>Input email: </label>
            	<input type="text" name="user" id="invite_user"/>
		<button id="invite" name="invite" onclick="inviteUserFunc()">Invite Friends</button>
		<button id="quit_room" name="quit_room" onclick="quitRoom()">Quit This Room</button>
            </div>
            <div id="left-room">
            </div>
        </div>
        <div id="section">
            <h2><?php echo $name; ?></h2>      
            <div id="chat-wrap">
                <div id="chat-area"></div>
            </div>
            <div id="userlist"></div>
            <form id="send-message-area" action="">
                <textarea id="sendie" maxlength='100' onKeyUp="updateLastSend(sendie.value)"></textarea>
            </form>
            <p>last message you typed:</p>
            <p id="c_talk"></p>
            <script>
                     var p=document.getElementById("c_talk");
                     if(document.URL.indexOf("c_talk=")<=0){
                               p.innerHTML="NULL";
                     }
                     else{
                     p.innerHTML=document.URL.substring(document.URL.indexOf("c_talk=")+7,document.URL.length);
}
            </script>
        </div>
        
    </div>
</body>
</html>
