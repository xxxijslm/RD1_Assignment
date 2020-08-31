<?php
    require_once("config.php");
    require_once("w36.php");
    require_once("w2d.php");
    require_once("w1w.php");
    
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
    // echo ($image);
    // var_dump($imgSql);
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
    <h4 class="navbar"><a class="active" href="index.php">天氣預報</a> | <a href="rain.php">雨量觀測</a></h4>
    <form method="POST" action="">
        <div class="select-box">
            <label for="country" class="label country"><span class="label-desc">選擇縣市</span> </label>
            <select name="country" id="country" class="select">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <option value="<?= $row['countryName'] ?>" <?= ($row['countryName']==$_POST['country']) ? "selected":"" ?>> <?= $row['countryName'] ?></option>
                <?php } ?>
            </select>
            <input name="w36Button" id="w36Button" class="btn btn-light" type="submit" value="當前天氣">
            <input name="w2dButton" id="w2dButton" class="btn btn-light" type="submit" value="未來2天天氣">
            <input name="w1wButton" id="w1wButton" class="btn btn-light" type="submit" value="未來1週天氣">
        </div>
    </form>
    <div class="center">
        <div id="showbox"></div>
        <?php echo($_POST['country']) ?> <img class="img-fluid" src=" <?= $image ?> ">
        <?= "<br> $mss" ?>
        <?php if (isset($_POST['w2dButton'])) { ?>
            <table class="table">
                <tr>
                    <th>時間：</th>
                    <th>天氣：</th>
                </tr>
                <?php while ($w2dRow = mysqli_fetch_assoc($select2dResult)) { ?>
                    <tr>
                        <td><?= $w2dRow['startTime'] ?> -<br> <?= $w2dRow['endTime'] ?></td>
                        <td>
                            <?= str_replace("。", "<br>", $w2dRow['weather']) ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
        <?php if (isset($_POST['w1wButton'])) { ?>
            <table class="table">
                <tr>
                    <th>時間：</th>
                    <th>天氣：</th>
                </tr>
                <?php while ($w1wRow = mysqli_fetch_assoc($select1wResult)) { ?>
                    <tr>
                        <td><?= $w1wRow['startTime'] ?> -<br> <?= $w1wRow['endTime'] ?></td>
                        <td>
                            <?= str_replace("。", "<br>", $w1wRow['weather']) ?>
                        </td>
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