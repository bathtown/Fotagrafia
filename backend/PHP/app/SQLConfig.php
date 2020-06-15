  <?php
  $hn = 'localhost'; // host
  $db = 'fotagrafiabackend'; // database
  $un = 'testuser'; // username
  $pw = 'mypassword'; // password

  function mysql_entities_fix_string($string)
  {
    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $pureString = htmlentities(($conn->real_escape_string($string)));

    $conn->close();
    return $pureString;
  }

  ?>
