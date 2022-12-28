<?php

session_start("projekt_fot");

require("databas.php");
//require("../../korsband/utils/emails.php");
$id = $_GET['id'];
$svar = $_GET['svar'];

// testa med den vanliga varianten

//mail("<lindskog.jakob@gmail.com>", "testmail igen 3", "meddelande kommer här");
//mail("jakob@sportrehab.se", "testmail", "meddelande kommer här");
//sendHtmlMail("lindskog.jakob@gmail.com", "Testmail för samtycke", "<br><br><br><br>För att <b>ACCEPTERA</b> deltagande i ProjektKorsband,");

$headers = 'From: <projektfot22@gmail.com>'."\r\n".'Reply-To: <projektfot22@gmail.com>';
$message = 'För att ACCEPTERA trycker du på följande länk: https://lulab.it.gu.se/fot/samtycke.php?id=tjena&svar=1
För att AVBÖJA trycker du på följande länk: https://lulab.it.gu.se/fot/samtycke.php?id=halloj&svar=2 ';

//mail('<lindskog.jakob@gmail.com>', 'Projekt Fot - samtycke', $message, $headers, '-projektfot22@gmail.com');


if (isset($svar)){
    if ($svar == "1"){
        //geSamtycke($svar, $id);

    } else if($svar == "2"){
        //geSamtycke($svar, $id);

    }
}
if (!isset($svar)){
    $fel = "1";
}

if ($svar == "1" || $svar == "2"){

} else {
    $fel ="1";
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

    <h1 style="">Projekt Fot</h1>
    <?php
    if ($fel == "1"){echo "Något blev fel, vänligen kontakta projektfot22@gmail.com för att ge samtycke";}
    if ($svar == "1"){echo "<b>Du har nu givit samtycke och kan delta i Projekt Fot. Tack!</b>";}
    if ($svar == "2"){echo "<b>Du har nu givit nekat samtycke och kan inte delta i Projekt Fot.</b>";}
    ?>
</div>
</body>

<script type="text/javascript">

</script>

</html>
