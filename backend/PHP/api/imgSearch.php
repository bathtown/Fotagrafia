  <?php

  /* This is search picture

    require: choice-Content/City/Country/Description/Title
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
  $text = mysql_entities_fix_string($_GET['text']);

  if ($choice === 'City') {
    $text = CityName2CityCode($text);
    $img_query = "SELECT * FROM travelimage WHERE CityCode='$text'";
  } else if ($choice === 'Country') {
    $text = CountryRegionName2CountryRegionCodeISO($text);
    $img_query = "SELECT * FROM travelimage WHERE Country_RegionCodeISO='$text'";
  } else {
    $text = '%' . $text . '%';
    $img_query = "SELECT * FROM travelimage WHERE $choice LIKE '$text'";
  }

  $img_result = $conn->query($img_query);
  if (!$img_result) {
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

  https(200);
  echo json_encode($imgs);

  $conn->close();

  ?>
