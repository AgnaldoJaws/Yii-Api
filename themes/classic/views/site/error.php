<?php
$return = array(
	"success"=> false,
	"message"=> "Internal Server Error",
	"data"=> array(
		"errorCode"=> 500,
		"message"=> "Internal Server Error"
	)
);
header('HTTP/1.1 500 Internal Server Error', true, 500);
echo json_encode($return, JSON_PRETTY_PRINT);
