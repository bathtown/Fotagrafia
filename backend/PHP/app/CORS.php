  <?php
  // accessable headers
  header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');

  // preflight request
  $method = $_SERVER['REQUEST_METHOD'];
  if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
  }
  ?>