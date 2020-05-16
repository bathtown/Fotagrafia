  <?php
  include 'statusCode.php';
  include 'CORS.php';

  $token =  trim($_POST['tiken']);
  if ($token === "123") {
    https(302);
    echo true;
  } else {
    https(401);
    echo false;
  }

  ?>