<html>

<head>
    <title>openvidu-insecure-js</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    
    <script src="js/openvidu-browser-2.11.0.js"></script>
    <script src="js/app.js"></script>

    <style>
        @font-face {
            font-family: 'Eurostile';
            src: url('fonts/EurostileBold.woff2') format('woff2'), url('fonts/EurostileBold.woff') format('woff');
            font-weight: bold;
            font-style: normal;
        }
        
        @font-face {
            font-family: 'Eurostile';
            src: url('fonts/EurostileRegular.woff2') format('woff2'), url('fonts/EurostileRegular.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }
        
        html,
        body {
            height: 100%;
            width: 100%;
        }
        
        body {
            font-family: 'Eurostile', arial;
            font-weight: bold;
            font-style: normal;
        }
        
        .background-image {
            /* background: url(images/background.jpg); */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        video {
            width: 100% !important;
            height: auto !important;
        }
    
    	.bottom-centered {
        	position: inherit;
        	bottom: 10px;
        	left: 0;
        }
    	
    	.top-centered {
        	position: inherit;
        	top: 30px;
        	left: 0;
        }
    
    	.navbar-toggler {
    		font-size: 3.25rem;
    	}
    </style>
</head>

<body>

    <div id="main" class="container-fluid bg-dark h-100 background-image">

        <div class="modal fade" id="joinModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="joinModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <div id="join">
                            <div id="img-div"><img class="img-fluid w-50" src="images/openvidu_grey_bg_transp_cropped.png" alt="Logo" /></div>
                            <div id="join-dialog" class="vertical-center">
                                <h3>Join a video session</h3>
                                <form class="form-group" onsubmit="joinSession(); return false">
                                    <p>
                                        <label>Participant</label>
                                        <input class="form-control" type="text" id="userName" required>
                                    </p>
                                    <p>
                                        <label>Session</label>
                                        <input class="form-control" type="text" id="sessionId" required>
                                    </p>
                                    <p class="text-center">
                                        <input class="btn btn-lg btn-danger" type="submit" name="commit" value="Join!">
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="session" style="display: none;">

            <div id="main-video" class="row no-margin h-100">
                <video autoplay playsinline="true" class="" style="transform: rotateY(180deg);"></video>
            </div>

            <div class="fixed-top row align-items-start justify-content-end px-5">
                <div class="col-md-4 text-left">
                    <nav class="navbar navbar-light bg-transparent border-0 justify-content-start">
                        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </nav>
					
					<div class="collapse" id="navbarToggleExternalContent" style="z-index: 1000;">
						<div class="p-4">
							<h5 class="text-white h4">Collapsed content</h5>
							<h5 class="text-white h4">Collapsed content</h5>
							<hr>
							<h5 class="text-white h4">Collapsed content</h5>
							<h5 class="text-white h4">Collapsed content</h5>
							<h5 class="text-white h4">Collapsed content</h5>
							<h5 class="text-white h4">Collapsed content</h5>
						</div>
					</div>
                </div>
                <div class="col-md-4 text-center"></div>

                <div class="col-md-4 text-right text-white">
                    <h3 id="session-title" class="mb-0"></h3>
                    <h3 id="session-name" class="my-0"></h3>
                    <h1 id="datetime" class="mt-0"></h1>
                    <h5 id="audio-status" class="mb-0"></h5>
                </div>
            </div>

            <div class="fixed-bottom" style="z-index: 10;">

                <div class="row align-items-center px-5">
                    <div class="col text-left">
                        <button type="button" class="btn btn-primary rounded-circle" id="virtual-whiteboard" value="Virtual Whiteboard">
                            <i class="fas fa-pencil-alt fa-2x py-2 m-1"></i>
                        </button>
                    </div>

                    <div class="col text-center"></div>
                    <div class="col text-right"></div>
                </div>

                <div class="row align-items-center px-5">

                    <div class="col text-left">
                        <button type="button" class="btn btn-success rounded-circle" id="mute-audio" onclick="muteAudio()" value="mute-audio" data-toggle="tooltip" data-placement="right" data-html="true" title="<div class='alert alert-success' role='alert'> <ul><li>1. Your audio is now active & un-muted for 10 minutes,</li><li>2. To toggle mute your microphone touch the microphone button,</li><li>3. To hangup your audio touch the red hangup button</li></ul></div>">
                            <i id="change-icons" class="fas fa-microphone fa-9x px-4 m-3"></i>
                        </button>
                        <button type="button" class="btn btn-danger rounded-circle" id="buttonLeaveSession" onmouseup="leaveSession()" value="Leave session" style="margin-bottom: -8rem!important; margin-left: -3rem!important;">
                            <i class="fas fa-phone-slash fa-2x py-3 m-1"></i>
                        </button>
                    </div>

                    <div class="col text-center">
						<span></span>
					</div>
                    <!-- for alert box -->

                    <div class="col-md-2 text-right">
                        <div id="video-container" class="" alt="Preview"></div>
                    		<div class="top-centered text-right text-dark p-2">
								<span class="remote-time">10:30 AM</span>
							</div>	
                    		<video class="img-fluid" alt="video"></video>
							<div class="bottom-centered bg-secondary text-white p-2">
								<span class="session-name pull-left">Benjamin</span>, - <span class="session-title pull-left">Scottsdale</span>
								<span class="remote-status pull-right"><i class="fas fa-microphone text-success"></i></span>
							</div>
                    </div>
                    <!-- for user preview box -->

                </div>

                <div class="row align-items-end h-25 px-5 pb-5">
                    
					<div class="col-md-2" id="client-video-container" >
                    	<div class="top-centered text-right text-dark p-2">
							<span class="remote-time">10:30 AM</span>
						</div>	
                    	<video class="img-fluid" alt="client-video"></video>
						<div class="bottom-centered bg-secondary text-white p-2">
							<span class="remote-name">Benjamin</span> <span class="remote-title">Scottsdale</span>
                        	<button class="btn remote-status pull-right"><i class="fas fa-microphone text-success"></i></button>
						</div>
                	</div>

                </div>

            </div>
            <!-- FIXED BOTTOM END -->

        </div>
    </div>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#joinModal').modal('show');
        });
    </script>

	<script type="text/javascript">
        function checkTime(i) {
		  if (i < 10) {
			i = "0" + i;
		  }
		  return i;
		}

		function startTime() {
		  var today = new Date();
		  var h = today.getHours();
		  var m = today.getMinutes();
		  var s = today.getSeconds();
		  var ampm = h >= 12 ? 'PM' : 'AM';
		  h = h % 12;
		  h = h ? h : 12; // the hour ’0′ should be ’12′
		  // add a zero in front of numbers<10
		  m = checkTime(m);
		  s = checkTime(s);
		  document.getElementById('datetime').innerHTML = h + ":" + m+ ' ' + ampm;
		  t = setTimeout(function() {
			startTime()
		  }, 500);
		}
		startTime();
	</script>
</body>

</html>