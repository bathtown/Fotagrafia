  <?php

  include 'PBKDF2.php';

  header('Content-type:text/html;charset=utf-8');
  $username =  trim($_POST['username']);
  $password = trim($_POST['password']);

  $conn = new mysqli('localhost', 'root', '', 'UserInfo', '3306');

  // 检测连接
  if ($conn->connect_error) {
    die("Connect failed: " . $conn->connect_error);
  }
  echo "Connect successfully";

  $sql = "SELECT username, hashPassword From Authority where username='$username'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // 输出数据
    while ($row = mysqli_fetch_assoc($result)) {
      $hashPass = $row["hashPassword"];
    }
  } else {
    echo "<script>alert('Username or password is wrong, please try again!');location='http://127.0.0.1:5500/frontend/src/html/login.html'</script>";
  }

  if (!validate_password($password, $hashPass)) {
    echo "<script>alert('Username or password is wrong, please try again!');location='http://127.0.0.1:5500/frontend/src/html/login.html'</script>";
  } else {
    echo "<script>location='http://127.0.0.1:5500/frontend/src/html/home.html'</script>";
  };

  ?>
