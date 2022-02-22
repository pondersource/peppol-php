<?php

function CallAPI($url, $header, $data = false)
{
    $curl = curl_init();
    
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    //GET
    if ($data)
   	 $url = sprintf("%s?%s", $url, http_build_query($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER,$header);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_USERAGENT,$userAgent);
    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

?>
<html>
<body>

<form action="index.php" method="post">

Enter Username: <input type="text" name="username" value="<?php echo $_POST['username']; ?>" /><br />
Enter Token: <input type="text" name="token" value="<?php echo $_POST['token']; ?>" /><br />
<input type="submit" value="submit" name="submit" />

</form>

<?php 

	if (isset($_POST['submit'])) {

$data = array();
$header = array(
	"Accept: application/vnd.github.v3+json",
	"Authorization: token ".$_POST['token']
);


// Shared Storage
$url = sprintf("https://api.github.com/users/%s/settings/billing/shared-storage", $_POST['username']);
$result = CallAPI( $url, $header, $data);
echo '<b>Shared_Storage:</b><br>';
echo $result."<br>";

// Packages
$url = sprintf("https://api.github.com/users/%s/settings/billing/packages", $_POST['username']);
$result = CallAPI( $url, $header, $data);
echo '<b>Packages:</b><br>';
echo $result."<br>";

// Actions
$url = sprintf("https://api.github.com/users/%s/settings/billing/actions", $_POST['username']);
$result = CallAPI( $url, $header, $data);
echo '<b>Actions:</b><br>';
echo $result."<br>";

}
?>

</body>
</html>


