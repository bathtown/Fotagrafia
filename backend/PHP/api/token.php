  <?php

  require_once '../app/CORS.php';
  require_once '../app/StatusCode.php';
  require_once '../app/Token.php';

  if (isset($_POST['token'])  && Token::verification(trim($_POST['token']))) {
    https(200);
    echo json_encode(array("message" => "Token validate!"));
  } else {
    https(401);
    echo json_encode(array("message" => "Token invalidate!"));
  }

  ?>