<?php
include "base.php";

$dishq = new \dishqAPI\Dishq("dish/", "json");


    if(isset($_GET[''])){
      $details = $dishq->get($url);
      if($details){
        print_r($details);
      }else{
        $error->message = "Bad get request";
        $error->response = "Error";
        echo json_encode($error);
      }
    }else if($_POST['']){
      $data = $_POST[''];
      $details = $dishq->post($data);
      if($details){
        print_r($details);
      }else{
        $error->message = "Bad post request";
        $error->response = "Error";
        echo json_encode($error);
      }
    }else{
      $error->message = "Request method not mentioned";
      $error->response = "Error";
      echo json_encode($error);
    }
