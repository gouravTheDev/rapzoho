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
      'grant_type' => 'authorization_code',
      'scope' => 'ZohoBooks.invoices.CREATE,ZohoBooks.invoices.READ,ZohoBooks.invoices.UPDATE,ZohoBooks.invoices.DELETE'
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
  $result = json_decode($result);
  print_r($result);
  // echo $result;
  $accessToken = $result->access_token;
  $refreshToken = $result->refresh_token;
  // echo "Access Token:- ".$accessToken;

  $_SESSION['accessToken'] = $result->access_token;;
  $_SESSION['refreshToken'] = $result->refresh_token;
  if ($result->access_token && !empty($result->access_token)) {
    //GEt organization details
      $url = 'https://books.zoho.com/api/v3/organizations';
        
      //Initiate cURL.
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $header = array();
      $header[] = 'Authorization: Zoho-oauthtoken '.$result->access_token;
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      //Execute the cURL request.
      $response = curl_exec($ch);
       
      //Check for errors.
      if(curl_errno($ch)){
          //If an error occured, throw an Exception.
          throw new Exception(curl_error($ch));
      }
       
      //Print out the response.
      echo $response;
  }
}
?>
<div class="container text-center">
  <h1>Welcome to RAP Guru - ZoHo Admin Panel</h1>
  <h2>Dashboard</h2>
  <?php 
    // if ($_SESSION['accessToken'] && !empty($_SESSION['accessToken'])) {
    //   // Generate access token from refresh token

    //   //Call API
    //   $accessToken = $_SESSION['accessToken'];
    //   print_r($_SESSION);
    //   echo "Access Token:- ".$accessToken;
      
    //   //GEt organization details
    //   $url = 'https://books.zoho.com/api/v3/organizations';
        
    //   //Initiate cURL.
    //   $ch = curl_init($url);
    //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //   $header = array();
    //   $header[] = 'Authorization: Zoho-oauthtoken '.$accessToken;
    //   curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //   //Execute the cURL request.
    //   $response = curl_exec($ch);
       
    //   //Check for errors.
    //   if(curl_errno($ch)){
    //       //If an error occured, throw an Exception.
    //       throw new Exception(curl_error($ch));
    //   }
       
    //   //Print out the response.
    //   echo $response;
    // }
  ?>
</div>


