<?
$version = "InDev b20";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>MetaVerse</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/game.css?<? echo time(); ?>" />
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.16.min.js"></script>
	<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
	<script type="text/javascript" src="js/speech_bubble.js?<? echo time(); ?>"></script>
	<script type="text/javascript" src="js/jsbih.js?<? echo time(); ?>"></script>
	<script type="text/javascript" src="js/config.js?<? echo time(); ?>"></script>
	<script type="text/javascript" src="js/linkedlist.js?<? echo time(); ?>"></script>
	<script type="text/javascript" src="js/key.js?<? echo time(); ?>"></script>
	<script type="text/javascript" src="js/proxy.js?<? echo time(); ?>"></script>
	<script type="text/javascript" src="js/proxymanager.js?<? echo time(); ?>"></script>
	<script type="text/javascript" src="js/util.js?<? echo time(); ?>"></script>
	<script type="text/javascript" src="js/game.js?<? echo time(); ?>"></script>
	<script type="text/javascript" src="js/main.js?<? echo time(); ?>"></script>
	<script type="text/javascript">
		function toggleForms(){
			$("#login, #register").toggle();
			if ($("#register").is(":visible")){
				World.alertBox({ title: "Sorry",
					message: 'Registration does not yet actually work.',
					cancel: "OK",
					cancel_color: "#23D422"
				});
			} else {
				$("#initial_message").html("");
			}
		}
	</script>
</head>
<body>
	<div id="loaderbox">
	    <strong id="boxtitle">Logging In...</strong><br /><br />
    	<div id="loaderprogress"><div id="loaderbar"></div></div><br />
    	<span id="subtext">Please wait as the server is contacted.</span>
	</div>
	<div id="initial">
		<img src="images/logo.png" alt="MetaVerse" id="logo" /><br />
		<div id="version"><? echo $version; ?></div><br />
		<span id="initial_message"></span><br /><br />
		<div id="login">
			<form action="#" id="login-form">
				<input type="text" id="username" placeholder="Username" /><br /><br />
				<input type="password" id="password" placeholder="Password" /><br /><br />
				<input type="submit" value="Login" /><br /><br />
				<a href="#" id="reg_toggle" onclick="toggleForms()">Register</a>
			</form>
		</div>
		<div id="register">
			<form action="#" id="registration-form">
				<table>
					<tr>
						<td>Username:&nbsp;&nbsp;&nbsp;</td><td><input type="text" id="reg_username" /></td>
					</tr>
					<tr>
						<td>Password:</td><td><input type="password" id="reg_password" /></td>
					</tr>
					<tr>
						<td>Confirm:</td><td><input type="password" id="reg_confirm" /></td>
					</tr>
					<tr>
						<td>Email:</td><td><input type="email" id="reg_email" /></td>
					</tr>
					<tr>
						<td>Agree to terms:</td><td><input type="checkbox" id="reg_agree" /></td>
					</tr>
				</table><br />
				<input type="submit" value="Submit" /><br /><br />
				<a href="#" onclick="toggleForms()">Back to Login</a>
			</form>
		</div>
	</div>
	<div id="viewport">
		<canvas id="canvas" width="800" height="572" style="display:none;">
		Your browser does not support the HTML5 canvas element</canvas>
		<div id="toolbar">
			<div id="messages_button" onclick="World.showMessageWindow()"></div>
			<input type="text" id="chat" placeholder="Type a message..." autocomplete="off" />
			<div id="logout_button" onclick="World.logout()"></div>
		</div>
	</div>
	    <div id="messages">
			<img src="images/messages_banner.png" id="messages_handle" alt="Messenger" />
			<div id="messages_control">
				<span class="msg_control_selected" id="alltab" onclick="World.switchMessagesTab('all')">All</span>
				<span id="publictab" onclick="World.switchMessagesTab('public')">Public</span>
				<span id="servertab" onclick="World.switchMessagesTab('server')">Server</span>
        		<span id="pmtab" onclick="World.switchMessagesTab('pm')">Private</span>
        	</div>
        	<div id="all_messages">
        		<div class="all" id="all_lines"></div>
        	</div>
        	<div id="compose_messages">
        		<strong>To:</strong> <input type="text" id="pm_to" /><br />
        		<div id="composecontain">
        			<textarea id="newmessage"></textarea>
        			<span class="msgbuttons">
       					<input type="button" onclick="World.sendPM(true)" id="send" value="Send" />
        			</span>
        		</div>
        	</div>
		</div>
</body>
</html>
