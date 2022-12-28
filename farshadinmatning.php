<?php

session_start("projekt_fot");

require("databas.php");

function years($date1, $date2) {
    $date1 = date_create($date1);
    $date2 = date_create($date2);
    $diff = date_diff($date1, $date2);
    return $diff->format("%y");
}

$required = array(
    "kon",
    "langd",
    "vikt",
    "testdatum",
    "fodelsedatum",
    "testKommentar",
    "HRLML",
    "HRRML",
    "HRLCR",
    "HRRCR",
    //"HRmeanOrInj",
    "LJouleML",
    "RJouleML",
    //"JMeanOrInjML",
    "LMeanHeightML",
    "RMeanHeightML",
    "LJouleCR",
    "RJouleCR",
    "LMeanHeightCR",
    "RMeanHeightCR",
    "SHL",
    "SHR",
    //"SHmeanOrInj",
    "LJL",
    "LJR",
    //"LJmeanOrInj"
);

//Kollar så det finns en mail.
if (!isset($_SESSION['mailf'])){
    header("location:farshadinmatningid.php");
}

if (isset($_POST['submit'])) {
    if ($_POST['langd'] == ""){
        $_POST['langd'] = " ";
    }
    if ($_POST['vikt'] == ""){
        $_POST['vikt'] = " ";
    }
    if ($_POST['testdatum'] == ""){
        $_POST['testdatum'] = " ";
    }
    if ($_POST['fodelsedatum'] == ""){
        $_POST['fodelsedatum'] = " ";
    }
    if ($_POST['testKommentar'] == ""){
        $_POST['testKommentar'] = " ";
    }
    if ($_POST['HRLML'] == ""){
        $_POST['HRLML'] = " ";
    }
    if ($_POST['HRRML'] == ""){
        $_POST['HRRML'] = " ";
    }
    if ($_POST['HRLCR'] == ""){
        $_POST['HRLCR'] = " ";
    }
    if ($_POST['HRRCR'] == ""){
        $_POST['HRRCR'] = " ";
    }
    if ($_POST['LJouleML'] == ""){
        $_POST['LJouleML'] = " ";
    }
    if ($_POST['RJouleML'] == ""){
        $_POST['RJouleML'] = " ";
    }
    if ($_POST['LMeanHeightML'] == ""){
        $_POST['LMeanHeightML'] = " ";
    }
    if ($_POST['RMeanHeightML'] == ""){
        $_POST['RMeanHeightML'] = " ";
    }
    if ($_POST['LJouleCR'] == ""){
        $_POST['LJouleCR'] = " ";
    }
    if ($_POST['RJouleCR'] == ""){
        $_POST['RJouleCR'] = " ";
    }
    if ($_POST['LMeanHeightCR'] == ""){
        $_POST['LMeanHeightCR'] = " ";
    }
    if ($_POST['RMeanHeightCR'] == ""){
        $_POST['RMeanHeightCR'] = " ";
    }
    if ($_POST['SHL'] == ""){
        $_POST['SHL'] = " ";
    }
    if ($_POST['SHR'] == ""){
        $_POST['SHR'] = " ";
    }
    if ($_POST['LJL'] == ""){
        $_POST['LJL'] = " ";
    }
    if ($_POST['LJR'] == ""){
        $_POST['LJR'] = " ";
    }
    $data = array();
    $tillfalle = "testTillfälle";

    foreach ($required as $key => $value) {
        if (!isset($_POST[$value]) || $_POST[$value] == "") {
            $missing .= " $value";
        }
        else {
            $data[$value] = $_POST[$value];
        }
    }

    if (empty($missing)) {

        if (strpos($_SESSION['id'], 'Error') !== false) {
            echo "$_SESSION[id] <br>";
        } else {
            $result = update($data, $_SESSION['mailf']);   //här ska mailen användas för att uppdatera rätt rad
            if ($result != "OK") {
                echo "$result <br>";
            } else {
                header("location:tack.php");
            }
        }
    }
}
//}
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-cg6SkqEOCV1NbJoCu11+bm0NvBRc8IYLRGXkmNrqUBfTjmMYwNKPWBTIKyw9mHNJ" crossorigin="anonymous">

    <title>Projekt Fot</title>
</head>

<body style="text-align: center;">
<div style="margin: 20px; width: 900px; max-width: 85%; text-align: start; display: inline-block;">
    <img src="gf.png">  &nbsp  &nbsp&nbsp&nbsp
    <img src="gu.png">     &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
    <img src="umea.png">
    <hr>
    <?php if (!empty($missing))  echo "<div style='color: red'>- Det är något som inte är rätt ifyllt eller inte svarat på. </div><br>"; ?>
    <?php if (isset($_POST['submit']) && $felMail == 1)  echo "<div style='color: red'>- Mailen är inte registrerad. Vänligen registrera på: <a href='https://lulab.it.gu.se/fot/intresseanmalan.php'>Intresseanmälan </a></div>"; ?>

    <form action='' method="post" class="pure-form pure-form-stacked"
          style="margin-top: 20px; padding-bottom: 60px;">
        <fieldset data-type="horizontal">
            <div>
                <label for='testdatum'>testdatum</label>
                <input type="date" name="testdatum" value="">
            </div>
            <div>
                <label for='fodelsedatum'>fodelsedatum</label>
                <input type="date" name="fodelsedatum" value="">
            </div>
            <div>
                <label for='kon'>Kön</label>
                <input required type="radio" name="kon" value="1" <?php if(isset($_POST['kon']) && $_POST['1'] == "1"){print " checked=\"checked\"";} ?>/> Man</div>
            <div>
                <input required type="radio" name="kon" value="2" <?php if(isset($_POST['kon']) && $_POST['kon'] == "2"){print " checked=\"checked\"";} ?>/> Kvinna </div>
            <div>
                <label for='langd'>Längd</label>
                <input type="number" name="langd" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='vikt'>Vikt</label>
                <input type="number" name="vikt" placeholder="" min="0" value="" step=".1">
            </div>
            <hr>
            <div>
                <label for='HRLML'>HRLML </label>
                <input type="number" name="HRLML" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='HRRML'>HRRML</label>
                <input type="number" name="HRRML" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='HRLCR'>HRLCR </label>
                <input type="number" name="HRLCR" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='HRRCR'>HRRCR</label>
                <input type="number" name="HRRCR" placeholder="" min="0" value="" step=".1">
            </div>
            <hr>
            <div>
                <label for='LJouleML'>LJouleML</label>
                <input type="number" name="LJouleML" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='RJouleML'>RJouleML</label>
                <input type="number" name="RJouleML" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <hr>
                <label for='LMeanHeightML'>LMeanHeightML</label>
                <input type="number" name="LMeanHeightML" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='RMeanHeightML'>RMeanHeightML</label>
                <input type="number" name="RMeanHeightML" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <hr>
                <label for='LJouleCR'>LJouleCR</label>
                <input type="number" name="LJouleCR" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='RJouleCR'>RJouleCR</label>
                <input type="number" name="RJouleCR" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='LMeanHeightCR'>LMeanHeightCR</label>
                <input type="number" name="LMeanHeightCR" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='RMeanHeightCR'>RMeanHeightCR</label>
                <input type="number" name="RMeanHeightCR" placeholder="" min="0" value="" step=".1">
            </div>
            <hr>
            <div>
                <label for='SHL'>SHL</label>
                <input type="number" name="SHL" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='SHR'>SHR</label>
                <input type="number" name="SHR" placeholder="" min="0" value="" step=".1">
            </div>

            <hr>
            <div>
                <label for='LJL'>LJL</label>
                <input type="number" name="LJL" placeholder="" min="0" value="" step=".1">
            </div>
            <div>
                <label for='LJR'>LJR</label>
                <input type="number" name="LJR" placeholder="" min="0" value="" step=".1">
            </div>
            <hr>
            <div>
                <label for='testKommentar'>Testkommentar</label>
                <input type="text" name="testKommentar" placeholder="" value="">
            </div>

            <input style="margin-top: 20px;" class="pure-button pure-button-primary" type="submit" name='submit' value="Svara" />

        </fieldset>
    </form>
</div>
</body>

<script type="text/javascript">

</script>

</html>
