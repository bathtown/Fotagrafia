  <?php

  require_once '../app/SQLConfig.php';

  function CityCode2CityName($CityCode)
  {

    if ($CityCode === null) return 'null';

    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $city_query = "SELECT AsciiName FROM geocities WHERE GeoNameID='$CityCode'";
    $city_result = $conn->query($city_query);
    if (!$city_result) die("Fatal Error");
    $city_row = $city_result->fetch_array(MYSQLI_ASSOC);
    $CityName = $city_row['AsciiName'];

    $city_result->close();
    $conn->close();

    return $CityName;
  }

  function CityName2CityCode($CityName)
  {

    if ($CityName === null) return 'null';

    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $city_query = "SELECT GeoNameID FROM geocities WHERE AsciiName=\"$CityName\"";
    $city_result = $conn->query($city_query);
    if (!$city_result) die("Fatal Error");
    $city_row = $city_result->fetch_array(MYSQLI_ASSOC);
    $CityCode = $city_row['GeoNameID'];

    $city_result->close();
    $conn->close();

    return $CityCode;
  }

  function CountryRegionCodeISO2CountryRegionName($CountryRegionCodeISO)
  {

    if ($CountryRegionCodeISO === null) return 'null';

    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $country_query = "SELECT Country_RegionName FROM geocountries_regions WHERE ISO='$CountryRegionCodeISO'";
    $country_result = $conn->query($country_query);
    if (!$country_result) die("Fatal Error");
    $country_row = $country_result->fetch_array(MYSQLI_ASSOC);
    $CountryRegionName = $country_row['Country_RegionName'];

    $country_result->close();
    $conn->close();

    return $CountryRegionName;
  }

  function CountryRegionName2CountryRegionCodeISO($CountryRegionName)
  {

    if ($CountryRegionName === null) return 'null';

    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $country_query = "SELECT ISO FROM geocountries_regions WHERE Country_RegionName=\"$CountryRegionName\"";
    $country_result = $conn->query($country_query);
    if (!$country_result) die("Fatal Error");
    $country_row = $country_result->fetch_array(MYSQLI_ASSOC);
    $CountryRegionCodeISO = $country_row['ISO'];

    $country_result->close();
    $conn->close();

    return $CountryRegionCodeISO;
  }

  function UID2UserName($UID)
  {

    if ($UID === null) return 'null';

    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $country_query = "SELECT UserName FROM traveluser WHERE UID='$UID'";
    $country_result = $conn->query($country_query);
    if (!$country_result) die("Fatal Error");
    $country_row = $country_result->fetch_array(MYSQLI_ASSOC);
    $UserName = $country_row['UserName'];

    $country_result->close();
    $conn->close();

    return $UserName;
  }

  function ImgId2ImgDataDetail($imgID)
  {
    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $img_query = "SELECT * FROM travelimage WHERE ImageID='$imgID'";
    $img_result = $conn->query($img_query);
    if (!$img_result) die("Fatal Error");

    $img_row = $img_result->fetch_array(MYSQLI_ASSOC);

    $author = UID2UserName(($img_row['UID']));
    $CountryRegionName = CountryRegionCodeISO2CountryRegionName($img_row['Country_RegionCodeISO']);
    $CityName = CityCode2CityName(($img_row['CityCode']));

    $imgData = [
      'id' => $imgID,
      'src' => $img_row['PATH'],
      'title' => $img_row['Title'],
      'author' => $author == null ? 'null' : $author,
      'description' => $img_row['Description'] == null ? 'null' : $img_row['Description'],
      'content' => $img_row['Content'] == null ? 'null' : $img_row['Content'],
      'country' => $CountryRegionName == null ? 'null' : $CountryRegionName,
      'city' => $CityName == null ? 'null' : $CityName,
    ];

    $img_result->close();
    $conn->close();

    return $imgData;
  }

  function ImgId2ImgDataAbstract($imgID)
  {
    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $img_query = "SELECT * FROM travelimage WHERE ImageID='$imgID'";
    $img_result = $conn->query($img_query);
    if (!$img_result) die("Fatal Error");

    $img_row = $img_result->fetch_array(MYSQLI_ASSOC);

    $imgData = [
      'id' => $imgID,
      'src' => $img_row['PATH'],
      'title' => $img_row['Title'] == null ? 'null' : $img_row['Title'],
      'description' => $img_row['Description'] == null ? 'null' : $img_row['Description'],
    ];

    $img_result->close();
    $conn->close();

    return $imgData;
  }

  function getRadomImg($num)
  {
    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    // get imgs array
    // Select * From 表 order By rand() Limit n
    $img_query = "SELECT * FROM travelimage ORDER BY rand() LIMIT $num";

    $img_result = $conn->query($img_query);
    if (!$img_result) die("Fatal Error");

    $img_rows = $img_result->num_rows;
    $imgs = array();
    for ($j = 0; $j < $img_rows; ++$j) {
      $img_row = $img_result->fetch_array(MYSQLI_ASSOC);
      array_push($imgs, [
        'src' => $img_row['PATH'],
        'id' => $img_row['ImageID'],
        'title' => $img_row['Title'] == null ? 'null' : $img_row['Title'],
        'description' => $img_row['Description'] == null ? 'null' : $img_row['Description']
      ]);
    }

    $img_result->close();
    $conn->close();

    return $imgs;
  }
  ?>
