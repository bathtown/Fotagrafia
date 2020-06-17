  <?php

  /* This is to upload/modify my uploads

    POST: 

    require: token, title, description, city, country, file, content
    publicity: private,

    return: a message
  */

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';
  require_once '../api/token.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  $title = mysql_entities_fix_string($_POST['title']);
  $contry = CountryRegionName2CountryRegionCodeISO(mysql_entities_fix_string($_POST['contry']));
  $city = CityName2CityCode(mysql_entities_fix_string($_POST['city']));
  $content = mysql_entities_fix_string($_POST['content']);
  $description = mysql_entities_fix_string($_POST['description']);

  $filename = $_FILES['file']['name'];
  $tmp = $_FILES['file']['tmp_name'];

  // ImageID
  // Title
  // Description
  // Latitude
  // Longitude
  // CityCode
  // Country_RegionCodeISO
  // UID
  // PATH
  // Content

  $query = "INSERT INTO travelimage (ImageID, Title, Description, CityCode, Country_RegionCodeISO, UID, Content) VALUES (NULL, '$title', '$description', '$city', '$contry', '$userid', '$content')";
  $result = $conn->query($query);
  if (!$result) die("Database access failed");

  $insertID = $conn->insert_id;

  $root = dirname(__FILE__, 3);
  $path = $root . '/travel-images/large/' . $insertID . $filename;

  $filename =  $insertID . $filename;

  $move = move_uploaded_file($tmp, $path);

  $query = "UPDATE travelimage SET PATH='$filename' WHERE ImageID='$insertID'";
  $result = $conn->query($query);
  if ($result && $move) {
    https(200);
    echo json_encode(array("message" => "Upload successfully!"));
  } else {
    https(400);
    echo json_encode(array("message" => "Upload failed!"));
  }

  $conn->close();
  ?>