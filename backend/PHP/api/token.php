  <?php

  /* This is to check
    whether token is available 
    and get who you are

    require: $headers['Authorization']
    publicity: private

    return: :(
  */

  require_once '../app/CORS.php';
  require_once '../app/StatusCode.php';
  require_once '../app/Token.php';

  $headers = apache_request_headers();

  if (!isset($headers['Authorization'])  || !Token::verification(trim($headers['Authorization']))) {
    https(401);
    header("location:http://127.0.0.1:5500/frontend/src/html/login.html");
    die("Please login first!");
  }

  $username = Token::decode($headers['Authorization'])->username;
  $userid = Token::decode($headers['Authorization'])->userid;
  ?>