<?php

session_start("projekt_fot");

require("databas.php");


//Kollar så det finns en mail.
if (!isset($_SESSION['pin'])){
    header("location:maillistaid.php");
}

if (isset($_POST['submit'])) {
    $_SESSION['uppfoljning'] = $_POST['uppfoljning'];
    header("location:maillistaexport.php");
}
if (isset($_POST['submit2'])) {
    $_SESSION['uppfoljning'] = $_POST['uppfoljning'];
    header("location:maillistaexport2.php");
}
if (isset($_POST['submit3'])) {
    header("location:tack.php");
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

    <form action='' method="post" class="pure-form pure-form-stacked"
          style="margin-top: 20px; padding-bottom: 60px;">
        <fieldset data-type="horizontal">
            Välj uppföljning
            <select type="select" name="uppfoljning">
                <option value=""></option>
                <option value="u1">u1</option>
                <option value="u2">u2</option>
                <option value="u3">u3</option>
                <option value="u4">u4</option>
                <option value="u5">u5</option>
                <option value="u6">u6</option>
                <option value="u7">u7</option>
                <option value="u8">u8</option>
                <option value="u9">u9</option>
                <option value="u10">u10</option>
                <option value="u11">u11</option>
                <option value="u12">u12</option>
                <option value="u13">u13</option>

            </select>
            <input style="margin-top: 20px;" class="pure-button pure-button-primary" type="submit" name='submit' value="Saknar svar" />
            <br>
            <input style="margin-top: 20px;" class="pure-button pure-button-primary" type="submit" name='submit2' value="Ny Akut" />
            <br>
            <input style="margin-top: 20px;" class="pure-button pure-button-primary" type="submit" name='submit3' value="LOGGA UT" />

        </fieldset>
    </form>
</div>
</body>

<script type="text/javascript">

</script>

</html>
