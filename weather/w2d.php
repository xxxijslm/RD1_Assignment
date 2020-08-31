<?php
    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-8249AB8F-7DF3-4C43-A7EF-AAB672630F41";
    $result = file_get_contents($url);
    $obj = json_decode($result,false);
    // var_dump($obj);
    if(isset($_POST["w2dButton"])) {
        $seletedCountry = $_POST['country'];
        // var_dump($obj->records->locations[0]->location);
        // echo($obj->records->locations[0]->datasetDescription);
        // echo ("<br>");
        $location = $obj->records->locations[0]->location;
        // var_dump($location);
        $same = 0;
        foreach ($location as $locationObject) {
            $countryName = $locationObject->locationName;
            // var_dump($countryName);
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
                if ($same == 0) {
                    $findSameSql = <<<fs
                        SELECT * 
                        FROM `weather2d`
                        WHERE countryId = $country2dId AND startTime = '$wdstartTime[$i]'
                    fs;
                    $findSameResult = mysqli_query($link, $findSameSql);
                    // var_dump($findSameSql);
                    $findSameRow = mysqli_fetch_assoc($findSameResult);
                    $checkTime = $findSameRow['startTime'];
                    // var_dump($checkTime);
                    if (strtotime($checkTime) != strtotime($wdstartTime[$i])) {
                        $same = 1;      //要insert新資料
                        // echo($same);
                    }
                    else {
                        $same = 2;
                    }
                }
                if ($same == 1) {
                    $insert2dSql = <<<i2d
                        INSERT INTO weather2d
                        (countryId, startTime, endTime, weather, storeDate)
                        VALUES
                        ($country2dId, '$wdstartTime[$i]', '$wdendTime[$i]', '$wdvalue0[$i]', current_timestamp())
                    i2d;
                    $insert2dResult = mysqli_query($link, $insert2dSql);
                    // var_dump($insert2dSql);  
                }
            }
            if($seletedCountry == $countryName){
                $countSql = <<<cs
                    SELECT COUNT(*) total 
                    FROM `weather2d`
                    WHERE countryId = $country2dId
                cs;
                $countResult = mysqli_query($link, $countSql);
                $countRow = mysqli_fetch_assoc($countResult);
                $total = $countRow['total'];
                if($total == 24) {
                    $limit = 0;
                }
                else{
                    $limit = $total - 25;
                }
            
                $select2dSql = <<<s2d
                    SELECT * 
                    FROM `weather2d`
                    WHERE countryId = $country2dId
                    ORDER BY weather2dId LIMIT $limit, 25
                s2d;
                // var_dump($select2dSql);
                $select2dResult = mysqli_query($link, $select2dSql);
                // var_dump($select2dResult);
            }
        }  
    }
    
?>