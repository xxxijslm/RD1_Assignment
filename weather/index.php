<?php

    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-8249AB8F-7DF3-4C43-A7EF-AAB672630F41";
    $result = file_get_contents($url);
    $obj = json_decode($result,false);

    require_once("config.php");
    // var_dump($link);
    $sql = <<< multi
        SELECT * FROM `countries`
    multi;
    $result = mysqli_query($link, $sql);

    if(isset($_POST["okButton"])) {
        $seletedCountry = $_POST['country'];
        // echo($seletedCountry);
    }
    
    
    
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
    // var_dump($currentWeather);
    // echo ("$currentTime <br>");
        if($seletedCountry == $countryName){
           $mss = "
                當前天氣 <br><br>
                當前時段: $startTime ~ $endTime <br>
                天氣狀況: $wxcurrentWeather <br>
                降雨機率：$popcurrentWeather %"; 
        }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.min.js"> </script>
    <title>Document</title>
</head>
<body>
    <form method="POST" action="">
        <select name="country" id="country">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <option value="<?= $row['countryName'] ?>" <?= ($seletedCountry == $row['countryName']) ? "selected":"" ?> > <?= $row['countryName'] ?></option>
            <?php } ?>
        </select>
        <input name="okButton" id="okButton" type="submit" value="OK">
    </form>
    <div id="debug"><?= $mss?> </div>
</body>

<script>
    
    // function countryChange() {
    //     let selectedCountry = $("#country option:selected").text();
    //     // $("#debug").text(selectedCountry);
    // }
    
    // $("#country").change(countryChange);
    // $("#country").trigger("change");

</script>
</html>