<?php
$socket = @stream_socket_server("tcp://0.0.0.0:12345", $errno, $errstr);
if (!$socket) {
  echo "$errstr ($errno)<br />\n";
} else {
  while ($conn = stream_socket_accept($socket)) {
       $client_request = "";
        // Read until double \r
        while( !preg_match('/\r?\n\r?\n/', $client_request) )
        {
            $client_request .= fread($conn, 1024) . "<br />";
        }

        if (!$client_request) 
        {
            trigger_error("Client request is empty!");
        }
        #echo $client_request."\n\n";
	
	
    $headers = "";
    $headers .= 'HTTP/1.1 200 OK'."\r\n";
	$headers .= 'Content-type: text/plain; charset=UTF-8'."\r\n\r\n";
	$body = $client_request;
    fwrite($conn, $headers . "\r\n" . $body . "\n");
    fclose($conn);
  }
  fclose($socket);
}

