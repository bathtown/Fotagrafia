  <?php

  include 'PBKDF2.php';
  include 'statusCode.php';
  include 'CORS.php';

  $username =  trim($_POST['username']);
  $password = trim($_POST['password']);
  $email = trim($_POST['email']);

  // 密码加盐
  $hashPassword =  create_hash($password);

  // 连接数据库:五个参数 mysqli_connect（‘http地址’，数据库用户名，数据库密码，数据库名，端口号）；
  $conn = new mysqli('localhost', 'root', '', 'UserInfo', '3306');

  // 检测连接
  if ($conn->connect_error) {
    die("Connect failed: " . $conn->connect_error);
  }
  // echo "Connect successfully";

  // 数据库查询，查询是否存在该用户
  $row = mysqli_num_rows(mysqli_query($conn, "SELECT username from Authority where username='$username'"));

  if ($row > 0) {
    // 重名
    https(400);
    echo json_encode("username has been registered!");
    return;
  } else {
    $sql = "INSERT INTO Authority (username, hashPassword, email) VALUES ( '$username','$hashPassword','$email')";
    if ($conn->query($sql) === TRUE) {
      https(200);
      echo json_encode("register successfully!");
    } else {
      https(502);
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  ?>