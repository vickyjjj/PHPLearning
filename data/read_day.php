<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$addr = "../../../../home/pi/Documents/testing/sense_hat/data/temperature1/tester.csv";
// check request filed exists
if(file_exists($addr)){
  //Open our CSV file using the fopen function.
  $fh = fopen($addr, "r");
  //Setup a PHP array to hold our CSV rows.
  $csvData = array();

  //Loop through the rows in our CSV file and add them to
  //the PHP array that we created above.
  while (($row = fgetcsv($fh, 0, ",")) !== FALSE) {
      $csvData[] = $row;
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
        array("message" => "No data found.")
    );
}
