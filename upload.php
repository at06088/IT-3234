<?php
$target_dir = "/var/www/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$size = 0;
$file_name = $_FILES["fileToUpload"]["name"];
$file_tmp = $_FILES['fileToUpload']['tmp_name'];
$size = $_FILES['fileToUpload']['size'];
echo filesize($target_file);
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
    $dd = fgets($handle);
    $requestsCount++;
    $parts = explode('"', $dd);
    $statusCode = substr($parts[2], 0, 4);

    //remote
    if (substr_count($dd, 'remote')) {
    $numremote++;
        $lines++;
    }elseif (substr_count($dd, 'local')) {
    $numlocal++;
        $lines++;
  }elseif (substr_count($dd, '  ')) {
    $badlines++;
  }else{
$spaces++;
  }

    //check for 404
    if (hasRequestType($statusCode, '404')){
      $num404++;
    }elseif (hasRequestType($statusCode, '200')){
      $num200++;
    }
    elseif (hasRequestType($statusCode, '300')){
      $num300++;
    }
    elseif (hasRequestType($statusCode, '301')){
      $num301++;
    }
    elseif (hasRequestType($statusCode, '307')){
      $num307++;
    }
    elseif (hasRequestType($statusCode, '403')){
      $num403++;
    }
    //check for 302
    elseif (hasRequestType($statusCode, '302')){
      $num302++;
    }
    elseif (hasRequestType($statusCode, '400')){
      $num400++;
    }
    //304
    elseif (hasRequestType($statusCode, '304')){
      $num304++;
    }
    //403
    elseif (hasRequestType($statusCode, '401')){
      $num401++;
    }
    elseif (hasRequestType($statusCode, '403')){
      $num403++;
    }
    elseif (hasRequestType($statusCode, '410')){
      $num410++;
    }
    elseif (hasRequestType($statusCode, '500')){
      $num500++;
    }
    elseif (hasRequestType($statusCode, '501')){
      $num501++;
    }
    elseif (hasRequestType($statusCode, '503')){
      $num503++;
    }
    elseif (hasRequestType($statusCode, '550')){
      $num550++;
    }

}
echo "Total Rows: " . $lines . "\r\n";
echo "Total number of bad lines: " . $badlines . "\r\n";
echo "Total Size: " . $size . "\r\n";
echo "Total Remote Requests: " . $numremote . "\r\n";
echo "Total local Requests: " . $numlocal . "\r\n";

if ($num200 != 0) {
  echo "Total 200 Requests: " . $num200 . "\r\n";
}
if($num302 != 0){
  echo "Total 302 Requests: " . $num302 . "\r\n";
}
if ($num304 != 0) {
  echo "Total 304 Requests: " . $num304 . "\r\n";
}
if ($num403 != 0) {
  echo "Total 403 Requests: " . $num403 . "\r\n";
}
if ($num404 != 0) {
  echo "Total 404 Requests: " . $num404 . "\r\n";
}
if ($num300 != 0) {
  echo "Total 300 Requests: " . $num300 . "\r\n";
}
if ($num301 != 0) {
  echo "Total 301 Requests: " . $num301 . "\r\n";
}
if ($num307 != 0) {
  echo "Total 307 Requests: " . $num307 . "\r\n";
}
if ($num400 != 0) {
  echo "Total 400 Requests: " . $num400 . "\r\n";
}
if ($num401 != 0) {
  echo "Total 401 Requests: " . $num401 . "\r\n";
}
if ($num403 != 0) {
  echo "Total 403 Requests: " . $num403 . "\r\n";
}
if ($num410 != 0) {
  echo "Total 410 Requests: " . $num410 . "\r\n";
}
if ($num500 != 0) {
  echo "Total 500 Requests: " . $num500 . "\r\n";
}
if ($num501 != 0) {
  echo "Total 501 Requests: " . $num501 . "\r\n";
}
if ($num503 != 0) {
  echo "Total 503 Requests: " . $num503 . "\r\n";
}
if ($num550 != 0) {
  echo "Total 550 Requests: " . $num550 . "\r\n";
}
//Closes file
fclose($handle);


function hasRequestType($l,$s) {
        return substr_count($l,$s) > 0;
}
//File Download


    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $path_parts['filename'] . ".out");
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_name));
    //readfile($file_name);
    exit;




?>
