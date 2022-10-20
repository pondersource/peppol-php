<?php
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
  foreach($countries as $cc => $countryName) {
    echo "          <option value=\"$cc\" " .
    (isset($_POST["cc"]) && $_POST["cc"] == $cc ? "selected" : "") .
    ">$countryName</option>\n";
  }
  ?>
        </select>
      </div>
      <div>
        <label for="vatnum">Enter your VAT number</label>
        <input type="text" name="vatnum" value="<?php  if (isset($_POST["vatnum"])) { echo $_POST["vatnum"]; } ?>"/>
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
    echo "Valid!";
  } else {
    echo "Not valid!";
  }
  var_dump($result);
}
?>
    <div>
  </body>
</html>