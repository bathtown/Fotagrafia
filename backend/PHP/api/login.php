  <?php

  require_once '../app/StatusCode.php';
  require_once '../app/PBKDF2.php';
  require_once '../app/CORS.php';
  require_once '../app/Token.php';
  require_once '../app/SQLConfig.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  $user = mysql_entities_fix_string($conn, $_POST['username']);
  $pass = mysql_entities_fix_string($conn, $_POST['password']); // abcd1234

  $sql = "SELECT Pass From traveluser where UserName='$user'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // 输出数据
    while ($row = mysqli_fetch_assoc($result)) {
      $hashPass = $row["Pass"];
    }
  } else {
    https(400);
    echo json_encode(array("message" => "Username or password is wrong, please try again!"));
    return;
  }

  if (!validate_password($pass, $hashPass)) {
    https(400);
    echo json_encode(array("message" => "Username or password is wrong, please try again!"));
  } else {
    https(200);
    echo json_encode(array("message" => "Log in successfully", "token" => Token::lssue($user)));
  };

  $result->close();
  $conn->close();

  ?>
