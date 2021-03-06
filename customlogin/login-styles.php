<?php
header("Content-type: text/css; charset: UTF-8");


?>

html {
	background-color: <?php echo $brandColor; ?> !important;
	}

body.login {
	background-color: <?php echo themeblvd_get_option( 'login_background' ); ?>;
	/*background: url('http://bolt.carpeviammarketing.com/wp-content/uploads/2014/04/Large_Cyclists.jpg') no-repeat center 100px;*/
}
#login {
	width: 100%; 
	padding: 0;
}
.login h1 a {
	background-size: auto;
}
h1 {
	margin-bottom: 20px !important;
	background: #fff;
	padding: 40px 0 20px !important;
}
h1 a {
	background: url(images/sinucleanse-logo.png) center top no-repeat !important; 
	width:auto !important;  
	height:65px !important;
}
.login form {
	/*background-color: #272525 !important;*/
	background: none;
	padding: 50px 20% 0 !important;
	width: 60%;
	height: 221px;
	margin-left: 0 !important;
	box-shadow: none !important;
	border: none !important;
}
.login form .input, .login input[type="text"] {
	background: #fff;
}
.login .message {
	margin: 0 auto !important;
	width: 58%;
}
.login label {
	color: #fff !important;
}
.login #nav {
	float: right;
	margin: 10px 20% 10px 0;
}
.login #nav a {
	color: #fff !important;
	text-shadow: none !important;
}
.login #backtoblog {
	float: left; 
	margin: 10px 0 10px 20%;
}
.login #backtoblog a {
	color: #fff !important;
	text-shadow: none !important;
}
.wp-core-ui .button-primary {
	color: #fff !important;
	border: none !important;
	border-bottom: 0px solid #d0881e !important;
	border-radius: 4px !important;
	background: #39D52D;
	transition: all 0.25s ease;
	text-transform: uppercase;
	font-weight: bold;
	box-shadow: 0 0px 0 rgba(0,0,0,0.15) inset;
}
.wp-core-ui .button-primary:hover {
	color: #fff !important;
	background: #39D52D;
	box-shadow: 0 0 0 26px rgba(0,0,0,0.1) inset;
}

@media only screen and (min-width: 1024px) {
	.login form {
		padding: 50px 30% 0 !important;
		width: 40%;
	}
	.login .message {
		margin: 0 auto !important;
		width: 38%;
	}
	.login #nav {
		margin: 10px 30% 10px 0;
	}
	.login #backtoblog {
		margin: 10px 0 10px 30%;
	}
}
        
@media only screen and (max-width: 440px) {
	body.login {
		padding-bottom: 40px !important;
		background-position: 78% 170px;
	}
	#login {
		width: auto;
		padding: 0 !important;
	}
	h1 {
		padding: 14px 0 1px !important;
	}
	h1 a {
		background-size: 50% !important;
		height: 65px !important;
	}
	.login label {
		color: #fff !important;
	}
	.login #nav a {
		color: #fff !important;
	}
	.login #backtoblog a {
		color: #fff !important;
	}
	.login form {
		width: auto !important;
		padding: 10px 20px 0 !important;
	}
	.login .message {
		margin: 0 20px !important;
		width: auto;
	}
	.login #nav {
		margin: 0 0 20px !important;
		padding: 0 !important;
		float: none;
		width: 100%;
		text-align: center;
	}
	.login #backtoblog {
		margin: 0 0 20px !important;
		padding: 0 !important;
		float: none;
		width: 100%;
		text-align: center;
	}
}