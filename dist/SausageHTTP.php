<?php 
/**
 * @author Clinton Nzedimma (c) 2019
 * @package Sausage HTTP Package v 0.1.1
 */

class SausageHTTP
{
	public $params;
	private $error_msg_prefix;
	private $errors = [];
	public $response;
	
	function __construct()
	{
		$this->error_msg_prefix = 'SausageHTTP Error: ';
	}

	public function setRequest($params){
		$this->params = $params;
		$allowed_keys = array('URL', 'METHOD', 'OPTIONS', 'HEADER');


		$allowed_http_request_methods = array('GET', 'POST');

		$request_state = [];

		if (isset($this->params['METHOD']) && isset($this->params['URL'])) {
			foreach ($params as $key => $value) {
				if (count($params)  == 4 ) {

					$key = strtoupper($key);

					if (in_array($key, $allowed_keys)) {
						if ($key == 'URL') {
							if (filter_var($value, FILTER_VALIDATE_URL) === false) {
								$e = "Your URL is invalid";
								$this->errors[] = $e;
								throw new Exception($this->error_msg_prefix.$e, 1);	
							} else if (strlen($value) == 0) {
								$e = "Empty URL";
								$this->errors[] = $e;
								throw new Exception($this->error_msg_prefix.$e, 1);	
							} else {
								$request_state['URL'] = true;
							}
						} 


						if ($key == 'METHOD') {
							$value = strtoupper($value);
							if (!in_array($value, $allowed_http_request_methods)) {
								$e = "Invalid Request Method";
								$this->errors[] = $e;
								throw new Exception($this->error_msg_prefix.$e, 1);
							} else {
								$request_state['METHOD'] = true;
							}

						}


						if ($key == 'OPTIONS') {
							$request_state['OPTIONS'] = true;
						}


						if ($key == 'HEADER') {
							if (isset($this->params['METHOD']) && $this->params['METHOD'] == 'POST') {
								$request_state['HEADER'] = true;
							} else if (isset($this->params['METHOD']) && $this->params['METHOD'] == 'GET') {
								$request_state['HEADER'] = true;
							} else {
								$request_state['HEADER'] = false;
	 						}
							
						}
					}
				} 
				
			}
		

		
		} else {
				$e = "Parameter Missing";
				$this->errors[] = $e;
				throw new Exception($this->error_msg_prefix.$e, 1);	
		}

			if (empty($this->errors)) {
				$this->sendRequest();
			}
			
	}


	private function sendRequest()
	{
			//Sending GET request	
			if($this->params['METHOD'] == 'GET') {

			    $ch = curl_init(); 
			    curl_setopt($ch,CURLOPT_URL, trim($this->params['URL'])."?".http_build_query($this->params['OPTIONS']));
			    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			 
			    $output=curl_exec($ch);
			    curl_close($ch);
			    return $this->response =  $output;	
			}


			//Sending POST request
			if ($this->params['METHOD'] == 'POST') {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $this->params['URL']);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $this->params['HEADER']);

				$request = curl_exec($ch);
				curl_close($ch);
				return $this->response =  $request;
			}


		

	}
}

?>