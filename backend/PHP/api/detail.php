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
  if (!$img_result->num_rows) {
    https(404);
    die("Picture not found!");
  }

  $img_rows = $img_result->num_rows;
  for ($j = 0; $j < $img_rows; ++$j) {
    $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
    // title athor description  content	country	city
    $author = UID2UserName(($img_row['UID']));
    $CountryRegionName = CountryRegionCodeISO2CountryRegionName($img_row['Country_RegionCodeISO']);
    $CityName = CityCode2CityName(($img_row['CityCode']));
    https(200);
    echo json_encode([
      'src' => $img_row['PATH'],
      'title' => $img_row['Title'],
      'author' => $author == null ? 'null' : $author,
      'description' => $img_row['Description'] == null ? 'null' : $img_row['Description'],
      'content' => $img_row['Content'] == null ? 'null' : $img_row['Content'],
      'country' => $CountryRegionName == null ? 'null' : $CountryRegionName,
      'city' => $CityName == null ? 'null' : $CityName,
    ]);
  }
  $img_result->close();
  $conn->close();
  ?>
