<?php
    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-8249AB8F-7DF3-4C43-A7EF-AAB672630F41";
    $result = file_get_contents($url);
    $obj = json_decode($result,false);
    // var_dump($obj);
    if(isset($_POST["w2wButton"])) {
        $seletedCountry = $_POST['country'];
        // var_dump($obj->records->locations[0]->location);
        // echo($obj->records->locations[0]->datasetDescription);
        // echo ("<br>");
        $location = $obj->records->locations[0]->location;
        // var_dump($location);

        //22個縣市的12小時降雨機率
        foreach ($location as $locationObject) {
            $countryName = $locationObject->locationName;
            // var_dump($countryName);
            $pop12dweatherElement = $locationObject->weatherElement[0];
            $pop12ddescription = $locationObject->weatherElement[0]->description;
            
            for ($i = 0; $i < 6; $i++) {
                $pop12dstartTime[$i] = $locationObject->weatherElement[0]->time[$i]->startTime;
                $pop12dendtime[$i] = $locationObject->weatherElement[0]->time[$i]->endTime;
                $pop12dvalue0[$i] = $locationObject->weatherElement[0]->time[$i]->elementValue[0]->value;
                $pop12dmeasures0[$i] = $locationObject->weatherElement[0]->time[$i]->elementValue[0]->measures;
                // echo($pop12dvalue0[$i] . '雨');
            }
            // echo($pop12dstartTime[0] . '时间');
        }
        
        
        foreach ($location as $locationObject) {
            $countryName = $locationObject->locationName;
            // var_dump($countryName);
            // $wxweatherElement = $locationObject->weatherElement[1];
            $find2dSql = <<<f2d
                SELECT * FROM `countries` WHERE countryName = '$countryName'
            f2d;
            // var_dump($link);
            $find2dResult = mysqli_query($link, $find2dSql);
            $find2dRow = mysqli_fetch_assoc($find2dResult);
            $country2dId = $find2dRow['countryId'];
            // var_dump($country2dId);
            for ($i = 0; $i < 24; $i++) {
                //22個縣市的天氣預報綜合描述
                $wddescription = $locationObject->weatherElement[6]->description;
                $wdstartTime[$i] = $locationObject->weatherElement[6]->time[$i]->startTime;
                $wdendTime[$i] = $locationObject->weatherElement[6]->time[$i]->endTime;
                $wdvalue0[$i] = $locationObject->weatherElement[6]->time[$i]->elementValue[0]->value;
                
                // echo($wdValue[$i]);
                // echo ("<hr>");
                $weather2dSql = <<< w2d
                    DELETE FROM weather2d  
                    WHERE countryId = $country2dId AND startTime = '$wdstartTime[$i]'
                w2d;
                // var_dump($weather2dSql);
                $weather2dResult = mysqli_query($link, $weather2dSql);
                $insert2dSql = <<<i2d
                    INSERT INTO weather2d
                    (countryId, startTime, endTime, weather, storeDate)
                    VALUES
                    ($country2dId, '$wdstartTime[$i]', '$wdendTime[$i]', '$wdvalue0[$i]', current_timestamp())
                i2d;
                $insert2dResult = mysqli_query($link, $insert2dSql);
                // var_dump($insert2dResult);  
            }
            if($seletedCountry == $countryName){
                $select2dSql = <<<s2d
                    SELECT * 
                    FROM `weather2d`
                    WHERE countryId = $country2dId
                    ORDER BY storeDate DESC LIMIT 25
                s2d;
                // var_dump($select2dSql);
                $select2dResult = mysqli_query($link, $select2dSql);
                // var_dump($select2dResult);
            }
        }  
    }
    
?>