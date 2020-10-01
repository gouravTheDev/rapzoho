<script>
      if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }
</script>
<?php 
if (isset($_GET['code']) && !empty($_GET['code'])) {
  $code = $_GET['code'];
  $_SESSION['code'] = $code;
  $url = 'https://accounts.zoho.com/oauth/v2/token';

  //The data you want to send via POST
  $fields = [
      'code' => $code, 
      'client_id' => CLIENT_ID, 
      'client_secret' => CLIENT_SECRET, 
      'redirect_uri' => REDIRECT_URI, 
      'grant_type' => 'authorization_code'
  ];

  //url-ify the data for the POST
  $fields_string = http_build_query($fields);

  //open connection
  $ch = curl_init();

  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

  //So that curl_exec returns the contents of the cURL; rather than echoing it
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

  //execute post
  $result = curl_exec($ch);
  echo $result;
  $accessToken = $result->access_token;

  $_SESSION['accessToken'] = $accessToken;
}
?>
<div class="container text-center">
  <h1>Welcome to RAP Guru - ZoHo Admin Panel</h1>
  <?php 
    if ($_SESSION['accessToken']) {
      echo $_SESSION['accessToken'];
    }
  ?>
</div>


