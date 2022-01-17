<?php

use Sabre\Xml\Service;
class DeserializeInvoice {
  //Use Deserialization
  public function deserializeXML($outputXMLString) {
    $service = new Sabre\Xml\Service();
    $result = $service->parse($outputXMLString);
    return $this->flatten($result);
  }

  public function flatten($array) {
    if (!is_array($array)) {
        // nothing to do if it's not an array
        return array($array);
    }

    $res = array();
    foreach ($array as $value) {
        // explode the sub-array, and add the parts
        $res = array_merge($res, $this->flatten($value));
    }

    return $res;
}
}