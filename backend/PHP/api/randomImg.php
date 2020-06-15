  <?php

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // get imgs array
  $img_query = "SELECT PATH FROM travelimage WHERE Country_RegionCodeISO='CA' LIMIT 10, 20";
  $img_result = $conn->query($img_query);
  if (!$img_result) die("Fatal Error");

  $img_rows = $img_result->num_rows;
  $imgs = array();
  for ($j = 0; $j < $img_rows; ++$j) {
    $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
    array_push($imgs, $img_row['PATH']);
  }
  $img_result->close();

  https(200);
  echo json_encode(array("imgs" => $imgs));

  $conn->close();

  ?>
