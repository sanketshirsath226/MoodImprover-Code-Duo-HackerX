<?php
// array for final json respone
$response = array();
if (isset($_FILES['fileToUpload']['name'])) {
    // Path to move uploaded files
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $target_path = "uploads/{$username}/";
    if (file_exists($target_path)) {
        deleteDirectory($target_path);
    }
    mkdir($target_path."/");
        
    // getting server ip address
    $server_ip = gethostbyname(gethostname());

    // final file url that is being uploaded
    $file_upload_url = 'http://' . $server_ip . '/' . 'AndroidFileUpload' . '/' . $target_path;
//    $target_path = $target_path . basename($_FILES['fileToUpload']['name']);

    // reading other post parameters

    $response['file_name'] = basename($_FILES['fileToUpload']['name']);
    $response['username'] = $username;
    try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_path.$username.".".substr($_FILES['fileToUpload']['name'],strpos($_FILES['fileToUpload']['name'],".")+1))) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }
        //if(!rename($target_path. basename($_FILES['fileToUpload']['name']),$target_path."/".$username.".".substr($_FILES['fileToUpload']['name'],strpos($_FILES['fileToUpload']['name'],".")+1)))
        {
            $response['error'] = false;
            $response['message'] = 'Rename Failed!';
        }
        // File successfully uploaded
        $response['message'] = 'File uploaded successfully!';
        $response['error'] = false;
        $response['file_path'] = $file_upload_url . basename($username);
    } catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
        header("Location:facedecode.php?username={$username}");
    }
} else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Not received any file!F';
}
echo json_encode($response);

// Echo final json response to client
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
?>