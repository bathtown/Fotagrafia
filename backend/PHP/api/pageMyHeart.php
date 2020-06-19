  <?php

  /* This is to get my like 
    for a specified img 

    POST: 
    change like

    require: imgID, token
    publicity: private

    return: a successfully message

    GET: 
    whether I like

    require: imgID, token
    publicity: private

    return: true / false
  */

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';
  require_once '../api/token.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  $method = $_SERVER['REQUEST_METHOD'];

  switch ($method) {
    case 'PUT': {
        // add like
        parse_str(file_get_contents('php://input'), $_PUT);

        $imgID = mysql_entities_fix_string($_PUT['imgID']);

        $put_query = "INSERT INTO travelimagefavor VALUES(NULL, '$userid', '$imgID')";
        $put_result = $conn->query($put_query);
        if (!$put_result) die("Fatal Error");

        https(200);
        echo json_encode(array("message" => "Now you like it! :)"));

        break;
      }
    case 'DELETE': {
        // delete like
        parse_str(file_get_contents('php://input'), $_DELETE);

        $imgID = mysql_entities_fix_string($_DELETE['imgID']);

        $delete_query = "DELETE FROM travelimagefavor WHERE ImageID='$imgID' AND UID='$userid'";
        $delete_result = $conn->query($delete_query);
        if (!$delete_result) die("Database access failed");

        https(200);
        echo json_encode(array("message" => "Now you drop like of it! :)"));

        break;
      }
    case 'GET': {

        if (isset($_GET['imgID'])) {

          $imgID = mysql_entities_fix_string($_GET['imgID']);
          // $userid

          $img_query = "SELECT * FROM travelimagefavor WHERE ImageID='$imgID' AND UID='$userid'";
          $img_result = $conn->query($img_query);
          if (!$img_result) die("Fatal Error");

          $rows = $img_result->num_rows;
          if ($rows === 0) {
            // I don't like
            https(200);
            echo 0;
          } else {
            // I', loving it :)
            https(200);
            echo 1;
          }
          $img_result->close();
        } else {

          $start = (mysql_entities_fix_string($_GET['page']) - 1) * 8;

          $img_query = "SELECT ImageID FROM `travelimagefavor` WHERE UID='$userid' LIMIT $start, 8";
          $page_query = "SELECT ImageID FROM `travelimagefavor` WHERE UID='$userid'";

          $img_result = $conn->query($img_query);
          $page_result = $conn->query($page_query);

          if (!$img_result || !$page_result) die("Fatal Error");

          $pageNum = ceil($page_result->num_rows / 8);

          $img_rows = $img_result->num_rows;
          $imgs = array();
          for ($j = 0; $j < $img_rows; ++$j) {
            $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
            array_push($imgs, ImgId2ImgDataAbstract($img_row['ImageID']));
          }

          https(200);
          echo json_encode(array('imgs' => $imgs, 'pageNum' => $pageNum));

          $img_result->close();
        }
        break;
      }
  }

  $conn->close();
  ?>