  <?php

  require_once '../app/CORS.php';
  require_once '../app/StatusCode.php';
  require_once '../app/Token.php';

  $headers = apache_request_headers();

  if (!isset($headers['Authorization'])  || !Token::verification(trim($headers['Authorization']))) {
    https(401);
    die("Please login first!");
  }

  $username = Token::decode($headers['Authorization'])->username;
  $userid = Token::decode($headers['Authorization'])->userid;
  ?>