  <?php
  require_once 'SQLConfig.php';
  require_once 'PBKDF2.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  $hashPass = create_hash('abcd1234');
  $query = "UPDATE traveluser SET Pass='$hashPass' WHERE Pass='abcd1234'";
  $result = $conn->query($query);
  if (!$result) die("Database access failed");
  ?>
