  <?php

  /* This is search picture

    require: choice-Content/City/Country/Description/Title, text, page
    publicity: public

    return: img arrages or fail message
  */

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  $choice = ucfirst(mysql_entities_fix_string($_GET['choice']));
  $text = mysql_entities_fix_string(urldecode($_GET['text']));
  // each page has 8 imgs
  $start = (mysql_entities_fix_string($_GET['page']) - 1) * 8;

  if ($choice === 'City') {
    $text = CityName2CityCode($text);
    $img_query = "SELECT * FROM travelimage WHERE CityCode='$text' LIMIT $start, 8";
    $page_query = "SELECT * FROM travelimage WHERE CityCode='$text'";
  } else if ($choice === 'Country') {
    $text = CountryRegionName2CountryRegionCodeISO($text);
    $img_query = "SELECT * FROM travelimage WHERE Country_RegionCodeISO='$text' LIMIT $start, 8";
    $page_query = "SELECT * FROM travelimage WHERE Country_RegionCodeISO='$text'";
  } else {
    $text = '%' . $text . '%';
    $img_query = "SELECT * FROM travelimage WHERE $choice LIKE '$text' LIMIT $start, 8";
    $page_query = "SELECT * FROM travelimage WHERE $choice LIKE '$text'";
  }

  $page_result = $conn->query($page_query);
  $pageNum = ceil($page_result->num_rows / 8);

  $img_result = $conn->query($img_query);
  if (!$img_result || !$page_result) {
    https(401);
    echo 'request failed :(';
    die();
  }

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
  $img_result->close();
  $page_result->close();

  https(200);
  echo json_encode(array('imgs' => $imgs, 'pageNum' => $pageNum));

  $conn->close();

  ?>
