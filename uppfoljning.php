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
    "svarsDatum",
    "nyAkut",
    "deltagande",
    "minskadmangd",
    "prestation",
    "smarta",
    "annanOrsak"
);


//$_SESSION['uppfoljning'] = $_GET['uppfoljning'];
//Kollar så det finns en mail.
if (!isset($_SESSION['mailu']) || !isset($_SESSION['uppfoljning'])){
    header("location:uppfoljningid.php");
}

if (isset($_POST['submit'])) {
    if ($_POST['annanOrsak'] == ""){
        $_POST['annanOrsak'] = " ";
    }

    $data = array();
    $tillfalle = "testTillfälle";

    foreach ($required as $key => $value) {
        if (!isset($_POST[$value]) || $_POST[$value] == "") {
            $missing .= " $value";
        }
        else {             //fixa kryptering
            //if ($_POST[$value] == $_POST['pnr'] ){         //tar bort värdet - ska mer krypteras så är det bara att lägga till ett || och ha samma kriterie

            //} else {
            $data[$value] = $_POST[$value];
            //}
        }
    }

    if (empty($missing)) {
        //$_SESSION['id'] =  create($_POST['pnr']);

        if (strpos($_SESSION['id'], 'Error') !== false) {
            echo "$_SESSION[id] <br>";
        }
        else {
            $result = update($data, $_SESSION['mailu'], $_SESSION['uppfoljning']);   //här ska mailen användas för att uppdatera rätt rad
            //uppf($tillfalle, $_SESSION['mail']);
            if ($result != "OK") {
                echo "$result <br>";
            }
            else {
                header("location:tack.php");
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
    <?php if (isset($_POST['submit']) && $felMail == 1)  echo "<div style='color: red'>- Mailen är inte registrerad. Vänligen registrera på: <a href='https://lulab.it.gu.se/fot/intresseanmalan.php'>Intresseanmälan </a></div>"; ?>

    <form action='' method="post" class="pure-form pure-form-stacked"
          style="margin-top: 20px; padding-bottom: 60px;">
        <fieldset data-type="horizontal">

            <h2>Rapportering av nya skador och besvär(1)</h2>
            Vi önskar att du svarar på alla frågor i formuläret även om du inte har/har haft problem med fot
            och/eller underben. Svara med att sätta ett kryss i rutan för det bäst lämpade svarsalternativet,
            endast ett svarsalternativ per fråga.    <br><br>
            Om du inte är säker på vad du ska svara, försök ändå svara så gott du kan. När du svarar på frågorna
            utgå från den fot/underben som besvärat dig mest under de senaste 14 dagarna.
            <hr>
            <h3>Akut skada</h3>
            - Med akut skada menas en plötslig händelse t. ex. stukning, fall, sträckning.
            <br><br>
            Har du råkat utför en akut skada i någon kroppsdel under de senaste 14 dagarna? (Ansvarig
            testledare/fysioterapeut kontaktar dig för närmare information om Ja).
            <div>
                <input required type="radio" name="nyAkut"  value="1" <?php if(isset($_POST['nyAkut']) && $_POST['nyAkut'] == "1"){print " checked=\"checked\"";} ?>/> Ja </div>
            <div>
                <input required type="radio" name="nyAkut"  value="0" <?php if(isset($_POST['nyAkut']) && $_POST['nyAkut'] == "0"){print " checked=\"checked\"";} ?>/> Nej </div>
            <hr>
            <h3>Fot-/underbensproblem</h3>
            - Med fot-/underbensproblem menas smärta, värk, instabilitet eller andra problem i fot/underben.<br>  <br>
            Har du problem med att delta i din idrott (ordinarie träning/uppvisning/tävling) på grund av
            dina fot-/ underbensproblem?
            <div>
                <input required type="radio" name="deltagande" value="0" <?php if(isset($_POST['deltagande']) && $_POST['deltagande'] == "0"){print " checked=\"checked\"";} ?>/> Deltar för fullt, utan fot-/underbensproblem </div>
            <div>
                <input required type="radio" name="deltagande" value="8" <?php if(isset($_POST['deltagande']) && $_POST['deltagande'] == "8"){print " checked=\"checked\"";} ?>/> Deltar för fullt, men med fot-/underbensproblem</div>
            <div>
                <input required type="radio" name="deltagande" value="17" <?php if(isset($_POST['deltagande']) && $_POST['deltagande'] == "17"){print " checked=\"checked\"";} ?>/> Minskat deltagande, på grund av fot-/underbensproblem</div>
            <div>
                <input required type="radio" name="deltagande" value="25" <?php if(isset($_POST['deltagande']) && $_POST['deltagande'] == "25"){print " checked=\"checked\"";} ?>/> Kan ej delta, på grund av fot-/underbensproblem</div>
            <br>

            I vilken grad har du minskat på träningsmängden på grund av dina fot-/underbensproblem?<br>
            <div>
                <input required type="radio" name="minskadmangd" value="0" <?php if(isset($_POST['minskadmangd']) && $_POST['minskadmangd'] == "0"){print " checked=\"checked\"";} ?>/> Ingen minskning</div>
            <div>
                <input required type="radio" name="minskadmangd" value="6" <?php if(isset($_POST['minskadmangd']) && $_POST['minskadmangd'] == "6"){print " checked=\"checked\"";} ?>/> I liten grad</div>
            <div>
                <input required type="radio" name="minskadmangd" value="13" <?php if(isset($_POST['minskadmangd']) && $_POST['minskadmangd'] == "13"){print " checked=\"checked\"";} ?>/> I måttlig grad</div>
            <div>
                <input required type="radio" name="minskadmangd" value="19" <?php if(isset($_POST['minskadmangd']) && $_POST['minskadmangd'] == "19"){print " checked=\"checked\"";} ?>/> I stor grad</div>
            <div>
                <input required type="radio" name="minskadmangd" value="25" <?php if(isset($_POST['minskadmangd']) && $_POST['minskadmangd'] == "25"){print " checked=\"checked\"";} ?>/> Kan ej delta</div>
            <br>

            I vilken grad upplever du att dina fot-/underbensproblem påverkat idrottsprestationen?<br>
            <div>
                <input required type="radio" name="prestation" value="0" <?php if(isset($_POST['prestation']) && $_POST['prestation'] == "0"){print " checked=\"checked\"";} ?>/> Ingen minskning</div>
            <div>
                <input required type="radio" name="prestation" value="6" <?php if(isset($_POST['prestation']) && $_POST['prestation'] == "6"){print " checked=\"checked\"";} ?>/> I liten grad</div>
            <div>
                <input required type="radio" name="prestation" value="13" <?php if(isset($_POST['prestation']) && $_POST['prestation'] == "13"){print " checked=\"checked\"";} ?>/> I måttlig grad</div>
            <div>
                <input required type="radio" name="prestation" value="19" <?php if(isset($_POST['prestation']) && $_POST['prestation'] == "19"){print " checked=\"checked\"";} ?>/> I stor grad</div>
            <div>
                <input required type="radio" name="prestation" value="25" <?php if(isset($_POST['prestation']) && $_POST['prestation'] == "25"){print " checked=\"checked\"";} ?>/> Kan ej delta</div>
            <br>

            I vilken grad upplever du smärta i din fot/underben under ditt idrottsutövande?
            <div>
                <input required type="radio" name="smarta" value="0" <?php if(isset($_POST['smarta']) && $_POST['smarta'] == "0"){print " checked=\"checked\"";} ?>/> Ingen minskning</div>
            <div>
                <input required type="radio" name="smarta" value="8" <?php if(isset($_POST['smarta']) && $_POST['smarta'] == "8"){print " checked=\"checked\"";} ?>/> I liten grad</div>
            <div>
                <input required type="radio" name="smarta" value="17" <?php if(isset($_POST['smarta']) && $_POST['smarta'] == "17"){print " checked=\"checked\"";} ?>/> I måttlig grad</div>
            <div>
                <input required type="radio" name="smarta" value="25" <?php if(isset($_POST['smarta']) && $_POST['smarta'] == "25"){print " checked=\"checked\"";} ?>/> I stor grad</div>

            <hr>
            <h3>Annan orsak</h3>
            - Med annan orsak menas förkylning, influensa, eller skada på annan kroppsdel än ovannämnda etc.<br>
            Finns en annan orsak till varför du inte kunnat träna/tävla under de senaste sju dagarna?  <br>
            Vilken?
            <div>
                <label for='annanOrsak'></label>
                <input type="text" name="annanOrsak" placeholder="">
            </div>

            <input style="margin-top: 20px;" class="pure-button pure-button-primary" type="submit" name='submit' value="Svara" />
            <br><br>
            <hr>
            1. Detta frågeformulär innehåller för Projekt FOT relevanta delar av ett större frågeformulär: Den
            svenska versionen av Oslo Sports Trauma Centre (OSTRC) Overuse Injury Questionnaire. Ekman E,
            Frohm A, Ek P, Hagberg J, Wirén C, Heijne A. Swedish translation and validation of a web-based
            questionnaire for registration of overuse problems. Scand J Med Sci Sports. 2015 Feb;25(1):104-9.
            doi: 10.1111/sms.12157. Epub 2013 Dec 3. PMID: 24313387.
            <br><br>
            Testledare: Farshad Ashnai, Leg Fysioterapeut, BSc.                  <br>
            Ansvarig forskare: Medicine doktor Susanne Beischer, Leg Fysioterapeut.  <br>
            Kontakt: projektfot22@gmail.com och/eller susanne.beischer@gu.se

            <input type="hidden" name="svarsDatum" value="<?php echo date('Y-m-d'); ?>" />


        </fieldset>
    </form>
</div>
</body>

<script type="text/javascript">

</script>

</html>
