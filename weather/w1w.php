<?php
    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-8249AB8F-7DF3-4C43-A7EF-AAB672630F41";
    $result = file_get_contents($url);
    $obj = json_decode($result,false);
    // var_dump($obj);
    if(isset($_POST["w1wButton"])) {
        $seletedCountry = $_POST['country'];
        // var_dump($obj->records->locations[0]->location);
        // echo($obj->records->locations[0]->datasetDescription);
        // echo ("<br>");
        $location = $obj->records->locations[0]->location;
        // var_dump($location);
        
        foreach ($location as $locationObject) {
            $countryName = $locationObject->locationName;
            // var_dump($countryName);
            $find1wSql = <<<f1w
                SELECT * FROM `countries` WHERE countryName = '$countryName'
            f1w;
            // var_dump($link);
            $find1wResult = mysqli_query($link, $find1wSql);
            $find1wRow = mysqli_fetch_assoc($find1wResult);
            $country1wId = $find1wRow['countryId'];
            // var_dump($country1wId);
            for ($i = 0; $i < 14; $i++) {
                //22個縣市的天氣預報綜合描述
                $wddescription = $locationObject->weatherElement[10]->description;
                $wdstartTime[$i] = $locationObject->weatherElement[10]->time[$i]->startTime;
                $wdendTime[$i] = $locationObject->weatherElement[10]->time[$i]->endTime;
                $wdvalue0[$i] = $locationObject->weatherElement[10]->time[$i]->elementValue[0]->value;
                // echo($wdvalue0[$i]);
                // echo ("<hr>");
                $weather1wSql = <<< w1w
                    DELETE FROM weather1w 
                    WHERE countryId = $country1wId AND startTime = '$wdstartTime[$i]'
                w1w;
                // var_dump($weather1wSql);
                $weather1wResult = mysqli_query($link, $weather1wSql);
                $insert1wSql = <<<i1w
                    INSERT INTO weather1w
                    (countryId, startTime, endTime, weather, storeDate)
                    VALUES
                    ($country1wId, '$wdstartTime[$i]', '$wdendTime[$i]', '$wdvalue0[$i]', current_timestamp())
                i1w;
                // var_dump($insert1wSql);
                $insert1wResult = mysqli_query($link, $insert1wSql);
                // var_dump($insert1wResult);  
            }
            if($seletedCountry == $countryName){
                $select1wSql = <<<s1w
                    SELECT * 
                    FROM `weather1w`
                    WHERE countryId = $country1wId
                    ORDER BY storeDate DESC LIMIT 14
                s1w;
                // var_dump($select1wSql);
                $select1wResult = mysqli_query($link, $select1wSql);
                // var_dump($select1wResult);
            }
        }  
    }
    
?>