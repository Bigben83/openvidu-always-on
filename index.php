<html>

<head>
    <title>Always-on Video Streaming</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="js/jquery-clockpicker.min.js"></script>
	<link rel="stylesheet" href="css/jquery-clockpicker.min.css">

    <script src="js/openvidu-browser-2.11.0.js"></script>
    <script src="js/app.js"></script>
	
	<link rel="stylesheet" href="css/style.css" />
	<script src="js/whiteboard.js"></script>

    <style>

    </style>
</head>

<body>

    <div id="main" class="container-fluid bg-dark h-100 background-image">

        <div class="modal fade" id="joinModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="joinModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <div id="join">
                            <div class="text-center" id="img-div">
                                <img class="mb-4" src="/images/openvidu_grey_bg_transp_cropped.png" alt="" height="72">
                            </div>
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

                    <div class="collapse bg-dark" id="navbarToggleExternalContent" style="z-index: 1000;">
                        <div class="p-4">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#time-schedule">Time Schedule</button>
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

                    <!-- Whiteboard Button -->
                    <div class="col text-left">
                        <button type="button" class="btn btn-primary rounded-circle" id="virtual-whiteboard" value="Virtual Whiteboard" data-backdrop="false" data-toggle="modal" data-target=".virtual-whiteboard-modal-xl">
                            <i class="fas fa-pencil-alt fa-2x py-2 m-1"></i>
                        </button>
                    </div>

                    <!--  -->
                    <div class="col text-center"></div>
                    <!--  -->
                    <div class="col text-right"></div>
                </div>

                <div class="row align-items-center px-5">

                    <!-- Mute and Hangup Buttons -->
                    <div class="col-md-2 text-left">
                        <button type="button" class="btn btn-success rounded-circle" id="mute-audio" onclick="muteAudio()" value="mute-audio" onmouseover="$('#mute-audio-alert').addClass('in');; return false;" onmouseout="$('#mute-audio-alert').removeClass('in');; return false;">
                            <i id="change-icons" class="fas fa-microphone fa-9x px-4 m-3"></i>
                        </button>
                        <button type="button" class="btn btn-danger rounded-circle" id="buttonLeaveSession" onmouseup="leaveSession()" value="Leave session" style="margin-bottom: -8rem!important; margin-left: -3rem!important;">
                            <i class="fas fa-phone-slash fa-2x py-3 m-1"></i>
                        </button>
                    </div>

                    <!-- Alert box -->
                    <div class="col text-left">
                        <div class='alert alert-success alert-block fade' role='alert' id="mute-audio-alert">
                            <ul class="list-unstyled h4">
                                <li>1. Your audio is now active & un-muted for 10 minutes,</li>
                                <li>2. To toggle mute your microphone touch the microphone button,</li>
                                <li>3. To hangup your audio touch the red hangup button</li>
                            </ul>
                        </div>
                    </div>

                    <!--  -->
                    <div class="col">
                    </div>

                    <!-- Local Video Feed -->
                    <div class="col-md-2">
                        <div id="video-container" class="" alt="Preview"></div>
                        <div class="top-centered text-right text-dark p-2" style="z-index:500;">
                            <span class="remote-time" id="remote-time"></span>
                        </div>
                        <video class="img-fluid" alt="video"></video>
                        <div class="bottom-centered bg-secondary text-white p-2">
                            <span class="remote-name">Benjamin</span> <span class="remote-title">Scottsdale</span>
                            <button class="btn remote-status pull-right"><i class="fas fa-microphone text-success"></i></button>
                        </div>
                    </div>

                </div>

                <div class="row align-items-end h-25 px-5 pb-5">

                    <!-- Remote Video Feeds -->
                    <div class="col-md-2">
                        <div id="client-video-container" class="" alt="Preview"></div>
                        <div class="top-centered text-right text-dark p-2" style="z-index:500;">
                            <span class="remote-time">10:30 AM</span>
                        </div>
                        <video class="img-fluid" alt="client-video"></video>
                        <div class="bottom-centered bg-secondary text-white p-2">
                            <span class="remote-name">Benjamin</span> <span class="remote-title">Scottsdale</span>
                            <button class="btn remote-status pull-right"><i class="fas fa-microphone text-success"></i></button>
                        </div>
                    </div>

                </div>
                <!-- FIXED BOTTOM END -->

            </div>

            <!-- Always-on Time Schedule -->
            <div class="modal fade" id="time-schedule" tabindex="-1" role="dialog" aria-labelledby="time-schedule" aria-hidden="true" style="z-index:2000;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Always-on Time Schedule</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="col">Start:</div>
                                        <div class="col">
                                            <input class="form-control" id="start-time" value="07:00" data-default="07:00">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Stop:</div>
                                        <div class="col">
                                            <input class="form-control" id="end-time" value="17:00" data-default="17:00">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col">Monday:</div>
                                        <div class="col">
                                            <label class="switch">
                                                <input type="checkbox" checked autocomplete="off">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Tuesday:</div>
                                        <div class="col">
                                            <label class="switch">
                                                <input type="checkbox" checked autocomplete="off">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Wednesday:</div>
                                        <div class="col">
                                            <label class="switch">
                                                <input type="checkbox" checked autocomplete="off">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Thursday:</div>
                                        <div class="col">
                                            <label class="switch">
                                                <input type="checkbox" checked autocomplete="off">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Friday:</div>
                                        <div class="col">
                                            <label class="switch">
                                                <input type="checkbox" checked autocomplete="off">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Saturday:</div>
                                        <div class="col">
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Sunday:</div>
                                        <div class="col">
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- WHITEBOARD -->
            <div class="whiteboard modal fade virtual-whiteboard-modal-xl" tabindex="-1" role="dialog" aria-labelledby="virtual-whiteboard" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-x1">
                    <div class="modal-content">
                        <div class="canvas-container" id="canvas-container">
                            <div class="btn-group whiteboard-button">
                                <button type="button" class="btn rounded-circle btn-transparent text-white pl-2" onclick="wb1.clean();"><i class="fas fa-eraser fa-2x"></i></button>

                                <button type="button" class="btn rounded-circle btn-dark m-1 p-4" onclick="wb1.options.strokeStyle='black'"></button>
                                <button type="button" class="btn rounded-circle btn-danger m-1 p-4" onclick="wb1.options.strokeStyle='red'"></button>
                                <button type="button" class="btn rounded-circle btn-success m-1 p-4" onclick="wb1.options.strokeStyle='green'"></button>
                                <button type="button" class="btn rounded-circle btn-primary m-1 p-4" onclick="wb1.options.strokeStyle='blue'"></button>
                                <button type="button" class="btn rounded-circle btn-warning m-1 p-4" onclick="wb1.options.strokeStyle='orange'"></button>
                                <!--
								<button type="button" class="btn rounded-circle btn-default m-1" onclick="wb1.options.lineWidth=1">10</button>
								<button type="button" class="btn rounded-circle btn-default m-1" onclick="wb1.options.lineWidth=3">20</button>
								<button type="button" class="btn rounded-circle btn-default m-1" onclick="wb1.options.lineWidth=5">30</button>
								-->
                                <a id="download" download="screenshot-<?php echo date(dmY); ?>.png">
                                    <button type="button" class="btn rounded-circle btn-transparent text-dark pl-2" onClick="download()"><i class="fas fa-download fa-2x"></i></button>
                                </a>

                            </div>
                            <div class="">
                                <!-- Note that the id of our canvas is #myCanvas -->
                                <canvas class="transparent-canvas" id="canvas-1" width="900" height="400">Sorry, your browser doesn't support the &lt;canvas&gt; element.</canvas>
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary pb-4 pl-4 pt-5 pr-5 whiteboard-open">
                                    <span aria-hidden="true"><i class="fas fa-check fa-2x"></i></span>
                                </button>
                                <button type="button" class="bottom-align-text btn btn-secondary pb-4 pr-4 pt-5 pl-5 whiteboard-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fas fa-times fa-2x"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

	</div>
    
    <script type="text/javascript">
		// Tooltips Initialization
		$(function () {
  			$('[data-toggle="tooltip"]').tooltip()
		})
    
    	function download() {
			var download = document.getElementById("download");
			var image = document.getElementById("canvas-1").toDataURL("image/png")
				.replace("image/png", "image/octet-stream");
			download.setAttribute("href", image);
			//download.setAttribute("download","archive.png");
		}
    
    	'use strict';

		var wb1 = new Whiteboard('canvas-1', wb1_bufferHandler, {globalAlpha: 0.75});

		function wb1_bufferHandler(buff, opt) {
			opt.strokeStyle = '#fff';
			opt.lineWidth = 1;
		}

		function wb2_bufferHandler(buff, opt) {
			gradient.addColorStop('0', 'magenta');
			gradient.addColorStop('0.25', 'blue');
			gradient.addColorStop('0.50', 'red');
			gradient.addColorStop('0.75', 'yellow');
			gradient.addColorStop('1', 'green');

			opt.strokeStyle = gradient;
			wb1.draw(buff, opt);
			opt.lineWidth = 30;
		}
	</script>

    
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#joinModal').modal('show');
        });
    </script>
    
    
	<script type="text/javascript">
		var input = $('#start-time');
		input.clockpicker({
			autoclose: true
		});
    
    	var input = $('#end-time');
		input.clockpicker({
			autoclose: true
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
          document.getElementById('remote-time').innerHTML = h + ":" + m+ ' ' + ampm;
		  t = setTimeout(function() {
			startTime()
		  }, 500);
		}
		startTime();
	</script>
</body>

</html>