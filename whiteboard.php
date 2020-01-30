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
	<link rel="stylesheet" href="css/style.css" />
	
	
</head>
<body>
	<div class="container-fluid bg-dark h-100 background-image text-white">
	
		<div class="row">
        	<div class="col text-center font-weight-bold">
				<h1 class="">Whiteboard demo</h1>
				<button type="button" class="btn btn-primary rounded-circle" data-backdrop="false" data-toggle="modal" data-target=".virtual-whiteboard-modal-xl"><i class="fas fa-pencil-alt fa-2x py-2 m-1"></i></button>
			</div>
    	</div>
		
		<div class="whiteboard modal fade virtual-whiteboard-modal-xl" tabindex="-1" role="dialog" aria-labelledby="virtual-whiteboard" aria-hidden="false">
			<div class="modal-dialog modal-dialog-centered modal-x1">
				<div class="modal-content">
					<div class="canvas-container" id="canvas-container">
						<div class="btn-group" id="button">
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
                        	<a id="download" download="screenshot-<?php echo date(d_m_Y); ?>.png">
								<button type="button" class="btn rounded-circle btn-transparent text-dark pl-2" onClick="download()"><i class="fas fa-download fa-2x"></i></button>
							</a>
						</div>
						<div class="">
						<!-- Note that the id of our canvas is #myCanvas -->
						<canvas class="transparent-canvas" id="canvas-1" width="900" height="400">Sorry, your browser doesn't support the &lt;canvas&gt; element.</canvas>
						</div>
						<div >
							<button type="button" class="btn btn-secondary pb-4 pr-4 pt-5 pl-5 whiteboard-close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true"><i class="fas fa-times fa-2x"></i></span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
        	<div class="col">
			</div>
    	</div>

	<script type="text/javascript">
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

</body>
</html>