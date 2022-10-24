// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

<?php
  require_once(dirname(__FILE__) . "/vendor/autoload.php");
  use phpseclib3\File\X509;

  error_log("User chose" . var_export($_POST, true));
?>
<html>
  <body>
    <h2>Tell us your VAT number</h2>
    <p></p>
    <form action="" method="post">
      <div>
        <label for="cc">Please choose the country in which your organisation pays VAT:</label>

        <select id="cc" name="cc" required>
<?php
  $countries = [
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
  $selected = (isset($_POST["cc"]) ? $_POST["cc"] : "NL" );
  $vatnum = (isset($_POST["vatnum"]) ? $_POST["vatnum"] : "862637223B01" );
  $server = (isset($_POST["server"]) ? $_POST["server"] : "https://cloud.pondersource.org" );
  $path = (isset($_POST["path"]) ? $_POST["path"] : "/index.php/apps/peppolnext/cert" );
  foreach($countries as $cc => $countryName) {
    echo "          <option value=\"$cc\" " .
     ($cc == $selected ? "selected" : "" ) .
    ">$countryName</option>\n";
  }
  ?>
        </select>
      </div>
      <div>
        <label for="vatnum">Enter your VAT number</label>
        <input type="text" name="vatnum" value="<?php  echo $vatnum; ?>"/>
      </div>
      <div>
        <label for="server">Enter the URL of your bookkeeping server:</label>
        <input type="text" name="server" style="width:50em;" value="<?php  echo $server; ?>"/>
      </div>
      <div>
        <label for="path">Enter your server's cert path:</label>
        <input type="text" name="path" style="width:50em;" value="<?php  echo $path; ?>"/>
      </div>
      <div>
        <input type="submit" value="Check" />
      </div> 
    </form>
    <div>
<?php
if (isset($_POST["cc"]) && isset($_POST["vatnum"])) {
  $client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
  $result = $client->checkVat(array('countryCode' => $_POST["cc"], 'vatNumber' => $_POST["vatnum"]));
  error_log(var_export($result, true));

  if ($result->valid) {
    echo "<p>Your details:</p>";
    echo "<p>Name: '$result->name'</p>";
    echo "<p>Address: '$result->address'</p>";
  
    $certUrl = $server . $path;
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', $certUrl);
  
    $statusCode = $response->getStatusCode();
    //echo $res->getHeader('content-type')[0];
    $responseBody = (string) $response->getBody();
    if($statusCode == 200) {
      if(strlen($responseBody) == 0) {
        echo "Received empty response body from $server$path.";
      } else {
        $cert = new X509;
        $cert->loadX509($responseBody);
        echo "<p>Found cert at $server$path</p>";
        // echo "<p>$responseBody</p>";
        echo "<pre>".$cert->getPublicKey()."</pre>";
      }
    } else {
      echo "Attempt to retrieve cert from $server$path resulted in a $statusCode response code.";
    }
  
    echo "<p>Welcome! Your request to join has been approved.</p>";
    echo "<p>Now please go to the settings in your bookkeeping system (e.g. the PeppolNext app in your Nextcloud server)</p>";
    echo "<p>and set your AS4-to-Peppol gateway to <tt>https://connectyourbooks.com</tt>.</p>";
  } else {
    echo "Not valid!";
  }
}
?>
    <div>
  </body>
</html>