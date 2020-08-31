<?php
    require_once("config.php");
    require_once("r1.php");
    
    // var_dump($link);
    $sql = <<< multi
        SELECT * FROM `countries`
    multi;
    $result = mysqli_query($link, $sql);

    $countryImgName = $_POST['country'];
    $imgSql = <<< is
        SELECT countryImg FROM `countries` WHERE countryName = '$countryImgName';
    is;
    $findImgResult = mysqli_query($link, $imgSql);
    $findImgRow = mysqli_fetch_assoc($findImgResult);
    $image = $findImgRow['countryImg'];
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
    <h4 class="navbar"><a href="index.php">天氣預報</a> | <a class="active" href="rain.php">雨量觀測</a></h4>
    <form method="POST" action="">
        <div class="select-box">
            <label for="country" class="label country"><span class="label-desc">選擇縣市</span> </label>
            <select name="country" id="country" class="select">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <option value="<?= $row['countryName'] ?>" <?= ($row['countryName']==$_POST['country']) ? "selected":"" ?>> <?= $row['countryName'] ?></option>
                <?php } ?>
            </select>
            <input name="r1Button" id="r1Button" class="btn btn-light" type="submit" value="雨量偵測">
        </div>
    </form>
    <div class="center">
        <div id="showbox"></div>
        <img class="img-fluid" src=" <?= $image ?> ">
        <br>
        <?php echo($_POST['country']) ?>
        <?= "<br> $mss" ?>
        <?php if (isset($_POST['r1Button'])) { ?>
            <table class="table">
                <tr>
                    <th>觀察站：</th>
                    <th>觀察時間：</th>
                    <th>過去1小時雨量：</th>
                    <th>過去24小時雨量：</th>
                </tr>
                <?php while ($wRainRow = mysqli_fetch_assoc($selectRainResult)) { ?>
                    <tr>
                        <td><?= $wRainRow['stationName'] ?></td>
                        <td><?= $wRainRow['obsTime'] ?></td>
                        <td><?= $wRainRow['rain'] ?></td>
                        <td><?= $wRainRow['hour24'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>

</body>

<script>

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

    function ShowTime(){
    　document.getElementById('showbox').innerHTML = new Date();
    　setTimeout('ShowTime()',1000);
    }
</script>
</html>