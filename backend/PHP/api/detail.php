  <?php

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  $imgID = mysql_entities_fix_string($conn, $_GET['imgID']);

  // get imgs array
  $img_query = "SELECT * FROM travelimage WHERE ImageID='$imgID'";

  $img_result = $conn->query($img_query);
  if (!$img_result) die("Fatal Error");

  $img_rows = $img_result->num_rows;
  for ($j = 0; $j < $img_rows; ++$j) {
    $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
    // title athor description  content	country	city
    https(200);
    echo json_encode([
      'src' => htmlspecialchars($img_row['PATH']),
      'title' => htmlspecialchars($img_row['Title']),
      'author' => UID2UserName(htmlspecialchars($img_row['UID'])),
      'description' => htmlspecialchars($img_row['Description']),
      'content' => htmlspecialchars($img_row['Content']),
      'country' => CountryRegionCodeISO2CountryRegionCodeName(htmlspecialchars($img_row['Country_RegionCodeISO'])),
      'city' => CityCode2CityName(htmlspecialchars($img_row['CityCode']))
    ]);
  }
  $img_result->close();
  $conn->close();
  ?>
