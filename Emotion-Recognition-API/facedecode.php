<?php
    $url = $_SERVER['REQUEST_URI'];
    $username = substr($url, strrpos($url, '=' )+1);
    echo $username;
?>