<!doctype html>
<html>
<head>
	<title>Whiteboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
    <script src="js/whiteboard.js"></script>
	
	<style>
.bg-image {
	background: url(images/background.jpg);
	background-position: center;
	background-repeat: no-repeat;
	background-size: cover;
	height: 100vh;
	
}
    .whiteboard .transparent-canvas {
	background-color: rgba(255, 255, 255, 0.9);
}
.whiteboard canvas {
	width: 100%;
	height: 96vh;
}
.whiteboard .canvas-container{
	position: relative;
	z-index: 600;
	height: 100vh;
	width: 100%;
}
.whiteboard #canvas-1 {
	position: relative;
	z-index: 700;
	margin-top: 15px;
}
.whiteboard-button {
	position:absolute;
	left:0.5%;
	top:3%;
	z-index: 800;
	width: 1%;
	display: block;

	
}
.mod-diag {
	max-width: 100%;
	width: 100%;
	max-height: 100%;
	height: 100vh;
	margin: 10px auto;
}
.mod-con {
	background: none;
	border-radius: 0px;
	border: none;
	width:  100%;
	height: 100vh;
}

.whiteboard-close {
	z-index: 900; 
	border-top-left-radius: 100%!important;
	border-radius: 0px;
	position: absolute;
	bottom: 0px;
	right: 0px;
}

.whiteboard-open {
	z-index: 900; 
	border-top-right-radius: 100%!important;
	border-radius: 0px;
	position: absolute;
	bottom: 0px;
	left: 0px;
}

</style>
	
</head>
<body>
	<div class="container-fluid bg-image text-white">
		<div class="row">
        	<div class="col whiteboard">
				<div class="canvas-container mod-dia" id="canvas-container">
					<div class="mod-con" >
						<div class="btn-group whiteboard-button">
							
						
							<button type="button" class="btn rounded-circle btn-dark m-1 p-4" onclick="wb1.options.strokeStyle='black'"></button>
							<button type="button" class="btn rounded-circle btn-danger m-1 p-4" onclick="wb1.options.strokeStyle='red'"></button>
							<button type="button" class="btn rounded-circle btn-success m-1 p-4" onclick="wb1.options.strokeStyle='green'"></button>
							<button type="button" class="btn rounded-circle btn-primary m-1 p-4" onclick="wb1.options.strokeStyle='blue'"></button>
							<button type="button" class="btn rounded-circle btn-warning m-1 p-4" onclick="wb1.options.strokeStyle='orange'"></button>
							
                        	<!--
							<button type="button" class="btn rounded-circle btn-transparent text-dark pl-2" id='eraser' ><i class="fas fa-eraser fa-2x"></i></button>
							<button type="button" class="btn rounded-circle btn-default m-1" onclick="wb1.options.lineWidth=1">10</button>
							<button type="button" class="btn rounded-circle btn-default m-1" onclick="wb1.options.lineWidth=3">20</button>
							<button type="button" class="btn rounded-circle btn-default m-1" onclick="wb1.options.lineWidth=5">30</button>
							-->
							<button type="button" class="btn rounded-circle btn-transparent text-dark pl-2" onclick="wb1.clean();"><i class="fas fa-trash-alt fa-2x"></i></button>
                        	
                        	<a id="download" download="screenshot-<?php echo date(dmY); ?>.jpg">
								<button type="button" class="btn rounded-circle btn-transparent text-dark pl-1" onClick="download()"><i class="fas fa-download fa-2x"></i></button>
							</a>
						
						</div>
						<div class="">
						<!-- Note that the id of our canvas is #myCanvas -->
						<canvas class="transparent-canvas" id="canvas-1" width="1920" height="900">Sorry, your browser doesn't support the &lt;canvas&gt; element.</canvas>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</body>	

	<script type="text/javascript">
		function download() {
			var download = document.getElementById("download");
			var image = document.getElementById("canvas-1").toDataURL("image/jpg")
				.replace("image/jpg", "image/octet-stream");
			download.setAttribute("href", image);
			//download.setAttribute("download","archive.jpg");
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

</html>