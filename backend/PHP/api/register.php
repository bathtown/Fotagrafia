  <?php

  /* This is to register

    require: username, password, email
    publicity: public

    return: a message
  */

  require_once '../app/PBKDF2.php';
  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';

  $username =  trim($_POST['username']);
  $password = trim($_POST['password']);
  $email = trim($_POST['email']);

  // add salt
  $hashPassword =  create_hash($password);

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // username whether exist
  $row = mysqli_num_rows(mysqli_query($conn, "SELECT UserName from traveluser where UserName='$username'"));

  if ($row > 0) {
    // username exists
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