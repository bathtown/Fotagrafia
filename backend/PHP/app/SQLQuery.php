  <?php

  require_once '../app/SQLConfig.php';

  function CityCode2CityName($CityCode)
  {
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

  function CityName2CityCode($CityName)
  {
    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $city_query = "SELECT GeoNameID FROM geocities WHERE AsciiName='$CityName'";
    $city_result = $conn->query($city_query);
    if (!$city_result) die("Fatal Error");
    $city_row = $city_result->fetch_array(MYSQLI_ASSOC);
    $CityCode = htmlspecialchars($city_row['GeoNameID']);

    $city_result->close();
    $conn->close();

    return $CityCode;
  }

  function CountryRegionCodeISO2CountryRegionName($CountryRegionCodeISO)
  {
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

  function CountryRegionName2CountryRegionCodeISO($CountryRegionName)
  {
    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $country_query = "SELECT ISO FROM geocountries_regions WHERE Country_RegionName='$CountryRegionName'";
    $country_result = $conn->query($country_query);
    if (!$country_result) die("Fatal Error");
    $country_row = $country_result->fetch_array(MYSQLI_ASSOC);
    $CountryRegionCodeISO = htmlspecialchars($country_row['ISO']);

    $country_result->close();
    $conn->close();

    return $CountryRegionCodeISO;
  }

  function UID2UserName($UID)
  {
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
