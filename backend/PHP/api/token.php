  <?php

  /* This is to check
    whether token is available 
    and get to know who you are

    require: $headers['Authorization']
    publicity: private

    return: jump to login page if verification failed
  */

  require_once '../app/CORS.php';
  require_once '../app/StatusCode.php';
  require_once '../app/Token.php';

  $headers = apache_request_headers();

  try {
    if (!isset($headers['Authorization'])  || !Token::verification(trim($headers['Authorization']))) {
      https(401);
      header("location:http://127.0.0.1:5500/frontend/src/html/login.html");
      die("Please login first!");
    }
  } catch (\Throwable $th) {
    header("location:http://127.0.0.1:5500/frontend/src/html/login.html");
    die("Please login first!");
  }

  $username = Token::decode($headers['Authorization'])->username;
  $userid = Token::decode($headers['Authorization'])->userid;
  ?>