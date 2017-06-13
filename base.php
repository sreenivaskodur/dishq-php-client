<?php
/**
 * PHP Wrapper for Dish API
 * GitHub:
 * @author
 * @version 0.1
 */
 namespace dishqAPI;
error_reporting(E_ERROR | E_WARNING | E_PARSE);


class Dishq
{
	//Affiliate ID and token are entered through the constructor

    private $token = "Authorization: Bearer zzh4DGJ0Sg6rSoqG4UBThhC9gKc0id";
    private $response_type;
    private $api_base = 'https://dishq.tech/api/search/';
    private $verify_ssl   = false;

    /**
     * Obtains the values for required variables during initialization
     * @param string $affiliateId Your affiliate id.
     * @param string $token Access token for the API.
     * @param string $response_type Can be json/xml.
     * @return void
     **/
    function __construct($url, $response_type="json")
    {
        $this->response_type = $response_type;
        //Add the affiliateId and response_type to the base URL to complete it.
        $this->api_base.= $url;
    }

    /**
     * Calls the API directory page and returns the response.
     *
     * @return string Response from the API
     **/
    public function post($data){
        if($this->isCleanJSON($data)){
          $data = $this->cleanInputs($data);
          return $this->sendRequest($this->api_base, fasle,$data);
        }else{
          return false;
        }


    }

    /**
     * Used to call URLs that are taken from the API directory.
     * Any change in the URL makes it invalid and the API refuses to respond.
     * The URLs have a timeout of ~4 hours, after which a new URL is to be
     * taken from the API homepage.
     *
     * @return string Response from the API
     **/
    public function get($url){
        return $this->sendRequest($this->api_base , fasle, '');
    }

    /**
     * Used to sanitize the string to post.
     * @return sanitized string
     **/
    private function cleanInputs($data) {
      $clean_input = Array();
      if (is_array($data)) {
          foreach ($data as $k => $v) {
              $clean_input[$k] = $this->cleanInputs($v);
          }
      } else {
          $clean_input = trim(strip_tags($data));
      }
      return $clean_input;
    }




    private function isCleanJSON($data){

      foreach ($data['order_details'] as $value){
        if(!isset($value['dish_id']) || empty($value['dish_id']) || !isset($value['quantity']) || empty($value['quantity'])){
          return false;
        }
      }
      return true;
    }


    /**
     * Sends the HTTP request using cURL.
     *
     * @param string $url The URL for the API
	 * @param int $timeout Timeout before the request is cancelled.
     * @return string Response from the API
     **/
    private function sendRequest($url, $post,$data, $timeout=300){
    	//Make sure cURL is available
    	if (function_exists('curl_init') && function_exists('curl_setopt')){
	        //The headers are required for authentication
	        $headers = array(
            "Content-Type: application/json",
	            $this->token
	            );
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          // if($post){
          //   curl_setopt($ch, CURLOPT_POST, 1);
          //   curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
          // }
	        $result = curl_exec($ch);
	        curl_close($ch);
	        return $result ? $result : false;
	    }else{
            //Cannot work without cURL
			return false;
	    }
    }
}
