  <?php

  /* This is to get hot choices

    require:
    publicity: public

    return: a message/choices array
  */

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // get imgs array
  // Select * From tablename order By rand() Limit num
  $city_query = "SELECT CityCode, count( CityCode ) AS count FROM travelimage GROUP BY CityCode ORDER BY count DESC LIMIT 3";
  $country_query = "SELECT Country_RegionCodeISO, count( Country_RegionCodeISO ) AS count FROM travelimage GROUP BY Country_RegionCodeISO ORDER BY count DESC LIMIT 3";
  $content_query = "SELECT Content, count( Content ) AS count FROM travelimage GROUP BY Content ORDER BY count DESC LIMIT 3";

  $city_result = $conn->query($city_query);
  $country_result = $conn->query($country_query);
  $content_result = $conn->query($content_query);

  // if (!$city_result || !$country_result || !$$content_result) die("Fatal Error");

  $hots = array('city' => [], 'country' => [], 'content' => []);

  $city_rows = $city_result->num_rows;
  for ($j = 0; $j < $city_rows; ++$j) {
    $city_row = $city_result->fetch_array(MYSQLI_ASSOC);
    array_push($hots['city'], CityCode2CityName($city_row['CityCode']));
  }

  $country_rows = $country_result->num_rows;
  for ($j = 0; $j < $country_rows; ++$j) {
    $country_row = $country_result->fetch_array(MYSQLI_ASSOC);
    array_push($hots['country'], CountryRegionCodeISO2CountryRegionName($country_row['Country_RegionCodeISO']));
  }

  $content_rows = $content_result->num_rows;
  for ($j = 0; $j < $content_rows; ++$j) {
    $content_row = $content_result->fetch_array(MYSQLI_ASSOC);
    array_push($hots['content'], $content_row['Content']);
  }

  https(200);
  echo json_encode($hots);

  $city_result->close();
  $country_result->close();
  $content_result->close();

  $conn->close();
  ?>
