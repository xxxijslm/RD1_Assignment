<?php
    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-8249AB8F-7DF3-4C43-A7EF-AAB672630F41";
    $result = file_get_contents($url);
    $obj = json_decode($result,false); 
    if(isset($_POST["w36Button"])) {
        $seletedCountry = $_POST['country'];
        $findSql = <<< fs
            SELECT * FROM `countries` WHERE countryName = '$seletedCountry'
        fs;
        $findResult = mysqli_query($link, $findSql);
        $findRow = mysqli_fetch_assoc($findResult);
        $countryId = $findRow['countryId'];
        // echo $countryId;
        // var_dump($weather36hResult); 
        // var_dump($obj->records->location[0]->locationName);
        // echo($obj->records->location[0]->locationName);
        // echo($obj->records->datasetDescription);
        // echo ("<br>");
        $location = $obj->records->location;
        foreach ($location as $locationObject) {
            $countryName = $locationObject->locationName;
            $startTime = $locationObject->weatherElement[0]->time[0]->startTime;
            $endTime = $locationObject->weatherElement[0]->time[0]->endTime;
            $wxcurrentWeather = $locationObject->weatherElement[0]->time[0]->parameter->parameterName;
            $popcurrentWeather = $locationObject->weatherElement[1]->time[0]->parameter->parameterName;
            $mintcurrentWeather = $locationObject->weatherElement[2]->time[0]->parameter->parameterName;
            $cicurrentWeather = $locationObject->weatherElement[3]->time[0]->parameter->parameterName;
            $maxtcurrentWeather = $locationObject->weatherElement[4]->time[0]->parameter->parameterName;
        // var_dump($currentWeather);
        // echo ("$currentTime <br>");
            $weather36hSql = <<< lines
                DELETE FROM weather36h  
                WHERE countryId = $countryId AND startTime = '$startTime'
            lines;
            $weather36hResult = mysqli_query($link, $weather36hSql);

            $insertSql = <<< ins
                INSERT INTO weather36h
                (countryId, startTime, endTime, weather, minT, maxT, rainfall, storeDate, cicurrent)
                VALUES
                ($countryId, '$startTime', '$endTime', '$wxcurrentWeather', '$mintcurrentWeather', '$maxtcurrentWeather', '$popcurrentWeather', current_timestamp(), '$cicurrentWeather')
            ins;
            $insertResult = mysqli_query($link, $insertSql);
            
            if($seletedCountry == $countryName){
            $mss = "
                    <strong> $countryName </strong> <br>
                    天氣狀況: $wxcurrentWeather <br>
                    溫度   : $mintcurrentWeather C - $maxtcurrentWeather C $cicurrentWeather<br>
                    降雨機率:$popcurrentWeather %"; 
            }
        }  
        
    }
    
?>