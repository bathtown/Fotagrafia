  <?php

  /* This is to get hot imgs showed in home page

    require: num = 7
    publicity: public

    return: a message/img array
  */

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // get imgs array
  // Select * From tablename order By rand() Limit num
  $img_query = "SELECT ImageID, count( ImageID ) AS count FROM travelimagefavor GROUP BY ImageID ORDER BY count DESC LIMIT 7";

  $img_result = $conn->query($img_query);
  if (!$img_result) die("Fatal Error");

  $img_rows = $img_result->num_rows;
  $imgs = array();
  for ($j = 0; $j < $img_rows; ++$j) {
    $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
    array_push($imgs, ImgId2ImgDataAbstract($img_row['ImageID']));
  }

  if ($img_rows < 7)
    $imgs = array_merge($imgs, getRadomImg(7 - $img_rows));

  https(200);
  echo json_encode($imgs);

  $img_result->close();
  $conn->close();
  ?>