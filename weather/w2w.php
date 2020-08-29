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
        foreach ($location as $locationObject) {
            $countryName = $locationObject->locationName;
            // var_dump($countryName);
            $pop12hweatherElement = $locationObject->weatherElement[0];
            $pop12hdescription = $locationObject->weatherElement[0]->description;
            //22個縣市的12小時降雨機率
            for ($i = 0; $i < 6; $i++) {
                $pop12hstartTime[$i] = $locationObject->weatherElement[0]->time[$i]->startTime;
                $pop12hendtime[$i] = $locationObject->weatherElement[0]->time[$i]->endTime;
                $pop12hvalue0[$i] = $locationObject->weatherElement[0]->time[$i]->elementValue[0]->value;
                $pop12hmeasures0[$i] = $locationObject->weatherElement[0]->time[$i]->elementValue[0]->measures;
                
            }
            //22個縣市的天氣現象
            // for ($i = 0; $i < 24; $i++) {
            //     $wxstartTime[$i] = $locationObject->weatherElement[0]->time[$i]->startTime;
            //     $wxendtime[$i] = $locationObject->weatherElement[0]->time[$i]->endTime;
            //     $wxvalue0[$i] = $locationObject->weatherElement[0]->time[$i]->elementValue[0]->value;
            //     $wxmeasures0[$i] = $locationObject->weatherElement[0]->time[$i]->elementValue[0]->measures;
            //     echo($wxstartTime[$i]);
            //     echo("<hr>");
            // }
            //
            

            // $pop12htime0 = $locationObject->weatherElement[0]->time[0];
            // $pop12htime0 = $locationObject->weatherElement[0]->time[0];
            // var_dump($weatherElement);
            // foreach ($weatherElement as $weatherElementObject) {
                // $pop12hdescription = $weatherElementObject[0]->description;
                // $pop12htime = $weatherElementObject[0]->time;

                // var_dump($time);
                // foreach ($time as $timeObject) {
                //     $pop12hstartTime = $timeObject->startTime;
                //     $pop12hendTime = $timeObject->endTime;
                //     $pop12hvalue = $timeObject->value;    
                // }
                // if($seletedCountry == $countryName){
                //     $mss = "
                //             <strong> $countryName </strong> <br>
                //             12小時降雨機率: $pop12hvalue % <br>"; 
                // } 
            // }
        //     $endTime = $locationObject->weatherElement[0]->time[0]->endTime;
        //     $wxcurrentWeather = $locationObject->weatherElement[0]->time[0]->parameter->parameterName;
        //     $popcurrentWeather = $locationObject->weatherElement[1]->time[0]->parameter->parameterName;
        //     $mintcurrentWeather = $locationObject->weatherElement[2]->time[0]->parameter->parameterName;
        //     $cicurrentWeather = $locationObject->weatherElement[3]->time[0]->parameter->parameterName;
        //     $maxtcurrentWeather = $locationObject->weatherElement[4]->time[0]->parameter->parameterName;
        // var_dump($currentWeather);
        // echo ("$currentTime <br>");
        //     if($seletedCountry == $countryName){
        //     $mss = "
        //             <strong> $countryName </strong> <br>
        //             天氣狀況: $wxcurrentWeather <br>
        //             溫度   : $mintcurrentWeather C - $maxtcurrentWeather C $cicurrentWeather<br>
        //             降雨機率:$popcurrentWeather %"; 
        //     } 
        }     
    }
    
?>