<?php
define('DS', DIRECTORY_SEPARATOR);

if (!file_exists('tmp')) {
    if (!mkdir('tmp')) {
        $response['error'] = 'Error: Cannot create tmp dir in the current dir, please check web server permissions.';
        respond($response);
    }
}

if (!function_exists("exec")) {
    $response['error'] = 'Error: PHP exec not available, safe mode?';
    respond($response);
}


if (empty($_POST['image'])) {
    $response['error'] = 'Error: No image data received. Please send a base64 encoded image';
    respond($response);
}

if (!file_put_contents('tmp' . DS . 'check.jpg', base64_decode($_POST['image']))) {
    $response['error'] = 'Error: Failed saving image to disk, please check web server permissions.';
    respond($response);
}

$result = run('"C:\xampp\htdocs\vehicle-parking\openalpr_64\alpr.exe" --country eu --json tmp' . DS . 'check.jpg');

unlink('tmp' . DS . 'check.jpg');

if (empty($result[0])) {
    $response['error'] = 'Error: ALPR returned no result';
    respond($response);
}

$response['data'] = json_decode($result[0], TRUE);
respond($response);

function respond($response)
{
    header('Access-Control-Allow-Origin: *');
    header('Cache-Control: no-cache, must-revalidate');
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}

function run($command)
{
    $output = array();
    exec($command, $output);
    return $output;
}
?>


