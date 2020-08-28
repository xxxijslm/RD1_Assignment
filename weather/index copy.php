<?php

    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-8249AB8F-7DF3-4C43-A7EF-AAB672630F41";
    $result = file_get_contents($url);
    $obj = json_decode($result,false);
    // var_dump($obj->records->location[0]->locationName);
    // echo($obj->records->location[0]->locationName);
    echo($obj->records->datasetDescription);
    echo ("<br>");
    $location = $obj->records->location;
    foreach ($location as $locationObject) {
        $countryName = $locationObject->locationName;
        $startTime = $locationObject->weatherElement[0]->time[0]->startTime;
        $endTime = $locationObject->weatherElement[0]->time[0]->endTime;
        $currentWeather = $locationObject->weatherElement[0]->time[0]->parameter->parameterName;
        // var_dump($currentWeather);
        // echo ("$currentTime <br>");
        echo ("$countryName 當前天氣:$currentWeather <br>");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="">
        <select name="country" id="country">
            <option value="0"></option>
            <option value="0">台北市</option>
            <option value="2">台中市</option>
            <option value="4">台南市</option>
        </select>
        <input type="submit" value="OK">
    </form>
    <div id="debug"></div>
</body>

<script>
    
    function countryChange() {
        let selectedCountry = $("#country option:selected").text();
        $("#debug").text(selectedCountry);
    }
    
    $("#country").change(countryChange);
    $("#country").trigger("change");

</script>
</html>