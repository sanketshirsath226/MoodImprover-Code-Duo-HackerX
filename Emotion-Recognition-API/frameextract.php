<?php
    $baseFromJavascript = $_POST['base64'];;
    // remove the part that we don't need from the provided image and decode it
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));
    $count = 0;
    while(true)
    {
    if(!file_exists("image".$count.".png"))
    {
        $filepath = "image".$count.".png";
        file_put_contents($filepath,$data);
        break;
    }
    else
    {
        $count++;
    }
}
?>