  <?php

  /* This is to get imgs for browser page

    require: country, city, content
    publicity: public

    return: fail message/img array
  */

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // get Country_RegionCodeISO
  $country = mysql_entities_fix_string($_GET['country']);
  $countryiso = CountryRegionName2CountryRegionCodeISO($country);

  // get CityCode
  $city = mysql_entities_fix_string($_GET['city']);
  $cityCode = CityName2CityCode($city);

  $content = mysql_entities_fix_string($_GET['content']);
  $start = (mysql_entities_fix_string($_GET['page']) - 1) * 8;
  $end = $start + 8;

  // get imgs array
  $img_query = "SELECT PATH, ImageID FROM travelimage WHERE Country_RegionCodeISO='$countryiso' AND CityCode='$cityCode' AND Content='$content' LIMIT $start, $end";
  $page_query = "SELECT PATH, ImageID FROM travelimage WHERE Country_RegionCodeISO='$countryiso' AND CityCode='$cityCode' AND Content='$content'";

  $page_result = $conn->query($page_query);
  $pageNum = (int) ($page_result->num_rows / 8) + 1;

  $img_result = $conn->query($img_query);
  if (!$img_result) die("Fatal Error");

  $img_rows = $img_result->num_rows;
  $imgs = array();
  for ($j = 0; $j < $img_rows; ++$j) {
    $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
    array_push($imgs, [
      'src' => $img_row['PATH'],
      'id' => $img_row['ImageID'],
    ]);
  }
  $img_result->close();

  https(200);
  echo json_encode(array('imgs' => $imgs, 'pageNum' => $pageNum));

  $conn->close();

  ?>
