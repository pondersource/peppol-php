<?php
class SoapServerGateway {
  public function invoice() {
    foreach(func_get_args() as $result) {
        return json_decode(json_encode($result, true));
    }

  }
}

try {
  $server = new SOAPServer(
    NULL,
    array(
     'uri' => 'http://localhost:8081/server.php'
    )
  );

  $server->setClass('SoapServerGateway');
  $server->handle();
}

catch (SOAPFault $f) {
  print $f->faultstring;
}

?>
