<!doctype html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Video Window</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />
		
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		
		<!-- Optional JavaScript -->
		<link rel="stylesheet" href="css/style.css" type="text/css" media="print">
		<script src="js/openvidu-browser-2.11.0.js"></script>
		<script src="js/app.js"></script>
	
		<style>
			@font-face {
				font-family: 'Eurostile';
				src: url('fonts/EurostileBold.woff2') format('woff2'),
					url('fonts/EurostileBold.woff') format('woff');
				font-weight: bold;
				font-style: normal;
			}
			@font-face {
				font-family: 'Eurostile';
				src: url('fonts/EurostileRegular.woff2') format('woff2'),
					url('fonts/EurostileRegular.woff') format('woff');
				font-weight: normal;
				font-style: normal;
			}
			
			html,body {
			  height: 100%;
			  width:100%;
			}
			
			body {
				font-family: 'Eurostile', arial;
				font-weight: bold;
				font-style: normal;
			}
			
			.background-image {
				background: url(images/background.jpg);
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
			}
		</style>
    </head>
	
	<body>
	<div class="container-fluid bg-dark h-100 background-image">	
		
		<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
              	<h3>Join a video session</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<div id="join">
					<div id="img-div"><img class="img-fluid w-50" src="images/bison-logo.png" alt="Logo" /></div>
					<div id="join-dialog" class="vertical-center">
						
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

		<div class="video-background">
			<div class="row align-items-start justify-content-end h-25 p-5">	
				<div class="col-md-4 text-left">
				    <nav class="navbar navbar-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </nav>
				</div>
				<div class="col-md-4 text-center"></div>
				
				<div class="col-md-4 text-right">
					<h4 class="text-white mb-0">Scottsdale</h4>
					<h4 class="text-white ">Main Office</h4>
					<h1 class="text-white "><?php echo date("g:i A"); ?></h1>
					<h5 class="text-white mb-0">their audio is muted</h5>
				</div>
			</div>
			
			<div class="fixed-bottom">
				
				<div class="row align-items-center h-25 px-5">
					<div class="col text-left">
						<button type="button" class="btn" value="Virtual Whiteboard">
							<span class="fa-stack fa-2x">
							  <i class="fas fa-circle fa-stack-2x text-primary"></i>
							  <i class="fas fa-pencil-alt fa-stack-1x fa-inverse"></i>
							</span>
						</button>
					</div>
					
					<div class="col text-center"></div>
					<div class="col text-right"></div>
				</div>
			
				<div class="row align-items-center h-25 px-5">
					
					<div class="col text-left">
						<button type="button" class="btn" data-toggle="button" aria-pressed="false" autocomplete="off" value="Resume session">
							<span class="fa-stack fa-7x">
							<i class="fas fa-circle fa-stack-2x text-success"></i>
							<i class="fas fa-microphone fa-stack-1x fa-inverse"></i>
							</span>
						</button>
						<button type="button" class="btn" id="buttonLeaveSession" onmouseup="leaveSession()" value="Leave session">
							<span class="fa-stack fa-3x " style="margin-bottom: -7rem!important; margin-left: -5rem!important;">
							  <i class="fas fa-circle fa-stack-2x text-dark"></i>
							  <i class="fas fa-circle fa-stack-2x text-danger"></i>
							  <i class="fas fa-phone-slash fa-stack-1x fa-inverse"></i>
							</span>
						</button>
					</div>

					<div class="col text-center"></div> <!-- for alert box -->
					
					<div class="col-md-2 text-right">
						<img src="images/background.jpg" class="img-fluid" alt="User Preview">
					</div> <!-- for user preview box -->
					
				</div>
				
				<div class="row align-items-end h-25 p-5">
					<div class="col text-white"></div>
				</div>
				
			</div> <!-- FIXED BOTTOM END -->
		</div>

	</div>
	<script type="text/javascript">
    	$(window).on('load',function(){
        	$('#staticBackdrop').modal('show');
    	});
	</script>
	</body>
</html>