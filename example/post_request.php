<?php
include 'lib/SausageHTTP.php';


/**
* Tips: Please always set HEADER for POST Request
*/

$client = new SausageHTTP\SausageHTTP\SausageHTTP();
$client->setRequest([
		"URL" => 'http://jsonplaceholder.typicode.com/comments', 
		"METHOD" => 'POST', 
		"HEADER" => array(
						'Content-Type: application/json'
					),		
		"OPTIONS" => array(
			'postId' => 5
		) 
	]);

echo $client->response;
?>