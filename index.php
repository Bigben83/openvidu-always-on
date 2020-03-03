<html>

<head>
	<title>Always-on Video Streaming</title>

	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

	<!-- Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />

	<!-- Clock Picker Scripts -->
	<script src="js/jquery-clockpicker.min.js"></script>
	<link rel="stylesheet" href="css/jquery-clockpicker.min.css" />

	<!-- Openvidu Scripts -->
	<script src="js/openvidu-browser-2.11.0.js"></script>
	<script src="js/app.js"></script>

	<!-- Additional Scripting -->
	<link rel="stylesheet" href="css/style.css" />

	<!-- Whiteboard Script -->
	<script src="js/whiteboard.js"></script>

</head>

<body>

	<div id="main-container" > <!-- class="container-fluid bg-dark h-100" -->

		<div class="modal fade" id="joinModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="joinModalLabel" aria-hidden="true" data-keyboard="false">
			<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
				<div class="modal-content">

					<div class="modal-body">
						<div id="join">
                        	<div class="row justify-content-center">
                        		<div class="col-8 align-self-center">
									<img class="img-fluid" src="/images/openvidu_grey_bg_transp_cropped.png" >
                        		</div>
                            </div>
							<div id="join-dialog" class="vertical-center">
								<h3 class="text-center font-weight-bold">Always on video</h3>
								<form class="needs-validation" onsubmit="joinSession(); return false" novalidate>
									<div class="form-group">
										<label class="mb-0" for="userName">Your Name<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="userName" required>
									</div>
                                	<div class="form-group">
                                    <label class="mb-0" for="userEmail">Your Email</label>
										<input class="form-control" type="email" id="userEmail">
									</div>
									<div class="form-group">
										<label class="mb-0" for="sessionId">Session<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="sessionId" required>
									</div>
                                	<div class="form-group">
										<label class="mb-0" for="location">Location</label>
										<input class="form-control" type="text" id="location" value="Scottsdale">
									</div>
									<p class="text-center">
										<input class="btn btn-lg btn-danger btn-block font-weight-bold" type="submit" name="commit" value="Join Session">
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- SleepModal -->
		<div class="modal bg-dark" id="sleepModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="sleepModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document" style="width: 1080px;max-width: 100%;">
				<div class="modal-content bg-dark">
					<div class="modal-body text-center">
						<div id="col">
							<h2>This feed is in overnight mode for another </h2>
							<h1 id="time-remaining">X hours XX minutes,</h1> <!-- Time remaining goes here -->
							<h2>tap the screen to wake up for XX minutes</h2>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="session" style="display: none;">

			<div id="main-video" class="row no-margin">
				<video autoplay class="" ></video>  <!-- style="transform: rotateY(180deg);" -->
			</div>

			<div class="fixed-top row align-items-start justify-content-end px-4 pt-2">
			
				<div class="col-sm-4 text-left pl-0 dropdown">
					
					<button class="btn btn-link text-dark" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fas fa-ellipsis-h fa-5x"></i>
					</button>
					

					<div class="bg-dark dropdown-menu" aria-labelledby="dropdownMenuButton" style="z-index: 1000;">
						<div class="p-4 ">
                        	<h4 class="text-light">Share Meeting URL</h4>
                        	<input type="text" class="form-control text-danger text-right" id="copy-input">
                        	<button class="btn btn-dark btn-block" type="button" id="copy-button" data-toggle="tooltip" data-placement="button" title="Copy to Clipboard">Copy to Clipboard</button>
                        	<hr>
                        	<h4 class="text-light">Clear Screen</h4>
                        	<button type="button" class="btn btn-warning rounded-circle" id="buttonLeaveSession" onclick="toggleFunction()"><i class="fas fa-eye-slash fa-2x py-2 m-1"></i></button>
							<hr>
                        	<h4 class="text-light">Settings</h4>
							<button type="button" class="btn btn-primary rounded-circle" data-toggle="modal" data-target="#time-schedule"><i class="far fa-clock fa-2x py-2 px-1 m-1"></i></button>
							<button type="button" class="btn btn-secondary rounded-circle" data-toggle="modal" data-target="#user-settings"><i class="fas fa-user-cog fa-2x py-2 m-1"></i></button>
							<hr>
                        	<h4 class="text-light">Camera Controls</h4>
							<button type="button" class="btn btn-success rounded-circle" id="mute-video" onmouseup="muteVideo()" value="Mute Video"><i id="video-icons" class="fas fa-video fa-2x py-2 m-1"></i></button>
                        	<button type="button" class="btn btn-warning rounded-circle" id="switch-camera" onclick="toggleCamera()" value="Switch Camera"><i class="fas fa-camera fa-2x py-2 m-1"></i></button>
                        	<hr>
                        	<h4 class="text-light">Whiteboard</h4>
                        	<button type="button" class="btn btn-primary rounded-circle" id="virtual-whiteboard" value="Virtual Whiteboard" data-backdrop="false" data-toggle="modal" data-target=".virtual-whiteboard-modal-xl"><i class="fas fa-pencil-alt fa-2x py-2 m-1"></i></button>
                        	<button type="button" class="btn btn-secondary rounded-circle" data-toggle="modal" data-target="#whiteboard-settings"><i class="fas fa-cogs fa-2x py-2 m-1"></i></button>
                        	<hr>
                        	<h4 class="text-light">Hangup / Logout</h4>
                        	<button type="button" class="btn btn-danger rounded-circle" id="buttonLeaveSession" onmouseup="leaveRoom()" value="Leave room"><i class="fas fa-phone-slash fa-2x py-2 m-1"></i></button>
                        	<button type="button" class="btn btn-danger rounded-circle" data-toggle="modal" data-target="#logout"><i class="fas fa-sign-out-alt fa-2x py-2 px-1 m-1"></i></button>
						</div>
					</div>
				</div>
				<div class="col-sm-4 text-center"></div>

				<div class="col-sm-4 text-right text-white">
					<h3 id="session-title" class="mb-0"></h3>
					<h3 id="session-name" class="my-0"></h3>
					<h1 id="datetime" class="mt-0"></h1>
					<h5 id="audio-status" class="mb-0"></h5>
					<button type="button" class="btn text-white" id="door-bell" onclick="doorbell()" value="Door Bell" >
    					<i id="ringDB" class="fas fa-bell fa-4x"></i>
					</button>
				</div>
			</div>

			<div class="fixed-bottom align-items-start justify-content-end px-4" style="z-index: 10;">

				<div class="row px-4 toggle">

					<!-- Whiteboard Button -->
					<div class="text-left pl-2">
						<button type="button" class="btn btn-primary rounded-circle" id="virtual-whiteboard" value="Virtual Whiteboard" data-backdrop="false" data-toggle="modal" data-target=".virtual-whiteboard-modal-xl">
							<i class="fas fa-pencil-alt fa-2x py-2 m-1"></i>
						</button>
					</div>

					<!--  -->
					<div class="col-sm col-md text-center"></div>
					<!--  -->
					<div class="col-sm col-md text-right"></div>
				</div>

				<div class="row align-items-end px-2 toggle">

					<!-- Mute and Hangup Buttons -->
					<div class="col-sm-2 col-md-2 col-lg-1 col-xl-1 text-left pl-0">
						<button type="button" class="btn btn-danger rounded-circle" id="mute-audio" onclick="muteAudio()" value="mute-audio" > <!-- onmouseover="$('#mute-audio-alert').addClass('in');; return false;" onmouseout="$('#mute-audio-alert').removeClass('in');; return false;" -->
							<i id="change-icons" class="fas fa-microphone-slash fa-6x py-3 m-3"></i>
						</button>
					</div>
					<div class="col-sm-1 col-md-1 text-left ml-n3">
						<button type="button" class="btn btn-danger rounded-circle" id="buttonLeaveSession" onmouseup="leaveSession()" value="Leave session">
							<i class="fas fa-phone-slash fa-2x py-2 m-1"></i>
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
					<div class="col"></div>

					<!-- Local Video Feed -->
					<div class="col-2">
						<div id="video-container"></div>
					</div>

				</div>

				<div class="row align-items-end h-25 p-3 toggle">

					<!-- Remote Video Feeds -->
					<div class="col-sm-2">
						<div id="video-container" class="" alt="Preview"></div>

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
												<input type="checkbox" checked autocomplete="off" onclick="dayCheckbox(this, monday);">
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="row">
										<div class="col">Tuesday:</div>
										<div class="col">
											<label class="switch">
												<input type="checkbox" checked autocomplete="off" onclick="dayCheckbox(this, tuesday);">
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="row">
										<div class="col">Wednesday:</div>
										<div class="col">
											<label class="switch">
												<input type="checkbox" checked autocomplete="off" onclick="dayCheckbox(this, wednesday);">
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="row">
										<div class="col">Thursday:</div>
										<div class="col">
											<label class="switch">
												<input type="checkbox" checked autocomplete="off" onclick="dayCheckbox(this, thursday);">
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="row">
										<div class="col">Friday:</div>
										<div class="col">
											<label class="switch">
												<input type="checkbox" checked autocomplete="off" onclick="dayCheckbox(this, friday);">
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="row">
										<div class="col">Saturday:</div>
										<div class="col">
											<label class="switch">
												<input type="checkbox"  onclick="dayCheckbox(this, saturday);">
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="row">
										<div class="col">Sunday:</div>
										<div class="col">
											<label class="switch">
												<input type="checkbox"  onclick="dayCheckbox(this, sunday);">
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
        
        	<!-- USER SETTINGS -->
        	<div class="modal fade" id="user-settings" tabindex="-1" role="dialog" aria-labelledby="user-settings" aria-hidden="true" style="z-index:2000;">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">User Settings</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
                                	<h3>Privacy Timer</h3>

								</div>

								<div class="col-md-6">
                                	<h3>Privacy Timer</h3>

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
        
        	<!-- WHITEBOARD SETTINGS -->
        	<div class="modal fade" id="whiteboard-settings" tabindex="-1" role="dialog" aria-labelledby="whiteboard-settings" aria-hidden="true" style="z-index:2000;">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Whiteboard Settings</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">

								</div>

								<div class="col-md-6">

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
								<a id="download" download="screenshot-<?php echo date(dmY); ?>.jpg">
									<button type="button" class="btn rounded-circle btn-transparent text-dark pl-2" onClick="download()"><i class="fas fa-download fa-2x"></i></button>
								</a>

							</div>
							<div class="">
								<!-- Note that the id of our canvas is #myCanvas -->
								<canvas class="transparent-canvas" id="whiteboard" width="900" height="400">Sorry, your browser doesn't support the &lt;canvas&gt; element.</canvas>
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
		// Clear screen of all Icons
		function toggleFunction(){
			$(".toggle").slideToggle();
		}
    
    	// Tooltips Initialization
		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		})

		function download() {
			var download = document.getElementById("download");
			var image = document.getElementById("whiteboard").toDataURL("image/jpg")
				.replace("image/jpg", "image/octet-stream");
			download.setAttribute("href", image);
			//download.setAttribute("download","archive.jpg");
		}

		'use strict';

		var wb1 = new Whiteboard('whiteboard', wb1_bufferHandler, {
			globalAlpha: 0.75
		});

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

		var input = $('#start-time');
		input.clockpicker({
			autoclose: true
		});

		var input = $('#end-time');
		input.clockpicker({
			autoclose: true
		});

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
			document.getElementById('datetime').innerHTML = h + ":" + m + ' ' + ampm;
			//document.getElementById('remote-time').innerHTML = h + ":" + m+ ' ' + ampm;
			t = setTimeout(function() {
				startTime()
			}, 500);
		}
		startTime();
	</script>
</body>

</html>