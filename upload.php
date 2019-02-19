<?php
$target_dir = "/var/www/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$file_name = $_FILES["fileToUpload"]["name"];
$file_tmp =$_FILES['image']['tmp_name'];

echo $file_name;

move_uploaded_file($file_tmp,"/var/www/html/uploads" . $file_name);

//Opens file
$handle = fopen('april.log','r') or die ('File opening failed');

$requestsCount = 0;

//Varibles

$num404 = 0;
$lines = 0;
$num200 = 0;
$num302 = 0;
$num304 = 0;
$num403 = 0;
$numremote = 0;

//Finds the 404 and number of lines
while (!feof($handle)) {
    $lines++;
    $dd = fgets($handle);
    $requestsCount++;
    $parts = explode('"', $dd);
    $statusCode = substr($parts[2], 0, 4);

    if (hasRequestType($statusCode, 'remote')){
      $numremote++;
    }

    //check for 404
    if (hasRequestType($statusCode, '404')){
      $num404++;
    }
    //Check for 200
    if (hasRequestType($statusCode, '200')){
      $num200++;
    }
    //check for 302
    if (hasRequestType($statusCode, '302')){
      $num302++;
    }
    //304
    if (hasRequestType($statusCode, '304')){
      $num304++;
    }
    //403
    if (hasRequestType($statusCode, '403')){
      $num403++;
    }

}
echo "Total Rows: " . $lines . "\n";
echo "Total Size: " . $_FILES['fileToUpload']['size'] . "\n";
echo "Total Remote Requests: " . $numremote . "\n";
echo "Total 200 Requests: " . $num200 . "\n";
echo "Total 302 Requests: " . $num302 . "\n";
echo "Total 304 Requests: " . $num304 . "\n";
echo "Total 403 Requests: " . $num403 . "\n";
echo "Total 404 Requests: " . $num404 . "\n";



//Closes file
fclose($handle);


function hasRequestType($l,$s) {
        return substr_count($l,$s) > 0;
}
//File Download

/*
header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($fileman));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileman));
    readfile($fileman);
    exit;
*/


?>
