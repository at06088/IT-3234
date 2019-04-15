<?php
$target_dir = "/var/www/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$size = 0;
$file_name = $_FILES["fileToUpload"]["name"];
$file_tmp = $_FILES['fileToUpload']['tmp_name'];
$size = filesize($file_name);
//echo filesize($target_file);
$path_parts = pathinfo($target_file);
$out1 = $path_parts['filename'] . ".out";

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
        }else {
          $badlines++;
          $lines--;
          $numremote--;
          continue;
        }


    }elseif (substr_count($dd, 'local')) {
    $numlocal++;
        $lines++;
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
        }else {
          $badlines++;
          $lines--;
          $numlocal--;
          continue;

        }

    }elseif (substr_count($dd, '')) {


  }else{
$spaces++;
  }

}
/*
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
    }else {
      $badlines++;
      //$lines--;
      continue;
    }

}
*/

fopen($out1,"w");
file_put_contents($out1, "Total Rows: " . $lines . "\r\n");

file_put_contents($out1, "Total number of bad lines: " . $badlines .  "\r\n", FILE_APPEND);
file_put_contents($out1, "Total Size: " . $size . "\r\n", FILE_APPEND);
file_put_contents($out1, "Total Remote Requests: " . $numremote . "\r\n", FILE_APPEND);
file_put_contents($out1, "Total local Requests: " . $numlocal . "\r\n", FILE_APPEND);


if ($num200 != 0) {
  file_put_contents($out1, "Total 200 Requests: " . $num200 . "\r\n", FILE_APPEND);
}
if($num302 != 0){
  file_put_contents($out1, "Total 302 Requests: " . $num302 . "\r\n", FILE_APPEND);
}
if ($num304 != 0) {
  file_put_contents($out1, "Total 304 Requests: " . $num304 . "\r\n", FILE_APPEND);
}
if ($num403 != 0) {
  file_put_contents($out1, "Total 403 Requests: " . $num403 . "\r\n", FILE_APPEND);
}
if ($num404 != 0) {
  file_put_contents($out1, "Total 404 Requests: " . $num404 . "\r\n", FILE_APPEND);
}
if ($num300 != 0) {
  file_put_contents($out1, "Total 300 Requests: " . $num300 . "\r\n", FILE_APPEND);
}
if ($num301 != 0) {
  file_put_contents($out1, "Total 301 Requests: " . $num301 . "\r\n", FILE_APPEND);
}
if ($num307 != 0) {
  file_put_contents($out1, "Total 307 Requests: " . $num307 . "\r\n", FILE_APPEND);
}
if ($num400 != 0) {
  file_put_contents($out1, "Total 400 Requests: " . $num400 . "\r\n", FILE_APPEND);
}
if ($num401 != 0) {
  file_put_contents($out1, "Total 401 Requests: " . $num401 . "\r\n", FILE_APPEND);
}
if ($num403 != 0) {
  file_put_contents($out1, "Total 403 Requests: " . $num403 . "\r\n", FILE_APPEND);
}
if ($num410 != 0) {
  file_put_contents($out1, "Total 410 Requests: " . $num410 . "\r\n", FILE_APPEND);
}
if ($num500 != 0) {
  file_put_contents($out1, "Total 500 Requests: " . $num500 . "\r\n", FILE_APPEND);
}
if ($num501 != 0) {
  file_put_contents($out1, "Total 501 Requests: " . $num501 . "\r\n", FILE_APPEND);
}
if ($num503 != 0) {
  file_put_contents($out1, "Total 503 Requests: " . $num503 . "\r\n", FILE_APPEND);
}
if ($num550 != 0) {
  file_put_contents($out1, "Total 550 Requests: " . $num550 . "\r\n", FILE_APPEND);
}
//Closes file
fclose($out1);
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
    readfile($file_name);
    exit;


?>
