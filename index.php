<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to the site</title>
  </head>
  <body>
    <?php


    $handle = fopen('20190101.log','r') or die ('File opening failed');
    $requestsCount = 0;
    $num404 = 0;

    while (!feof($handle)) {
        $dd = fgets($handle);
        $requestsCount++;
        $parts = explode('"', $dd);
        $statusCode = substr($parts[2], 0, 4);
        if (hasRequestType($statusCode, '404')){
          $num404++;
        }
    }

    echo "Total 404 Requests: " . $num404 . "<br />";
    fclose($handle);

    function hasRequestType($l,$s) {
            return substr_count($l,$s) > 0;
    }




    ?>

  </body>
</html>
