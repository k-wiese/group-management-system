<?php
session_start();

if($_SESSION['logged_in'] !== true)
{
    header('Location:/../index.php');
    exit();
}

unset($_SESSION['logged_in']);

session_destroy();
header('Location:/../index.php');

