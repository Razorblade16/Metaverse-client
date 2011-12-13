function loaderBox(done, title, subtext) {
	if (!done) {
		$('#boxtitle').html(title);
		$('#subtext').html(subtext);
		$('#loaderbox').show();
		$('.room').hide();
		$('.map').hide();
		$('#loaderbar').css('background-position', (Number($('#loaderbar').css('background-position').replace('px 0px', '')) + 1) + 'px 0px');
		repeater = setTimeout('loaderBox(undefined,"' + title + '","' + subtext + '")', 10);
	} else {
		clearTimeout(repeater);
		$('#loaderbox').hide();
	}
}
$(function () {

	// Make sure the browser supports websockets...
	if (!window.MozWebSocket && !window.WebSocket) {
		alert('Your browser does not support WebSockets.');

		return;
	}

	// Load username from cookie...
	var last_username = getCookie('login_username');
	if (last_username && last_username.length > 1) {
		$('#username').val(last_username);
		$('#password').focus();
	} else {
		$('#username').focus();
	}
	$('#login-form').submit(function () {
		$("#login input[type=submit]").css("display","none");
		loaderBox(undefined, "Logging in...", "Please wait as the server is contacted.")
		// Try logging in!
		var username = $('#username').val();
		var password = $('#password').val();
		if ((username == "") || (password == "")){
			$("#initial_message").html("Please fill in all fields.");
			return false;
		}
		World.callbacks.login_successful = function () {
			// Save username as cookie
			loaderBox(true);
			setCookie('login_username', $('#username').val());
			World.current_user = $("#username").val();
			$("#login input[type=submit]").css("display","inline");
			$('#initial').hide();
			$('#canvas, #toolbar').show();
			$(document).bind("contextmenu",function(e){
				return false;
       		});
			$('#messages').draggable({
				handle: "#messages_handle",
				stop: function(){
					if ($(this).offset().left > 750){
						$(this).css("left","750px");
					}
					if ($(this).offset().top > 550){
						$(this).css("top","550px");
					}
					if ($(this).offset().left < -350){
						$(this).css("left","-350px");
					}
					if ($(this).offset().top < 0){
						$(this).css("top","0px");
					}
				}
			});
		};
		window.onbeforeunload = function() {
			return "Do you really want to leave MetaVerse?";
		};
		$(document).keypress(function(e){
			if (e.keyCode != 13){
				$("#chat").focus();
			}
		});
		World.callbacks.login_failed = function () {
			$("#login input[type=submit]").css("display","inline");
			loaderBox(true);
			World.alertBox({ title: "Oops!",
				message: 'There was an error logging in, check your username and password.',
				cancel: "OK",
				cancel_color: "#23D422"
			});
			$('#password').val('');
		};
		World.login({
			username: username,
			password: password
		});
		return false;
	});
	$('#registration-form').submit(function () {
		if (!$("#reg_agree").is(":checked")){
			$("#initial_message").html("You must agree to the terms.");
			return false;
		}
		// Try registering!
		var username = $('#reg_username').val();
		var password = $('#reg_password').val();
		var password_confirm = $('#reg_confirm').val();
		var email = $('#reg_email').val();

		World.callbacks.registration_successful = function () {
			// Save username as cookie
			setCookie('login_username', $('#reg_username').val());
			$("#username").val($("#reg_username").val());
			$("#login, #register").toggle();
		};
		World.callbacks.registration_failed = function () {
			$("#initial_message").html("There was an error registering.");
		};
		World.register({
			username: username,
			password: password,
			confirm: password_confirm,
			email: email
		});
		return false;
	});

	// Setup chat 
	$('#chat').keypress(function (e) {
		if (e.keyCode == 13){
			try {
				var string = $("#chat").val();
				if (string.substring(0,4) == "/pm "){
					string = string.replace("/pm ","");
					var messagestr = string.split(" ");
					var user = messagestr[0];
					var message = string.replace(user + " ", "");
					World.sendPM(message, user);
				} else {
					World.sendChat($('#chat').val());
				}
				$('#chat').val('');
			} catch (e) {
				World.log(e);
			} finally {
				return false;
			}
		}
	});
});