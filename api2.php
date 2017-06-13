<?php
//This is for get method API's

include "base.php";

// $url = "order/add/";
$url = "dish/";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
  $dishq = new \dishqAPI\Dishq($url, "json");
    $details = $dishq->get($data);
    if($details){
        print_r($details);
    }else{
      $error = new STDClass();
      $error->message = "Please check Order details in your request JSON";
      $error->response = "Error";
      echo json_encode($error);
    }

}else{
  $error = new STDClass();
  $error->message = "Bad GET request";
  $error->response = "Error";
  echo json_encode($error);
}
