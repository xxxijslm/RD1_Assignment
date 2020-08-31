<?php
    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-8249AB8F-7DF3-4C43-A7EF-AAB672630F41";
    $result = file_get_contents($url);
    $obj = json_decode($result,false);
    // var_dump($obj);
    if(isset($_POST["r1Button"])) {
        $seletedCountry = $_POST['country'];
        // var_dump($obj->records->location);
        $location = $obj->records->location;
        // var_dump($location);
        
        foreach ($location as $locationObject) {
            $stationName = $locationObject->locationName;
            // var_dump($stationName);
            $obsTime = $locationObject->time->obsTime;
            // var_dump($obsTime);
            $parameterValue = $locationObject->parameter[0]->parameterValue;
            // var_dump($parameterValue);
            $r1helementValue = $locationObject->weatherElement[1]->elementValue;
            $r24helementValue = $locationObject->weatherElement[6]->elementValue;
            // var_dump($r24helementValue);

            $findr1Sql = <<<fr1
                SELECT * FROM `countries` WHERE countryName = '$parameterValue'
            fr1;
            // var_dump($findr1Sql);
            $findr1Result = mysqli_query($link, $findr1Sql);
            $findr1Row = mysqli_fetch_assoc($findr1Result);
            $countryr1Id = $findr1Row['countryId'];
            // var_dump($countryr1Id);
            
                $weatherRainSql = <<< wr
                    DELETE FROM weatherRain
                    WHERE stationName = '$stationName' AND obsTime = '$obsTime'
                wr;
                // var_dump($weatherRainSql);
                $weatherRainResult = mysqli_query($link, $weatherRainSql);
                // var_dump($weatherRainResult);
                $insertRainSql = <<<ir
                    INSERT INTO weatherRain
                    (countryId, stationName, rain, hour24, storeDate, obsTime)
                    VALUES
                    ($countryr1Id, '$stationName', '$r1helementValue', '$r24helementValue', current_timestamp(), '$obsTime')
                ir;
                // var_dump($insertRainSql);
                $insertRainResult = mysqli_query($link, $insertRainSql);
 
            if($seletedCountry == $parameterValue){
                $selectRainSql = <<<sr
                    SELECT * 
                    FROM `weatherRain`
                    WHERE countryId = $countryr1Id AND obsTime = '$obsTime';
                sr;
                // var_dump($selectRainSql);
                $selectRainResult = mysqli_query($link, $selectRainSql);
                // var_dump($selectRainResult);
            }
        }  
    }
    
?>