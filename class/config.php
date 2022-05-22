<?php


define('SERVER', 'localhost');
define('USER', 'root');
define('PASSWORD','');
define('DB','app-login');

function clearPost($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}