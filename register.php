<?php
include "includes/config.php";
include "includes/classes/Account.php";
include "includes/classes/Constants.php";

$account = new Account($connect);

include "includes/handlers/register-handler.php";
include "includes/handlers/login-handler.php";

function getInputValue($name)
{
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

?>



<html>
<head>
	<title>Welcome to Discofy!</title>
	<link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
	<div id="background">

		<div id="loginContainer">

			<div id="inputContainer">
				<div class="logo">
					<img src="assets\images\logo.png" alt="discofy logo"><span>Discofy</span>
				</div>
				<form id="loginForm" action="register.php" method="POST">
					<h2>Login to your account</h2>
					<p>
						<?php echo $account->getError(Constants::$loginFailed); ?>
						<label for="loginUsername">Username</label>
						<input id="loginUsername" name="loginUsername" type="text" placeholder="Bruc3Wayne" required>
					</p>
					<p>
						<label for="loginPassword">Password</label>
						<input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" required>
					</p>

					<button type="submit" name="loginButton">LOG IN</button>
					<div class="hasAccountText">
						<span id="hideLogin">Don't have an account yet ? Signup here.</span>
					</div>

				</form>

				<form id="registerForm" action="register.php" method="POST">
					<h2>Create your account</h2>
					<p>
						<?php echo $account->getError(Constants::$usernameCharacters); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<label for="username">Username</label>
						<input id="username" name="username" type="text" placeholder="Bruc3Wayne" value="<?php getInputValue('username')?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<label for="email">Email</label>
						<input id="email" name="email" type="email" placeholder="bruce@wayneenterprise.com" value="<?php getInputValue('email')?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphaNumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacters); ?>
						<label for="password">Password</label>
						<input id="password" name="password" type="password" placeholder="Set your password" required>
					</p>


					<p>
						<label for="passwordConfirm">Confirm Password</label>
						<input id="passwordConfirm" name="passwordConfirm" type="password" placeholder="Confirm your password" required>
					</p>

					<button type="submit" name="registerButton">SIGN UP</button>

					<div class="hasAccountText">
						<span id="hideRegister">Already have an account? Log in here.</span>
					</div>

				</form>

			</div> <!-- inputContainer -->

			<div id="loginText">
				<h1>Get great music, <br />right now</h1>
				<h2>Listen to loads of songs for free</h2>
				<ul>
					<li>Discover music you'll fall in love with</li>
					<li>Create your own playlists</li>
					<li>Follow artists to keep up to date</li>
				</ul>
			</div>

		</div> <!-- loginContainer -->
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
	<?php 
	if (isset($_POST["registerButton"])) {
		echo '	<script>
		$(document).ready(function() {
        	$("#loginForm").hide();
        	$("#registerForm").show();
		});
	</script>';
	} else {
		echo '	<script>
		$(document).ready(function() {
        	$("#loginForm").show();
        	$("#registerForm").hide();
		});
	</script>';
	}
	?>

	<script src="assets/js/register.js" ></script>
</body>
</html>