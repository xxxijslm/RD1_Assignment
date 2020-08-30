<?php
    require_once("config.php");
    require_once("w36.php");
    require_once("w2d.php");
    
    // var_dump($link);
    $sql = <<< multi
        SELECT * FROM `countries`
    multi;
    $result = mysqli_query($link, $sql);
    $findIdResult = mysqli_query($link, $sql);
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
                    <option value="<?= $row['countryName'] ?>" <?= ($row['countryName']==$_POST['country']) ? "selected":"" ?>> <?= $row['countryName'] ?></option>
                <?php } ?>
            </select>
            <input name="w36Button" id="w36Button" class="btn btn-light" type="submit" value="當前天氣">
            <input name="w2wButton" id="w2wButton" class="btn btn-light" type="submit" value="未來2天天氣">
        </div>
    </form>
    <div class="center">
        <div id="showbox"></div>
        <?php echo($_POST['country']) ?>
        <?= "<br> $mss" ?>
        <?php if (isset($_POST['w2wButton'])) { ?>
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