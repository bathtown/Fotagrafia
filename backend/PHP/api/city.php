  <?php

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // get Country_RegionCodeISO
  $country = mysql_entities_fix_string($_GET['country']);
  $country_query = "SELECT ISO FROM geocountries_regions WHERE Country_RegionName='$country'";
  $country_result = $conn->query($country_query);
  if (!$country_result) die("Fatal Error");
  $country_row = $country_result->fetch_array(MYSQLI_ASSOC);
  $countryiso = $country_row['ISO'];
  $country_result->close();

  // get cities array
  $city_query = "SELECT AsciiName FROM geocities WHERE Country_RegionCodeISO='$countryiso' ORDER BY AsciiName ASC";
  $city_result = $conn->query($city_query);
  if (!$city_result) die("Fatal Error");

  $city_rows = $city_result->num_rows;
  $cities = array();
  for ($j = 0; $j < $city_rows; ++$j) {
    $city_row = $city_result->fetch_array(MYSQLI_ASSOC);
    array_push($cities, $city_row['AsciiName']);
  }

  https(200);
  echo json_encode(array("cities" => $cities));

  $city_result->close();
  $conn->close();

  ?>
