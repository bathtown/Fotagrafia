  <?php

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  $choice = mysql_entities_fix_string($conn, $_GET['choice']);
  $text = '%' . mysql_entities_fix_string($conn, $_GET['text']) . '%';

  // get imgs array
  if ($choice === 'title')
    $img_query = "SELECT * FROM travelimage WHERE Title LIKE '$text'";
  else
    $img_query = "SELECT * FROM travelimage WHERE Description LIKE '$text'";

  $img_result = $conn->query($img_query);
  if (!$img_result) die("Fatal Error");

  $img_rows = $img_result->num_rows;
  $imgs = array();
  for ($j = 0; $j < $img_rows; ++$j) {
    $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
    array_push($imgs, ['src' => htmlspecialchars($img_row['PATH']), 'id' => htmlspecialchars($img_row['ImageID']), 'title' => htmlspecialchars($img_row['Title']), 'description' => htmlspecialchars($img_row['Description'])]);
  }
  $img_result->close();

  https(200);
  echo json_encode(array("imgs" => $imgs));

  $conn->close();

  ?>
