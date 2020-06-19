  <?php

  /* This is to get number 
     of like of a specified img 

     require: imgID
     publicity: public

     return: likes number
  */

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  $imgID = mysql_entities_fix_string($_GET['imgID']);

  $img_query = "SELECT COUNT(ImageID) FROM travelimagefavor WHERE ImageID='$imgID'";

  $img_result = $conn->query($img_query);
  if (!$img_result) die("Fatal Error");
  $res = mysqli_fetch_array($img_result);

  https(200);
  echo $res['COUNT(ImageID)'];

  $img_result->close();
  $conn->close();
  ?>