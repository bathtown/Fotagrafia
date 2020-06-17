  <?php
  require_once 'SQLConfig.php';
  require_once 'PBKDF2.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // password add salt
  $hashPass = create_hash('abcd1234');
  $password_query = "UPDATE traveluser SET Pass='$hashPass' WHERE Pass='abcd1234'";
  $password_result = $conn->query($password_query);
  if (!$password_result) die("Database access failed");

  // delete empty path imgs
  $img_query = "DELETE FROM travelimage WHERE PATH IS NULL";
  $img_result = $conn->query($img_query);
  if (!$img_result) die("Database access failed");

  // auto increase
  $auto_query = "ALTER TABLE travelimage CHANGE ImageID ImageID INT(11) NOT NULL AUTO_INCREMENT";
  $auto_result = $conn->query($auto_query);
  if (!$auto_result) die("Database access failed");

  $conn->close();
  ?>
