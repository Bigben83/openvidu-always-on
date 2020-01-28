<html>

<head>
	<title>openvidu-getaroom</title>

	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
	<link rel="shortcut icon" href="openvidu-tutorials/openvidu-getaroom/web/resources/images/favicon.ico" type="image/x-icon">

	<!-- Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Bootstrap -->

	<link rel="styleSheet" href="openvidu-tutorials/openvidu-getaroom/web/style.css" type="text/css" media="screen">
	<script src="openvidu-tutorials/openvidu-getaroom/web/openvidu-browser-2.11.0.js"></script>
	<script src="openvidu-tutorials/openvidu-getaroom/web/app.js"></script>
</head>

<body>

	<nav id="nav-session" class="navbar navbar-default" hidden>
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="/"><img class="demo-logo" src="resources/images/openvidu_vert_white_bg_trans_cropped.png"/> getaroom</a>
				<button id="leave-room" type="button" class="btn btn-danger" onclick="leaveRoom()">
					<span class="hidden-xs">Leave Room</span>
					<span class="hidden-sm hidden-md hidden-lg">Leave</span>
				</button>
				<form class="hidden-xs">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Some path" id="copy-input">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="copy-button" data-toggle="tooltip" data-placement="button" title="Copy to Clipboard">Share the URL</button>
						</span>
					</div>
				</form>
				<button id="mute-video" type="button" class="btn btn-primary float-right mute-button" onclick="muteVideo()">
					<span class="glyphicon glyphicon-facetime-video"></span>
					<span class="hidden-xs">Video</span>
				</button>
				<button id="mute-audio" type="button" class="btn btn-primary float-right mute-button" onclick="muteAudio()">
					<span class="glyphicon glyphicon-volume-up"></span>
					<span class="hidden-xs">Audio</span>
				</button>
			</div>
		</div>
	</nav>

	<div class="container-fluid" id="main-container" >

    
		<!-- Join page template -->
		<div id="join" class="row no-margin" hidden>
			<div id="img-div"><img src="openvidu-tutorials/openvidu-getaroom/web/resources/images/openvidu_grey_bg_transp_cropped.png"/></div>
			<div id="join-dialog" class="jumbotron vertical-center">
				<h1 class="arciform">Get a room</h1>
				<button type="button" class="btn btn-lg btn-success" onclick="joinRoom(); return false;">Go!</button>
			</div>
		</div>

		<!-- Session page template -->
		<div id="session" hidden>
			<div id="videos" class="row no-margin">
			</div>
		</div>

	</div>

</body>

</html>