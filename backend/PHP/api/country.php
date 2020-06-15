  <?php

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  $query = "SELECT Country_RegionName FROM geocountries_regions ORDER BY Country_RegionName ASC";
  $result = $conn->query($query);
  if (!$result) die("Fatal Error");

  $rows = $result->num_rows;
  $countries = array();


  for ($j = 0; $j < $rows; ++$j) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    array_push($countries, $row['Country_RegionName']);
  }

  https(200);
  echo json_encode(array("countries" => $countries));

  $result->close();
  $conn->close();

  ?>
