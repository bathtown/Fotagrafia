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

  // add or delete like
  $method = $_SERVER['REQUEST_METHOD'];

  switch ($method) {
    case 'POST': {
        $imgID = mysql_entities_fix_string($_POST['imgID']);
        // $userid

        $img_query = "SELECT * FROM travelimagefavor WHERE ImageID='$imgID' AND UID='$userid'";
        $img_result = $conn->query($img_query);
        if (!$img_result) die("Fatal Error");

        $rows = $img_result->num_rows;
        if ($rows === 0) {
          // add like
          $add_query = "INSERT INTO travelimagefavor VALUES(NULL, '$userid', '$imgID')";
          $add_result = $conn->query($add_query);
          if (!$add_result) die("Fatal Error");

          https(200);
          echo json_encode(array("message" => "Now you like it! :)"));
        } else {
          // delete like
          $delete_query = "DELETE FROM travelimagefavor WHERE ImageID='$imgID' AND UID='$userid'";
          $delete_result = $conn->query($delete_query);
          if (!$delete_result) die("Database access failed");

          https(200);
          echo json_encode(array("message" => "Now you drop like of it! :)"));
        }
        $img_result->close();
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

          $img_query = "SELECT ImageID FROM `travelimagefavor` WHERE UID='$userid'";
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
        }
        break;
      }
  }


  $conn->close();
  ?>