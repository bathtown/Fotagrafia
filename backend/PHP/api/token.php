  <?php

  require_once '../app/CORS.php';
  require_once '../app/StatusCode.php';
  require_once '../app/Token.php';

  $headers = apache_request_headers();

  if (isset($headers['Authorization'])  && Token::verification(trim($headers['Authorization']))) {
    https(200);
    echo json_encode(array("message" => "Token validate!"));
  } else {
    https(401);
    echo json_encode(array("message" => "Token invalidate!"));
  }

  ?>