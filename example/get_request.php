<?php
include 'lib/SausageHTTP.php';

$client = new SausageHTTP\SausageHTTP\SausageHTTP();
$client->setRequest([
		"URL" => 'http://jsonplaceholder.typicode.com/comments', 
		"METHOD" => 'GET', 
		"OPTIONS" => array(
			'postId' => 5
		) 
	]);

echo $client->response;

?>