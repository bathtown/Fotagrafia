  <?php

  require_once '../app/CORS.php';
  require_once '../app/StatusCode.php';
  require_once '../app/JwtAuth.php';

  if (isset($_POST['token'])) {
    $token =  trim($_POST['token']);
    $jwt = new JwtAuth();

    if ($jwt->verifyToken($token)) {
      https(200);
      echo json_encode(array("message" => "Token validate!"));
    } else {
      https(401);
      echo json_encode(array("message" => "Token invalidate!"));
    }
  } else {
    https(401);
    echo json_encode(array("message" => "Token invalidate!"));
  }

  ?>