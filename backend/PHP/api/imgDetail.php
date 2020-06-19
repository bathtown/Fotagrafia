  <?php

  /* This is to a img's detail

     require: imgID
     publicity: public

     return: a img's detail
  */

  require_once '../app/StatusCode.php';
  require_once '../app/CORS.php';
  require_once '../app/SQLConfig.php';
  require_once '../app/SQLQuery.php';

  $imgID = mysql_entities_fix_string($_GET['imgID']);;

  https(200);
  echo json_encode(ImgId2ImgDataDetail($imgID));

  ?>
