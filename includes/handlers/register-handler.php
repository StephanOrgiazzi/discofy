<?php

function cleanFormString($input) {
	$input = strip_tags($input);
	$input = str_replace(" ", "", $input);
	return $input;
}

function cleanFormStringUpper($input) {
	$input = strip_tags($input);
	$input = str_replace(" ", "", $input);
	$input = ucfirst(strtolower($input));
	return $input;
}

function cleanFormPassword($input) {
    $input = strip_tags($input);
    // POSSIBLY ADD ANOTHER CLEANER
	return $input;
}


if(isset($_POST["registerButton"])) {
	$username = cleanFormString($_POST["username"]);
	$email = cleanFormString($_POST["email"]);
	$password = cleanFormPassword($_POST["password"]);
    $passwordConfirm = cleanFormPassword($_POST["passwordConfirm"]);
    
    $wasSuccessful = $account->register($username, $email, $password, $passwordConfirm);
    if ($wasSuccessful) {
		$_SESSION["userLoggedIn"] = $username;
        header("Location: index.php");
    }
}

?>