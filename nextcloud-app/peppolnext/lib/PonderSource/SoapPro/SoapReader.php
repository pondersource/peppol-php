<?php

namespace OCA\PeppolNext\PonderSource\SoapPro;

class SoapReader
{

    private $types = [];

    public function addType($alias, $name, $type) {
        if (isset($alias)) {
            $tag = "$alias:$name";
        }
        else {
            $tag = $name;
        }
        $types[$tag] = $type;
        return $this;
    }

    public function read($content) {
        $content = trim(substr(trim($content), 1));

        list($tag, $content) = SoapReader::split($content, ' ');

        list($ns_alias, $name) = SoapReader::split($tag, ':');

        list($content_properties, $content) = SoapReader::split($content, '>');

        $properties = [];
        $raw_properties = [];
        $ns_url = null;

        $read_body = true;

        if (isset($content_properties)) {
            while (strlen($content_properties) > 0) {
                if ($content_properties == '/') {
                    $content_properties = '';
                    $read_body = false;
                    break;
                }

                list($raw_key, $content_properties) = SoapReader::split($content_properties, '=');
                list($key_ns, $key_name) = SoapReader::split($raw_key, ':');

                list($value, $content_properties) = SoapReader::split(substr($content_properties, 1), '"');

                if (isset($key_ns)) {
                    if ($key_ns == 'xmlns') {
                        if ($ns_alias == $key_name) {
                            $ns_url = $value;
                        }
                    }
                    else if ($key_ns == $ns_alias) {
                        $properties[$key_name] = $value;
                    }
                    else {
                        echo "Skipping out of scope ns '$key_ns'\n";
                    }
                }
                else {
                    $raw_properties[$key_name] = $value;
                }
            }
        }

        if ($read_body) {
            $end_tag = '</' . (isset($ns_alias) ? "$ns_alias:" : '') . $name . '>';

            $content = trim(substr($content, 0, -strlen($end_tag)));

            if (!strpos($content, '<')) {
                $value = $content;
                $content = '';
            }
            else {
                $value = null;
            }
        }
        else {
            $value = null;
        }

        $type = $this->types[$tag];

        if (isset($type)) {
            $soap = new $type($name, $ns_alias, $ns_url, $properties, $raw_properties, $value);
        }
        else {
            echo "type not found for tag '$tag'. Using Soapable\n";
            $soap = new Soapable($name, $ns_alias, $ns_url, $properties, $raw_properties, $value);
        }

        if ($read_body) {
            while (strlen($content) > 0) {
                list($raw_element, $content) = SoapReader::popElement($content);

                $soap->addElement($this->read($raw_element));
            }
        }

        return $soap;
    }

    private static function popElement($content) {
        $end_of_start = strpos($content, '>');

        if ($content[$end_of_start - 1] == '/') {
            return [substr($content, 0, $end_of_start + 1), trim(substr($content, $end_of_start + 1))];
        }

        // TODO
        $end = SoapReader::findEnd(trim(substr($content, $end_of_start + 1)));
    }

    private static function findEnd($content) {
        if ($content[0] == '<' && $content[1] == '/') {
            return strpos($content, '>');
        }
    }

    private static function split($content, $separator) {
        $cursor = strpos($content, $separator);
        
        if ($cursor) {
            return [trim(substr($content, 0, $cursor)), trim(substr($content, $cursor + 1))];
        }
        else {
            return [null, $content];
        }
    }

}