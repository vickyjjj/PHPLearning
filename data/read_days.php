<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// get parameter values; must specify date and measurement
$starting = isset($_GET['start']) ? $_GET['start'] : die();
$ending = isset($_GET['end']) ? $_GET['end'] : date("Y-m-d");;
$measure = isset($_GET['measure']) ? $_GET['measure'] : die();
$raw = isset($_GET['raw']) ? filter_var($_GET['raw'], FILTER_VALIDATE_BOOLEAN) : FALSE;
$rawstr = "";

// set raw
if ($raw) {
  $rawstr = "raw/";
}

// create address
$addr = "/home/pi/Documents/testing/sense_hat/data/iter2/" . $rawstr . $measure . "-" . $starting . ".csv";

// check requested file exists
if(file_exists($addr)){
  while (TRUE) {
    //Open our CSV file using the fopen function.
    $fh = fopen($addr, "r");
    //Setup a PHP array to hold our CSV rows.
    $csvData = array();

    //Loop through the rows in our CSV file and add them to
    //the PHP array that we created above.
    while (($row = fgetcsv($fh, 0, ",")) !== FALSE) {
        $csvData[] = $row;
    }
    if ($starting !== $ending) {
      $starting = strtotime("+1 day", strtotime($starting));
      $addr = "../../../../../home/pi/Documents/testing/sense_hat/data/iter2/" . $rawstr . $measure . "-" . $starting . ".csv";
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
