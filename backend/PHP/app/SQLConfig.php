  <?php
  $hn = 'localhost'; // host
  $db = 'fotagrafiabackend'; // database
  $un = 'testuser'; // username
  $pw = 'mypassword'; // password

  function mysql_entities_fix_string($conn, $string)
  {
    return htmlentities(mysql_fix_string($conn, $string));
  }

  function mysql_fix_string($conn, $string)
  {
    return $conn->real_escape_string($string);
  }
  ?>
