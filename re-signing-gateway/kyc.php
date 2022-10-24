<?php
// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT
?>
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
  function echoDetailsWebID($webid) {
    echo "<h2>Details from your WebID</h2>";
    echo "<p><strong>WebID:</strong> $webid</p>";
    $client = new \GuzzleHttp\Client();
    if (!str_starts_with($webid, "http")) {
        $webid = "https://" . $webid;
    }
    $response = $client->request('GET', $webid);

    $statusCode = $response->getStatusCode();
    //echo $res->getHeader('content-type')[0];
    $responseBody = (string) $response->getBody();
    if ($statusCode == 200) {
        if (strlen($responseBody) == 0) {
            echo "Received empty response body from $webid.";
        } else {
            // following https://stackoverflow.com/questions/31165989/parsing-turtle-rdf-from-string-to-array
            $graph = new EasyRdf\Graph();
            $graph->parse($responseBody, 'turtle');
            $array = $graph->toRdfPhp();
            unset($graph);
            $pubkey = $array['.']['http://federatedbookkeeping.org/ns/as4#pubkey'][0]['value'];
            echo "<p><strong>AS4 pubkey parsed from your webid profile:</strong></p><pre>$pubkey</pre>";
            return explode("/", $webid)[2];
        }
    } else {
        echo "Attempt to retrieve cert from $webid resulted in a $statusCode response code.";
    }
    return "";
  }

  function echoDetailsVatNum($cc, $vatnum) {
    $client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
    $result = $client->checkVat(array('countryCode' => $cc, 'vatNumber' => $vatnum));
    error_log(var_export($result, true));
  
    if ($result->valid) {
      echo "<h2>Details from your VAT Number</h2>";
      echo "<p><strong>VAT Number:</strong> $vatnum</p>";
      echo "<p><strong>Name:</strong> $result->name</td></tr>";
      echo "<p><strong>Address:</strong> $result->address</p>";
      return $result->address;
    } else {
      echo "VAT Number not valid!";
    }
    return "";
  }
  function echoDetailsCompRegNum($cc, $compregnum) {
    echo "<h2>Details from your Company Registry Number</h2>";
    if ($cc != "NL") {
      echo "<p>Sorry, we don't support the company registry of your country yet.</p>";
      return;
    }
    echo "<p><strong>Company Registry Number:</strong> $compregnum</p>";
    $client = new \GuzzleHttp\Client();
    $apiURL = "https://developers.kvk.nl/test/api/v1/basisprofielen/$compregnum/hoofdvestiging?geoData=false";
    $response = $client->request('GET', $apiURL);

    $statusCode = $response->getStatusCode();
    //echo $res->getHeader('content-type')[0];
    $responseBody = (string) $response->getBody();
    if ($statusCode == 200) {
      if (strlen($responseBody) == 0) {
          echo "Received empty response body from Company Registry.";
      } else {
        $data = json_decode($responseBody);
        $websites = $data->websites;
        if (is_array($websites)) {
          echo "<p>Domain names found:</p><ul>";
          for ($i = 0; $i < count($websites); $i++) {
            echo "<li>" . $websites[$i] . "</li>";
          }
          echo "</ul>";
          return $websites[0];
        } 
      }
    } else {
      echo "Attempt to retrieve company registry data for KvK $compregnum resulted in a $statusCode response code.";
    }
    return "";
  }
  function echoConclusion($domainUsed, $domainAvailable, $address) {
    echo "<h2>Your KYC Status</h2>";
    if (!strlen($domainUsed)) {
      echo "<p>Please configure your WebID.</p>";
      return;
    }
    if (!strlen($domainAvailable)) {
      echo "<p>Please configure your website in your company registry record.</p>";
      echo "<p>Alternatively, you can ask us to manually verify you by sending a letter to: $address.</p>";
      return;
    }
    if ($domainAvailable == $domainUsed) {
      echo "<p>Your request to join has been approved. ";
      echo "Now please go to the settings in your bookkeeping system (e.g. the PeppolNext app in your Nextcloud server) ";
      echo "and set your AS4-to-Peppol gateway to:</p> <pre>http://fwd.connectyourbooks.com</pre>";
      return;
    }
    echo "<p>Please make sure your WebID domain ($domainUsed) matches the first website domain on your company registry ($domainAvailable).</p>";
    echo "<p>Alternatively, you can ask us to manually verify you by sending a letter to: $address.</p>";
  }

  function getCountryCode() {
    return (isset($_POST["cc"]) ? $_POST["cc"] : "NL");
  }
  function getCompRegNum() {
    return (isset($_POST["compregnum"]) ? $_POST["compregnum"] : "90006623");
  }
  function getVatNum() {
    return (isset($_POST["vatnum"]) ? $_POST["vatnum"] : "862637223B01");
  }
  function getWebID() {
    return (isset($_POST["webid"]) ? $_POST["webid"] : "pondersource.com/id");
  }

  function displayForm() {
    $selected = getCountryCode();
    $compregnum = getCompRegNum();
    $vatnum = getVatNum();
    $webid = getWebID();
?>
    <header>
      <h2>Let us forward your invoices!</h2>
      <h2>But first, tell us about your organisation:</h2>
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
          <label for="compregnum"><h3>Enter your company number in your country's registry (e.g. KvK in NL)<h3></label>
          <input type="text" name="compregnum" value="<?php  echo $compregnum; ?>"/>
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
if (isset($_POST["cc"])) {
  $cc = getCountryCode();
  $vatnum = getVatNum();
  $compregnum = getCompRegNum();
  $webid = getWebID();

    $countries = getCountries();
    $country = $countries[$cc];
?>
    <header>
      <h2>Welcome to Connect your Books!</h2>
    </header>
    <article>
<?php
    echo "<h2>Your details:</h2>";
    echo "<p><strong>Country:</strong> $country</p>";

    $domainUsed = echoDetailsWebID($webid);
    $address = echoDetailsVatNum($cc, $vatnum);
    $domainAvailable = echoDetailsCompRegNum($cc, $compregnum);
    echoConclusion($domainUsed, $domainAvailable, $address);
} else {
  displayForm();
}
?>
  </body>
</html>
