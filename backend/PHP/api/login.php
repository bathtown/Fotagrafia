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

  $sql = "SELECT Pass, UID From traveluser where UserName='$user'";
  $result = mysqli_query($conn, $sql);

  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $hashPass = $row["Pass"];
    if (validate_password($pass, $hashPass)) {
      https(200);
      echo json_encode(array("message" => "Log in successfully", "token" => Token::lssue($user, $row["UID"])));
    } else {
      https(400);
      echo json_encode(array("message" => "Username or password is wrong, please try again!"));
    }
  } else {
    https(400);
    echo json_encode(array("message" => "Username or password is wrong, please try again!"));
  }

  $result->close();
  $conn->close();

  ?>
