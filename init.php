<?php
session_start();

function redirect($url) {
    header("location:$url.php");
    die();
}

?>