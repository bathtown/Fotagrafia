  <?php

  require_once '../app/StatusCode.php';
  require_once '../app/PBKDF2.php';
  require_once '../app/CORS.php';
  require_once '../app/JwtAuth.php';

  $username =  trim($_POST['username']);
  $password = trim($_POST['password']);

  $conn = new mysqli('localhost', 'root', '', 'UserInfo', '3306');

  // 检测连接
  if ($conn->connect_error) {
    die("Connect failed: " . $conn->connect_error);
  }
  // echo "Connect successfully";

  $sql = "SELECT username, hashPassword From Authority where username='$username'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // 输出数据
    while ($row = mysqli_fetch_assoc($result)) {
      $hashPass = $row["hashPassword"];
    }
  } else {
    https(400);
    echo json_encode(array("message" => "Username or password is wrong, please try again!"));
    return;
  }

  if (!validate_password($password, $hashPass)) {
    https(400);
    echo json_encode(array("message" => "Username or password is wrong, please try again!"));
  } else {
    $jwt = new JwtAuth();
    https(200);
    echo json_encode(array("message" => "Log in successfully", "token" => $jwt->getToken(['jwt_admin', time(), time() + 7200, time() + 60, 'frontend', md5(uniqid('JWT') . time())])));
  };

  ?>
