<!DOCTYPE html>
<html>

<body>

  <?php
  header('Content-type:text/html;charset=utf-8');
  $username =  trim($_POST['username']);
  $password = trim($_POST['password']);
  $repassword = trim($_POST['repassword']);
  $email = trim($_POST['email']);


  if ($password !== $repassword) {
    echo "<script>alert('confirm password must be the same with password!');location='http://127.0.0.1:5500/frontend/src/html/register.html'</script>";
    return;
  }

  // 连接数据库:五个参数 mysqli_connect（‘http地址’，数据库用户名，数据库密码，数据库名，端口号）；
  $conn = new mysqli('localhost', 'root', '', 'UserInfo', '3306');

  // 检测连接
  if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
  }
  echo "连接成功";

  // 数据库查询，查询是否存在该用户
  $row = mysqli_num_rows(mysqli_query($conn, "SELECT username from Authority where username='$username'"));

  if ($row > 0) {
    //数据库查询到结果，重名
    echo "<script>alert('username has been registered!');location='http://127.0.0.1:5500/frontend/src/html/register.html'</script>";
  } else {
    $sql = "INSERT INTO Authority (username, password,email) VALUES ( '$username','$password','$email')";
    if ($conn->query($sql) === TRUE) {
      echo "新记录插入成功";
      header("Location: http://127.0.0.1:5500/frontend/src/html/login.html");
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  ?>

</body>

</html>