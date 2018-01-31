<?php 

include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");

//session_destroy();

if(isset($_SESSION["userLoggedIn"])) {
  $userLoggedIn = $_SESSION["userLoggedIn"];
  echo "<script>userLoggedIn = '$userLoggedIn';</script>";
} else {
  header("Location: register.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <title>Discofy Music</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="assets/js/script.js"></script>
</head>

<body>

	<div id="mainContainer">

		<div id="topContainer">

			<?php include("includes/navBarContainer.php") ?>

			<div id="mainViewContainer">
				<div id="mainContent">