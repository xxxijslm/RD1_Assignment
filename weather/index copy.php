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
    require_once("w36.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Weather</title>
</head>
<body onload="ShowTime()">
    <form method="POST" action="">
        <div class="select-box">
            <label for="country" class="label country"><span class="label-desc">選擇縣市</span> </label>
            <select name="country" id="country" class="select">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <option value="<?= $row['countryName'] ?>"> <?= $row['countryName'] ?></option>
                <?php } ?>
            </select>
            <input name="okButton" id="okButton" class="btn btn-light" type="submit" value="OK">
        </div>
    </form>
    <div id="debug" class="center">
        <div id="showbox"></div>
        <?= $mss?>
    </div>

</body>

<script>
    
    // function countryChange() {
    //     let selectedCountry = $("#country option:selected").text();
    //     // $("#debug").text(selectedCountry);
    // }
    
    // $("#country").change(countryChange);
    // $("#country").trigger("change");

    $("select").on("click" , function() {
  
        $(this).parent(".select-box").toggleClass("open");
  
    });

    $(document).mouseup(function (e)
    {
        var container = $(".select-box");

        if (container.has(e.target).length === 0)
        {
            container.removeClass("open");
        }
    });


    $("select").on("change" , function() {
    
    var selection = $(this).find("option:selected").text(),
        labelFor = $(this).attr("id"),
        label = $("[for='" + labelFor + "']");
        
        label.find(".label-desc").html(selection);
        
    });

    // function ShowTime(){
    // 　document.getElementById('showbox').innerHTML = new Date();
    // 　setTimeout('ShowTime()',1000);
    // }
    function ShowTime(){
    　document.getElementById('showbox').innerHTML = new Date();
    　setTimeout('ShowTime()',1000);
    }
</script>
</html>