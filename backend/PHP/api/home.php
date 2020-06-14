  <?php

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // get imgs array
  // Select * From 表 order By rand() Limit n
  $img_query = "SELECT * FROM travelimage ORDER BY rand() LIMIT 7";

  $img_result = $conn->query($img_query);
  if (!$img_result) die("Fatal Error");

  $img_rows = $img_result->num_rows;
  $imgs = array();
  for ($j = 0; $j < $img_rows; ++$j) {
    $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
    array_push($imgs, [
      'src' => $img_row['PATH'],
      'id' => $img_row['ImageID'],
      'title' => $img_row['Title'] == null ? 'null' : $img_row['Title'],
      'description' => $img_row['Description'] == null ? 'null' : $img_row['Description']
    ]);
  }

  https(200);
  echo json_encode($imgs);

  $img_result->close();
  $conn->close();
  ?>