  <?php

  /* This is to get my uploads 

    _POST: 
    upload/change my upload 

    require: token, title, description, city, country, file, content
    publicity: private,

    return: a message

    _DELETE:
    delete my upload

    require: token, imgID
    publicity: private

    return: a message

    _GET: 
    get my uploads 

    require: token
    publicity: private

    return: img abstract JSON
  */

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';
  require_once '../api/token.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  // add or delete like

  $method = $_SERVER['REQUEST_METHOD'];

  switch ($method) {
    case 'DELETE': {
        parse_str(file_get_contents('php://input'), $_DELETE);

        $imgID = mysql_entities_fix_string($_DELETE['imgID']);

        $conn->autocommit(false);
        $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

        // get file path
        $select_query = "SELECT PATH From travelimage where ImageID='$imgID' AND UID='$userid'";
        $select_result = $conn->query($select_query);
        if (!$select_result) die("Fatal Error");
        $select_row = $select_result->fetch_array(MYSQLI_ASSOC);

        $root = dirname(__FILE__, 3);
        $path = $root . '/travel-images/large/' . $select_row['PATH'];

        $select_result->close();

        // delete in travelimage & travelimagefavor
        $delete_query1 = "DELETE FROM travelimage WHERE ImageID='$imgID' AND UID='$userid'";
        $delete_query2 = "DELETE FROM travelimagefavor WHERE ImageID='$imgID' AND UID='$userid'";

        $conn->query($delete_query1);
        $delete_result1 =  $conn->affected_rows;
        $conn->query($delete_query2);
        $delete_result2 =  $conn->affected_rows;

        // delete file
        $delete_result3 = unlink($path);

        if ($delete_result1 === 1 && $delete_result2 >= 0 && $delete_result3) {
          $conn->commit();
          https(200);
          echo json_encode(array("message" => "Now you delete this picture! :)"));
        } else {
          $conn->rollback();
          https(400);
          echo json_encode(array("message" => "Delete fail, please try again 😶"));
        }

        break;
      }
    case 'GET': {
        $img_query = "SELECT ImageID FROM `travelimage` WHERE UID='$userid'";
        $img_result = $conn->query($img_query);
        if (!$img_result) die("Fatal Error");

        $img_rows = $img_result->num_rows;
        $imgs = array();
        for ($j = 0; $j < $img_rows; ++$j) {
          $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
          array_push($imgs, ImgId2ImgDataAbstract($img_row['ImageID']));
        }

        https(200);
        echo json_encode($imgs);

        $img_result->close();
        break;
      }
    case 'POST': {
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
      }
  }

  $conn->close();
  ?>