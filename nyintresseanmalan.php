<?php

session_start("projekt_fot");

require("databas.php");

$required = array(
    "namn",
    "mail",
    "telefonnummer",
);

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$felMail =0;
if (isset($_POST['submit'])) {                         // behöver veta vad som ska läggas till i databas i det här steget
    if (checkMail($_POST['mail']) != "OK"){
        $felMail=2;
    }
    else {


        $email = test_input($_POST['mail']);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Felaktigt mailformat";
        } else {
            if ($_POST['mail'] == $_POST['bmail']){
                $data = array();
                $felMail = 1;

                foreach ($required as $key => $value) {
                    if (!isset($_POST[$value]) || $_POST[$value] == "") {
                        $missing .= " $value";
                    }
                    else {             //fixa kryptering
                        if ($_POST[$value] == $_POST['mail'] || $_POST[$value] == $_POST['telefonnummer'] ){         //tar bort värdet - ska mer krypteras så är det bara att lägga till ett || och ha samma kriterie

                        } else {
                            $data[$value] = $_POST[$value];
                        }
                    }
                }

                if (empty($missing)) {                    //fixa rätt saker
                    $_SESSION['id'] = create($_POST['mail'], $_POST['telefonnummer']);


                    if (strpos($_SESSION['id'], 'Error') !== false) {
                        echo "$_SESSION[id] <br>";
                    }
                    else {
                        if ($_POST['alder'] < 15 ){ //till föräldrar
                            $headers = 'From: <projektfot22@gmail.com>'."\r\n".'Reply-To: <projektfot22@gmail.com>';
                            $message = 'För att ACCEPTERA trycker du på följande länk: https://lulab.it.gu.se/fot/samtycke.php?id=$_SESSION[id]&svar=1
                          För att AVBÖJA trycker du på följande länk: https://lulab.it.gu.se/fot/samtycke.php?id=$_SESSION[id]&svar=2 ';

                            //mail('<lindskog.jakob@gmail.com>', 'Projekt Fot - samtycke', $message, $headers, '-projektfot22@gmail.com');

                            header("location:intressetack.php");
                        } else if ($_POST['alder'] > 17){ //till gymnast
                            $headers = 'From: <projektfot22@gmail.com>'."\r\n".'Reply-To: <projektfot22@gmail.com>';
                            $message = 'För att ACCEPTERA trycker du på följande länk: https://lulab.it.gu.se/fot/samtycke.php?id=$_SESSION[id]&svar=1
                          För att AVBÖJA trycker du på följande länk: https://lulab.it.gu.se/fot/samtycke.php?id=$_SESSION[id]&svar=2 ';

                            //mail('<jakob@sportrehab.se>', 'Projekt Fot - samtycke', $message, $headers, '-projektfot22@gmail.com');

                            header("location:intressetack.php");
                        } else {                         // till sista alternativet
                            $headers = 'From: <projektfot22@gmail.com>'."\r\n".'Reply-To: <projektfot22@gmail.com>';
                            $message = 'För att ACCEPTERA trycker du på följande länk: https://lulab.it.gu.se/fot/samtycke.php?id=$_SESSION[id]&svar=1
                          För att AVBÖJA trycker du på följande länk: https://lulab.it.gu.se/fot/samtycke.php?id=$_SESSION[id]&svar=2 ';

                            //mail('<lindskog.jakob@gmail.com>', 'Projekt Fot - samtycke', $message, $headers, '-projektfot22@gmail.com');

                            header("location:intressetack.php");
                        }


                    }
                } else {
                    $felMail = 0;
                }
            }
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
    <?php if (isset($_POST['submit']) && $felMail == 0)  echo "<div style='color: red'>- Mailen är inte rätt ifylld. </div>"; ?>
    <?php if (isset($_POST['submit']) && $felMail == 2)  echo "<div style='color: red'>- Mailen används redan. </div>"; ?>

    <h1 style="">Projekt Fot</h1>

    Välkommen till Projekt Fot vars syfte är att på lång sikt utveckla en modell för att underlätta och förbättra omhändertagande av gymnaster med olika typer av skador i fot, fotled och underben.  <br><br>
    Som deltagare i projektet får du/ditt barn svara på frågeformulär, testa uthålligheten i musklerna kring fot/underben och göra hopptester. Är du intresserad av att vara med i projektet?   <br><br>

    Fyll i ditt mobilnummer och mailadress.
    <form action='' method="post" class="pure-form pure-form-stacked"
          style="margin-top: 20px; padding-bottom: 60px;">
        <fieldset data-type="horizontal">
            <div>
                <label for='namn'>Namn: </label>
                <input required type="text" name="namn" placeholder="Förnamn Efternamn" value="">
            </div>
            <div>
                <label for='alder'>Ålder: </label>
                <input required type="number" name="alder" placeholder="ÅÅ" value="" min="0" max="100">
            </div>
            <div>
                <label for='mail'>E-mail: </label>
                <input required type="text" name="mail" placeholder="E-mail" value="" onkeyup="this.value = this.value.toLowerCase();">
            </div>
            <div>
                <label for='bmail'> Bekräfta E-mail: </label>
                <input required type="text" name="bmail" placeholder="E-mail" value="" onkeyup="this.value = this.value.toLowerCase();">
            </div>
            <div>
                <label for='telefonnummer'>Mobilnummer: </label>
                <input required type="text" name="telefonnummer" placeholder="Mobilnummer" value="">
            </div>
            <br>
            Om deltagaren inte ännu fyllt 15 år behövs kontaktinformation till förälder/vårdnadshavare.
            <p style="color:red"> <b> För vårdnadshavare med flera barn som önskar deltaga görs en anmälan per barn och vi ber vi er använda unika mailadresser för respektive barn.  </b>   </p>
            <div>
                <label for='vardnadshavarenamn1'>Vårdnadshavare 1, namn: </label>
                <input required type="text" name="vardnadshavarenamn1" placeholder="Förnamn Efternamn" value="">
            </div>
            <div>
                <label for='vardnadshavaremail1'>Vårdnadshavare 1, E-mail: </label>
                <input required type="text" name="vardnadshavaremail1" placeholder="E-mail" value="" onkeyup="this.value = this.value.toLowerCase();">
            </div>
            <br>
            <div>
                <label for='ej2vardnadshavare'>Jag har inte två vårdnadshavare </label>
                <input type="checkbox" name="ej2vardnadshavare" value="1">
            </div>
            <div>
                <label for='vardnadshavarenamn2'>Vårdnadshavare 2, namn: </label>
                <input required type="text" name="vardnadshavarenamn2" placeholder="Förnamn Efternamn" value="">
            </div>
            <div>
                <label for='vardnadshavaremail2'>Vårdnadshavare 2, E-mail: </label>
                <input required type="text" name="vardnadshavaremail2" placeholder="E-mail" value="" onkeyup="this.value = this.value.toLowerCase();">
            </div>
            <input style="margin-top: 20px;" class="pure-button pure-button-primary" type="submit" name='submit' value="Intresseanmäl" />
        </fieldset>
    </form>
</div>
</body>

<?php

?>

<script type="text/javascript">

</script>

</html>
