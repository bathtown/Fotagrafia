  <?php

  /* This is to get random imgs

    require: num
    publicity: public

    return: a message/img array
  */

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';

  $num = mysql_entities_fix_string($_GET['num']);

  https(200);
  echo json_encode(array('imgs' => getRadomImg($num)));
  ?>