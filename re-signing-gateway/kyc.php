// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

<html>
  <head>
  <style>
      body { background-color: #A3DDDF }
      header { width: 40em; margin: 5em auto; color: white }
      article { width: 40em; margin: 5em auto; padding: 3em; border-radius: 1em; background-color: #FFE4B5 }
      article pre { background-color: grey; padding: 3em; colour: yellow; border-radius: 1em; text-align: center }
      footer { width: 40em; margin: 5em auto; color: white }    </style>
  </head>
  <body>
<?php
  require_once(dirname(__FILE__) . "/vendor/autoload.php");
  use phpseclib3\File\X509;

  error_log("User chose" . var_export($_POST, true));

  function getCountries() {
    return [
      "??" => " --- please select ---",
      "AD" => "Andorra",
      "AT" => "Austria",
      "BE" => "Belgium",
      "BG" => "Bulgaria",
      "CH" => "Switzerland",
      "CY" => "Cyprus",
      "CZ" => "Czechia",
      "DE" => "Germany",
      "EE" => "Estonia",
      "ES" => "Spain",
      "FR" => "France",
      "GB" => "Great Britain",
      "GR" => "Greece",
      "HR" => "Croatia",
      "HU" => "Hungary",
      "IE" => "Ireland",
      "IT" => "Italy",
      "LI" => "Liechtenstein",
      "LT" => "Lithuania",
      "LU" => "Luxemburg",
      "LV" => "Latvia",
      "MC" => "Monaco",
      "ME" => "Montenegro",
      "MK" => "Macedonia",
      "MT" => "Malta",
      "NL" => "The Netherlands",
      "NO" => "Norway",
      "PL" => "Poland",
      "PT" => "Portugal",
      "RO" => "Romania",
      "RS" => "Serbia",
      "SE" => "Sweden",
      "SI" => "Slovenia",
      "SK" => "Slovakia",
      "SM" => "San</optio",
      "TR" => "Turkey",
      "VA" => "Vatican City",
    ];
  }
  function displayForm() {
    $selected = (isset($_POST["cc"]) ? $_POST["cc"] : "NL");
    $vatnum = (isset($_POST["vatnum"]) ? $_POST["vatnum"] : "862637223B01");
    $webid = (isset($_POST["webid"]) ? $_POST["webid"] : "pondersource.com/id");
?>
    <header>
      <h2>Tell us your VAT number</h2>
    </header>
    <article>
      <p></p>
      <form action="" method="post">
        <div>
          <label for="cc"><h3>Please choose the country in which your organisation pays VAT:<h3></label>

          <select id="cc" name="cc" required>
<?php
    $countries = getCountries();
    foreach ($countries as $cc => $countryName) {
        echo "          <option value=\"$cc\" " .
         ($cc == $selected ? "selected" : "") .
        ">$countryName</option>\n";
    }
?>
          </select>
        </div>
        <div>
          <label for="vatnum"><h3>Enter your VAT number<h3></label>
          <input type="text" name="vatnum" value="<?php  echo $vatnum; ?>"/>
        </div>
        <div>
          <label for="server"><h3>Enter your WebID:<h3></label>
          <input type="text" name="webid" value="<?php  echo $webid; ?>"/>
        </div>
        <div>
          <input type="submit" value="Check" />
        </div> 
      </form>
      <div>
    </article>
<?php
}
if (isset($_POST["cc"]) && isset($_POST["vatnum"]) && isset($_POST["webid"])) {
  $cc = (isset($_POST["cc"]) ? $_POST["cc"] : "NL");
  $vatnum = (isset($_POST["vatnum"]) ? $_POST["vatnum"] : "862637223B01");
  $webid = (isset($_POST["webid"]) ? $_POST["webid"] : "pondersource.com/id");

  $client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
  $result = $client->checkVat(array('countryCode' => $_POST["cc"], 'vatNumber' => $_POST["vatnum"]));
  error_log(var_export($result, true));

  if ($result->valid) {
    $countries = getCountries();
    $country = $countries[$cc];
?>
    <header>
      <h2>Welcome to Connect your Books!</h2>
    </header>
    <article>
<?php
    echo "<p>Your request to join has been approved. ";
    echo "Now please go to the settings in your bookkeeping system (e.g. the PeppolNext app in your Nextcloud server)";
    echo "and set your AS4-to-Peppol gateway to:</p> <pre>http://fwd.connectyourbooks.com</pre>";

    echo "<h2>Your details:</h2>";
    echo "<p><strong>Name:</strong> $result->name</td></tr>";
    echo "<p><strong>Address:</strong> $result->address</p>";
    echo "<p><strong>Country:</strong> $country</p>";
    echo "<p><strong>VAT Number:</strong> $vatnum</p>";
    echo "<p><strong>WebID:</strong> $webid</p>";

    $client = new \GuzzleHttp\Client();
    if (!str_starts_with($webid, "http")) {
      $webid = "https://" . $webid;
    }
    $response = $client->request('GET', $webid);
  
    $statusCode = $response->getStatusCode();
    //echo $res->getHeader('content-type')[0];
    $responseBody = (string) $response->getBody();
    if($statusCode == 200) {
      if(strlen($responseBody) == 0) {
        echo "Received empty response body from $webid.";
      } else {
        // following https://stackoverflow.com/questions/31165989/parsing-turtle-rdf-from-string-to-array
        $graph = new EasyRdf\Graph();
        $graph->parse($responseBody,'turtle');
        $array = $graph->toRdfPhp();
        unset($graph);
        $pubkey = $array['.']['http://federatedbookkeeping.org/ns/as4#pubkey'][0]['value'];
        echo "<p><strong>AS4 pubkey parsed from your webid profile:</strong></p><pre>$pubkey</pre>";
      }
    } else {
      echo "Attempt to retrieve cert from $webid resulted in a $statusCode response code.";
    }
  } else {
    echo "Not valid!";
  }
} else {
  displayForm();
}
?>
  </body>
</html>
