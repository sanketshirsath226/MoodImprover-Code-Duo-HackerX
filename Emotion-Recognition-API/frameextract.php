<?php
    $baseFromJavascript = $_POST['base64'];
    $username = $_POST['username'];
    // remove the part that we don't need from the provided image and decode it
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));
    $count = 1;
    while(true)
    {
    if(!file_exists("uploads/{$username}/"."{$username}".$count.".png"))
    {
        $filepath = "uploads/{$username}/"."{$username}".$count.".png";
        file_put_contents($filepath,$data);
        break;
    }
    else
    {
        $count++;
    }
}
?>