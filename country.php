<?php

    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-8249AB8F-7DF3-4C43-A7EF-AAB672630F41";
    $result = file_get_contents($url);
    $obj = json_decode($result,false);
    // var_dump($obj->records->location[0]->locationName);
    // echo($obj->records->location[0]->locationName);
    // echo($obj->records->datasetDescription);
    // echo ("<br>");
    // require_once("weather/config.php");
    // var_dump($link);
    $location = $obj->records->location;
    foreach ($location as $locationObject) {
        $countryName = $locationObject->locationName;
        // $startTime = $locationObject->weatherElement[0]->time[0]->startTime;
        // $endTime = $locationObject->weatherElement[0]->time[0]->endTime;
        // $currentWeather = $locationObject->weatherElement[0]->time[0]->parameter->parameterName;
        // var_dump($currentWeather);
        // echo ("$currentTime <br>");
        // echo ("$countryName<br>");
        $sql = <<<multi
            INSERT INTO countries
            (countryName)
            VALUES
            ('$countryName')
        multi;
        // var_dump($sql);
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
    }
    mysqli_close($link);
?>