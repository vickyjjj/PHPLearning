<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$file="tester.csv";
// $csv= file_get_contents($file);

// check csv has more than one line
if($csv = file_get_contents($file) !== false){
  $array = array_map("str_getcsv", explode("\n", $csv));

  // set response code - 200 OK
  http_response_code(200);

  // show products data in json format
  echo json_encode($array);
} else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No data found.")
    );
}
