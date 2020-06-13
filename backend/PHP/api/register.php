  <?php

  require_once '../app/PBKDF2.php';
  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';

  $username =  trim($_POST['username']);
  $password = trim($_POST['password']);
  $email = trim($_POST['email']);

  // 密码加盐
  $hashPassword =  create_hash($password);

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // 数据库查询，查询是否存在该用户
  $row = mysqli_num_rows(mysqli_query($conn, "SELECT UserName from traveluser where UserName='$username'"));

  if ($row > 0) {
    // 重名
    https(400);
    echo json_encode(array("message" => 'Username has been registered!'));
  } else {
    $now = date('Y-m-d h:i:s');
    $sql = "INSERT INTO traveluser (UserName, Pass, Email, State, DateJoined, DateLastModified) VALUES ( '$username','$hashPassword','$email', 1, '$now', '$now' )";
    if ($conn->query($sql)) {
      https(200);
      echo json_encode(array("message" => "Register successfully!"));
    } else {
      https(502);
      echo json_encode(array("error" => "Register failed!"));
    }
  }

  $conn->close();

  ?>