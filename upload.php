<?php

$target_dir = "/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


$handle = fopen('april.log','r') or die ('File opening failed');
$requestsCount = 0;
$num404 = 0;
$lines = 0;


//Finds the 404 and number of lines
while (!feof($handle)) {
    $lines++;
    $dd = fgets($handle);
    $requestsCount++;
    $parts = explode('"', $dd);
    $statusCode = substr($parts[2], 0, 4);
    if (hasRequestType($statusCode, '404')) $num404++;
}

echo "Total 404 Requests: " . $num404 . "\n";
echo "Total lines:" . $lines . "\n";
fclose($handle);

function hasRequestType($l,$s) {
        return substr_count($l,$s) > 0;
}

//File Download

header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename('file.txt'));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('file.txt'));
    readfile('file.txt');
    exit;

?>
