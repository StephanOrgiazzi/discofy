<?php

ob_start();

session_start();

$timezone = date_default_timezone_set("Europe/Paris");

$connect = mysqli_connect("sql100.byethost18.com", "b18_21479209", "glengary", "b18_21479209_discofy");

if (mysqli_connect_errno()) {
    echo "Failed to connect:" . mysqli_connect_errno;
}

?>
