  <?php

  require_once '../app/SQLConfig.php';

  function CityCode2CityName($CityCode)
  {
    if ($CityCode === '') return 'null';

    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $city_query = "SELECT AsciiName FROM geocities WHERE GeoNameID='$CityCode'";
    $city_result = $conn->query($city_query);
    if (!$city_result) die("Fatal Error");
    $city_row = $city_result->fetch_array(MYSQLI_ASSOC);
    $CityName = htmlspecialchars($city_row['AsciiName']);

    $city_result->close();
    $conn->close();

    return $CityName;
  }

  function CountryRegionCodeISO2CountryRegionCodeName($CountryRegionCodeISO)
  {
    if ($CountryRegionCodeISO  === '') return 'null';

    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $country_query = "SELECT Country_RegionName FROM geocountries_regions WHERE ISO='$CountryRegionCodeISO'";
    $country_result = $conn->query($country_query);
    if (!$country_result) die("Fatal Error");
    $country_row = $country_result->fetch_array(MYSQLI_ASSOC);
    $CountryRegionName = htmlspecialchars($country_row['Country_RegionName']);

    $country_result->close();
    $conn->close();

    return $CountryRegionName;
  }

  function UID2UserName($UID)
  {
    if ($UID === '') return 'null';

    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $country_query = "SELECT UserName FROM traveluser WHERE UID='$UID'";
    $country_result = $conn->query($country_query);
    if (!$country_result) die("Fatal Error");
    $country_row = $country_result->fetch_array(MYSQLI_ASSOC);
    $UserName = htmlspecialchars($country_row['UserName']);

    $country_result->close();
    $conn->close();

    return $UserName;
  }
  ?>
