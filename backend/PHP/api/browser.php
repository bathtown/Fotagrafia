  <?php

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // get Country_RegionCodeISO
  $country = mysql_entities_fix_string($conn, $_POST['country']);
  $country_query = "SELECT ISO FROM geocountries_regions WHERE Country_RegionName='$country'";
  $country_result = $conn->query($country_query);
  if (!$country_result) die("Fatal Error");
  $country_row = $country_result->fetch_array(MYSQLI_ASSOC);
  $countryiso = htmlspecialchars($country_row['ISO']);
  $country_result->close();

  // get CityCode
  $city = mysql_entities_fix_string($conn, $_POST['city']);
  $city_query = "SELECT GeoNameID FROM geocities WHERE AsciiName='$city'";
  $city_result = $conn->query($city_query);
  if (!$city_result) die("Fatal Error");
  $city_row = $city_result->fetch_array(MYSQLI_ASSOC);
  $cityCode = htmlspecialchars($city_row['GeoNameID']);
  $city_result->close();

  $content = mysql_entities_fix_string($conn, $_POST['content']);

  // get imgs array
  $img_query = "SELECT PATH FROM travelimage WHERE Country_RegionCodeISO='$countryiso' AND CityCode='$cityCode' AND Content='$content'";
  $img_result = $conn->query($img_query);
  if (!$img_result) die("Fatal Error");

  $img_rows = $img_result->num_rows;
  $imgs = array();
  for ($j = 0; $j < $img_rows; ++$j) {
    $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
    array_push($imgs, htmlspecialchars($img_row['PATH']));
  }
  $img_result->close();

  https(200);
  echo json_encode(array("imgs" => $imgs));

  $conn->close();

  ?>
