<?php
$host = "";
$port = ; 
$ips=array();
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket, 0, $port);
socket_listen($socket);

$clients = array($socket);
$clients_ip=array();
while (true) {
    $changed = $clients;
    socket_select($changed, 0, 10);
    if (in_array($socket, $changed)) {
        $socket_new = socket_accept($socket);
        socket_getpeername($socket_new, $ip);
        $clients[] = $socket_new;
        $clients_ip[$ip] = $socket_new;
        $header = socket_read($socket_new, 1024);
        perform_handshaking($header, $socket_new, $host, $port);
        $ips[]=$ip;
        $found_socket = array_search($socket, $changed);
        unset($changed[$found_socket]);
    }
    if(count($changed)>0)
    {
    foreach ($changed as $changed_socket) { 
        while(socket_recv($changed_socket, $buf, 1024, 0))
        {
            $received_text = unmask($buf);
            $data1 = json_decode($received_text); 
            $status = $data1 -> status;
            if($status=="1"){
                $sender = $data1 -> sender;
                $receiver = $data1 -> receiver;
                $block_status = $data1 -> block_status;
                $response = array(
                    'status' => $status,
                    'sender' => $sender,
                    'receiver' => $receiver,
                    'block_status' => $block_status
                );
            }
            elseif($status=="0"){
                $sender = $data1 -> sender;
                $receiver = $data1 -> receiver;
                $text = $data1 -> message;
                $type = $data1 -> type;
                $response = array(
                    'message' => $text,
                    'sender' => $sender,
                    'receiver' => $receiver,
                    'time' => date('H:i:s', time()),
                    'date' => date('Y-m-d', time()),
                    'type' => $type,
                    'status' => $status
                );
            }
            $myJSON = json_encode($response);
            $response_text = mask($myJSON);   
            @socket_write($clients_ip[$data1->to_ip],$response_text,strlen($response_text));               
            send_message($response_text);
            break 2;
        }

        $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
        if ($buf === false) {
            $found_socket = array_search($changed_socket, $clients);
            socket_getpeername($changed_socket, $ip);
            unset($clients[$found_socket]);
            if (($key = array_search($ip, $ips)) !== false) 
            {
                unset($ips[$key]);
            }
            $ips=array_values($ips);
        }
    }
    }

}
socket_close($sock);
function send_message($msg)
{
    global $clients;
    foreach($clients as $changed_socket)
    {
        @socket_write($changed_socket,$msg,strlen($msg));
    }
    return true;
}
function unmask($text) {
    $length = ord($text[1]) & 127;
    if($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    }
    elseif($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    }
    else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i%4];
    }
    return $text;
}
function mask($text)
{
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if($length <= 125)
        $header = pack('CC', $b1, $length);
    elseif($length > 125 && $length < 65536)
        $header = pack('CCn', $b1, 126, $length);
    elseif($length >= 65536)
        $header = pack('CCNN', $b1, 127, $length);
    return $header.$text;
}
function perform_handshaking($receved_header,$client_conn, $p, $hostort)
{
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach($lines as $line)
    {
        $line = chop($line);
        if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
        {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
    "Upgrade: websocket\r\n" .
    "Connection: Upgrade\r\n" .
    "WebSocket-Origin: $host\r\n" .
    "WebSocket-Location: wss://$host:$port/demo/shout.php\r\n".
    "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn,$upgrade,strlen($upgrade));
}
?>
