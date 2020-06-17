  <?php

  /* This is to get my uploads 

    POST: 
    change my upload 

    require: imgID, token
    publicity: private

    return: a successfully message

    GET: 
    my uploads 

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
    case 'POST': {
        $imgID = mysql_entities_fix_string($_POST['imgID']);
        // $userid

        $delete_query = "DELETE FROM travelimage WHERE ImageID='$imgID' AND UID='$userid'";
        $delete_result = $conn->query($delete_query);

        //TODO: also delete the file

        if (!$delete_result) {
          https(405);
          echo json_encode(array("message" => "Delete fail, please try again 😶"));
        } else {
          https(200);
          echo json_encode(array("message" => "Now you delete this picture! :)"));
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
  }

  $conn->close();
  ?>