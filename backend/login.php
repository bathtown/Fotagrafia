<!DOCTYPE html>
<html>

<body>

  <?php
  header('Content-type:text/html;charset=utf-8');
  $username =  trim($_POST['username']);
  $password = trim($_POST['password']);

  // 连接数据库:五个参数 mysqli_connect（‘http地址’，数据库用户名，数据库密码，数据库名，端口号）；
  $conn = new mysqli('localhost', 'root', '', 'UserInfo', '3306');

  // 检测连接
  if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
  }
  echo "连接成功";

  $sql = "SELECT id, username, password from Authority where username='$username' AND password='$password';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_num_rows($result);

  if (!$row) {
    echo "<script>alert('密码错误，请重新输入');location='http://127.0.0.1:5500/frontend/src/html/login.html'</script>";
  } else {
    echo "<script>location='http://127.0.0.1:5500/frontend/src/html/home.html'</script>";
  };

  ?>

</body>

</html>