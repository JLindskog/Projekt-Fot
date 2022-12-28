<?php

session_start("projekt_fot");

require("databas.php");

$felMail=0;

if (isset($_POST['submit'])) {
    if($_POST['pin'] == "PF2222"){
        if (checkMail($_POST['mail']) == "OK"){
            //omvänd logik här - MAILEN SKA ALLTSÅ FINNAS FÖR ATT GÅ VIDARE
            $felMail = 1;
        } else {
            $_SESSION['mailf'] = $_POST['mail'];
            //Skapa en sessionvariabel med mail
            //Om mailen finns då ska man kunna komma vidare
            header("location:farshadinmatning.php");
        }
    }
}

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
    <h1 style="">Projekt Fot</h1>

    Fyll i den mailadress du angav vid intresseanmälan.
    <form action='' method="post" class="pure-form pure-form-stacked"
          style="margin-top: 20px; padding-bottom: 60px;">
        <fieldset data-type="horizontal">
            <div>
                <label for='mail'>E-mail: </label>
                <input required type="text" name="mail" placeholder="E-mail" value="" onkeyup="this.value = this.value.toLowerCase();">
            </div>

            <div>
                <label for='pin'>Pin-kod: </label>
                <input required type="text" name="pin" placeholder="xxxxxx" value="" >
            </div>

            <input style="margin-top: 20px;" class="pure-button pure-button-primary" type="submit" name='submit' value="Vidare" />
        </fieldset>
    </form>
</div>
</body>

<?php

?>

<script type="text/javascript">

</script>

</html>
