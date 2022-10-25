<?php

$countryCodes = array(
'BE' => '0420429375',
'BG' => '130460283',
'CZ' => '8007244542',
'DK' => '73444217',
'DE' => '129273398',
'EE' => '100072174',
'IE' => '9513488W',
'EL' => '094468339',
'ES' => 'A28229813',
'FR' => '27402835961',
'HR' => '24640993045',
'IT' => '01114601006',
'CY' => '10139104E',
'LV' => '40003245752',
'LT' => '100006256115',
'LU' => '20981643',
'HU' => '10773381',
'MT' => '12701906',
'NL' => '808936955B01',
'AT' => 'U37207205',
'PL' => '5220002334',
'PT' => '509250149',
'RO' => '160796',
'SI' => '94995737',
'SK' => '2021879959',
'FI' => '07055792',
'SE' => '556138653201',
'GB' => '277368458');

$client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
$output = "" . date('d M Y H:i:s') . " ";

foreach($countryCodes as $countryCode => $vatNumber)
{
        echo $countryCode . "\r\n";
        $error = '';
        $start = microtime(true);
        try {
                var_dump($client->checkVat(array('countryCode' => $countryCode, 'vatNumber' => $vatNumber)));
        } catch(Exception $e) {
                var_dump($e);
                $error = $e->getMessage();
        }
        $end = microtime(true);
        $time = $end - $start;
        $output .= $countryCode . ":" . ($error == '' ? $time : $error) . " - ";
}

file_put_contents('./vies.log', substr($output, 0, -2) . "\r\n", FILE_APPEND);
