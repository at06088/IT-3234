<?php
$target_dir = "/var/www/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$file_name = $_FILES["fileToUpload"]["name"];
$file_tmp =$_FILES['fileToUpload']['tmp_name'];
$path_parts = pathinfo($target_file);

move_uploaded_file($file_tmp,"/var/www/html/uploads/" . $file_name);

//Opens file
$handle = fopen("uploads/" . $file_name,'r') or die ('File opening failed');
//$handle = file_get_contents($file_tmp);
$requestsCount = 0;

//Varibles
$badlines = 0;
$numremote = 0;
$numlocal = 0;
$num404 = 0;
$lines = 0;
$num200 = 0;
$num302 = 0;
$num304 = 0;
$num403 = 0;

//Finds the 404 and number of lines
while (!feof($handle)) {
    $lines++;
    $dd = fgets($handle);
    $requestsCount++;
    $parts = explode('"', $dd);
    $statusCode = substr($parts[2], 0, 4);

    //remote
    if (substr_count($dd, 'remote')) {
    $numremote++;
    }elseif (substr_count($dd, 'local')) {
    $numlocal++;
  }else {
    $badlines++;
  }

    //check for 404
    if (hasRequestType($statusCode, '404')){
      $num404++;
    }elseif (hasRequestType($statusCode, '200')){
      $num200++;
    }
    //check for 302
    elseif (hasRequestType($statusCode, '302')){
      $num302++;
    }
    //304
    elseif (hasRequestType($statusCode, '304')){
      $num304++;
    }
    //403
    elseif (hasRequestType($statusCode, '403')){
      $num403++;
    }
    else {
      $badlines++;
    }

}
echo "Total Rows: " . $lines . "\r\n";
echo "Total number of bad lines: " . $badlines . "\r\n";
echo "Total Size: " . $_FILES['fileToUpload']['size'] . "\r\n";
echo "Total Remote Requests: " . $numremote . "\r\n";
echo "Total local Requests: " . $numlocal . "\r\n";
echo "Total 200 Requests: " . $num200 . "\r\n";
echo "Total 302 Requests: " . $num302 . "\r\n";
echo "Total 304 Requests: " . $num304 . "\r\n";
echo "Total 403 Requests: " . $num403 . "\r\n";
echo "Total 404 Requests: " . $num404 . "\r\n";



//Closes file
fclose($handle);


function hasRequestType($l,$s) {

        return substr_count($l,$s) > 0;

}
//File Download

/*
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $path_parts['filename'] . ".out");
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_name));
    //readfile($file_name);
    exit;


*/
?>
