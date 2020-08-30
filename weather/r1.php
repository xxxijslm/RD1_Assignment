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
    //         for ($i = 0; $i < 24; $i++) {
    //             //22個縣市的天氣預報綜合描述
    //             $wddescription = $locationObject->weatherElement[6]->description;
    //             $wdstartTime[$i] = $locationObject->weatherElement[6]->time[$i]->startTime;
    //             $wdendTime[$i] = $locationObject->weatherElement[6]->time[$i]->endTime;
    //             $wdvalue0[$i] = $locationObject->weatherElement[6]->time[$i]->elementValue[0]->value;
                
    //             // echo($wdValue[$i]);
    //             // echo ("<hr>");
    //             $weather2dSql = <<< w2d
    //                 DELETE FROM weather2d  
    //                 WHERE countryId = $country2dId AND startTime = '$wdstartTime[$i]'
    //             w2d;
    //             // var_dump($weather2dSql);
    //             $weather2dResult = mysqli_query($link, $weather2dSql);
    //             $insert2dSql = <<<i2d
    //                 INSERT INTO weather2d
    //                 (countryId, startTime, endTime, weather, storeDate)
    //                 VALUES
    //                 ($country2dId, '$wdstartTime[$i]', '$wdendTime[$i]', '$wdvalue0[$i]', current_timestamp())
    //             i2d;
    //             $insert2dResult = mysqli_query($link, $insert2dSql);
    //             // var_dump($insert2dResult);  
    //     }
    //         if($seletedCountry == $countryName){
    //             $select2dSql = <<<s2d
    //                 SELECT * 
    //                 FROM `weather2d`
    //                 WHERE countryId = $country2dId
    //                 ORDER BY storeDate DESC LIMIT 24
    //             s2d;
    //             // var_dump($select2dSql);
    //             $select2dResult = mysqli_query($link, $select2dSql);
    //             var_dump($select2dResult);
    //         }
        }  
    }
    
?>