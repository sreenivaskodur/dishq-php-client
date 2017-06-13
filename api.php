<?php
//This is for post method API's
include "base.php";

// $url = "order/add/";
$url = "dish/";



if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $data = json_decode(file_get_contents('php://input'), true);
  $required_fields = array("user_id", "order_id", "order_time", "order_details");
  $empty_fields = array();

foreach ($required_fields as $field) {
    if (!isset($data[$field]) || empty($data[$field]) ) {
        array_push($empty_fields,$field);
    }
}
  $error = new STDClass();
  if(count($empty_fields) > 0){
    $error_message = 'Missing Fields ';
    foreach ($empty_fields as $fields) {
    $error_message.= $fields.", " ;
    }
    $error->message = $error_message;
    $error->response = "Error";
    echo json_encode($error);
  }else{
    $dishq = new \dishqAPI\Dishq($url, "json");
    $details = $dishq->post($data);
    if($details){
        print_r($details);
    }else{
      $error = new STDClass();
      $error->message = "Please check Order details in your request JSON";
      $error->response = "Error";
      echo json_encode($error);
    }
  }
}else{
  $error = new STDClass();
  $error->message = "Bad post request";
  $error->response = "Error";
  echo json_encode($error);
}
