<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// get parameter values; must specify date and measurement
$sdate = isset($_GET['start']) ? $_GET['sdate'] : date("Y-m-d");
$edate = isset($_GET['end']) ? $_GET['edate'] : date("Y-m-d");
$starting = isset($_GET['start']) ? $_GET['start'] : '00:00';
$ending = isset($_GET['end']) ? $_GET['end'] : '23:59';
$measure = isset($_GET['measure']) ? $_GET['measure'] : die();
$raw = isset($_GET['raw']) ? filter_var($_GET['raw'], FILTER_VALIDATE_BOOLEAN) : FALSE;
$rawstr = "";

// set raw
if ($raw) {
  $rawstr = "raw/";
}

// create address
$addr = "/home/pi/Documents/testing/sense_hat/data/iter2/" . $rawstr . $measure . "-" . $sdate . ".csv";

// check requested file exists
if(file_exists($addr)) {
  //Setup a PHP array to hold our CSV rows.
  $csvData = array();
  while (TRUE) {
    //Open our CSV file using the fopen function.
    $fh = fopen($addr, "r");
    // boolean to indicate in time frame
    $timeFrame = FALSE;

    //Loop through the rows in our CSV file and add them to
    //the PHP array that we created above.
    while (($row = fgetcsv($fh, 0, ",")) !== FALSE) {
        // TODO hard code: time characters are positions 11-15 in date/time column values
        // check if start time
        if (substr($row[0], 11, 5) === $starting) {
          $timeFrame = TRUE;
        }
        // add value to output
        if ($timeFrame) {
          $temp = array();
          $temp[0] = $row[0];
          $temp[1] = doubleval($row[1]);
          array_push($csvData, $temp);
        }
        // check if end time
        if (substr($row[0], 11, 5) === $ending) {
          $timeFrame = FALSE;
        }
    }

    // iterate date
    if ($sdate !== $edate) {
      $sdate = date("Y-m-d", strtotime("+1 day", strtotime($sdate)));
      $addr = "/home/pi/Documents/testing/sense_hat/data/iter2/" . $rawstr . $measure . "-" . $sdate . ".csv";
    } else {
      break;
    }
  }

  // set response code - 200 OK
  http_response_code(200);
  // show products data in json format
  echo json_encode($csvData);
} else{
    // set response code - 404 Not found
    http_response_code(404);
    // tell the user no products found
    echo json_encode(
        array("message" => "No data found at " . $addr)
    );
}
