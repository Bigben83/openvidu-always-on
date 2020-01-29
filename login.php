<!DOCTYPE html>
<html lang="en-US">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
        
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<script type="text/javascript" src="https://use.fontawesome.com/1e2844bb90.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">


        <style>
            html, body {
              height: 100%;
            }
            
            body {
              display: -ms-flexbox;
              display: flex;
              -ms-flex-align: center;
              align-items: center;
              padding-top: 40px;
              padding-bottom: 40px;
              background-color: #f5f5f5;
            }
            
            .form-signin {
              width: 100%;
              max-width: 330px;
              padding: 15px;
              margin: auto;
            }
            .form-signin .checkbox {
              font-weight: 400;
            }
            .form-signin .form-control {
              position: relative;
              box-sizing: border-box;
              height: auto;
              padding: 10px;
              font-size: 16px;
            }
            .form-signin .form-control:focus {
              z-index: 2;
            }
            .form-signin input[type="email"] {
              margin-bottom: -1px;
              border-bottom-right-radius: 0;
              border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
              margin-bottom: 10px;
              border-top-left-radius: 0;
              border-top-right-radius: 0;
            }
        </style>
        
    </head>

    <body class="text-center">
        <form class="form-signin">
          <img class="mb-4" src="/images/openvidu_grey_bg_transp_cropped.png" alt="" height="72">
          <h1 class="h3 mb-3 font-weight-bold">Login</h1>
          <h4 class="h4 mb-3 font-weight-normal">Please sign in</h4>
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div>
          <button class="btn btn-lg btn-danger btn-block" type="submit">Sign in</button>
          
          <p class="mt-5 mb-3 text-muted">© <?php echo date('Y');?> - Openvidu</p>
        </form>
    </body>
</html>