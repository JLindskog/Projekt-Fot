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
    "baselineSvarsDatum",
    "traningAntalAr",
    "traningTillfallenPerVecka",
    "traningTimmarPerVecka",
    "traningAnnat",
    "traningAnnatVad",
    "traningAnnatTimmar",
    "akutSkada6man",
    "akutSkadaTraningEllerTavling",
    "akutSkadaSida",
    "akutSkadaVard",
    "overbelastning6man",
    "overbelastningSida",
    "overbelastningVard"
);

//Kollar så det finns en mail.
if (!isset($_SESSION['mail'])){
    header("location:basdataid.php");
}

if (isset($_POST['submit'])) {

    if ($_POST['traningAnnatVad'] == ""){
        $_POST['traningAnnatVad'] = " ";
    }

    if ($_POST['traningAnnatTimmar'] == ""){
        $_POST['traningAnnatTimmar'] = " ";
    }

    if ($_POST['akutSkadaTraningEllerTavling'] == ""){
        $_POST['akutSkadaTraningEllerTavling'] = " ";
    }

    if ($_POST['akutSkadaSida'] == ""){
        $_POST['akutSkadaSida'] = " ";
    }

    if ($_POST['akutSkadaVard'] == ""){
        $_POST['akutSkadaVard'] = " ";
    }

    if ($_POST['overbelastningSida'] == ""){
        $_POST['overbelastningSida'] = " ";
    }

    if ($_POST['overbelastningVard'] == ""){
        $_POST['overbelastningVard'] = " ";
    }
    $data = array();
    $tillfalle = "baseline";

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
            $result = update($data, $_SESSION['mail']);   //här ska mailen användas för att uppdatera rätt rad
            uppf($tillfalle, $_SESSION['mail']);
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

    <form action='' method="post" class="pure-form pure-form-stacked"
          style="margin-top: 20px; padding-bottom: 60px;">
        <fieldset data-type="horizontal">
            Vi ber dig fylla i nedan formulär.<br><br>
            Är du/ditt barn under 15 år önskar vi att du/ditt barn, i så stor utsträckning det går, svarar själv.<br><br>

            <b>Frågor om din träning: </b> <br><br>

            Hur länge har du tränat truppgymnastik?
            <div>
                <input required type="radio" name="traningAntalAr" value="1" <?php if(isset($_POST['traningAntalAr']) && $_POST['traningAntalAr'] == "1"){print " checked=\"checked\"";} ?>/> 1-3 år </div>
            <div>
                <input required type="radio" name="traningAntalAr" value="2" <?php if(isset($_POST['traningAntalAr']) && $_POST['traningAntalAr'] == "2"){print " checked=\"checked\"";} ?>/> 4-6 år </div>
            <div>
                <input required type="radio" name="traningAntalAr" value="3" <?php if(isset($_POST['traningAntalAr']) && $_POST['traningAntalAr'] == "3"){print " checked=\"checked\"";} ?>/> 7-9 år </div>
            <div>
                <input required type="radio" name="traningAntalAr" value="4" <?php if(isset($_POST['traningAntalAr']) && $_POST['traningAntalAr'] == "4"){print " checked=\"checked\"";} ?>/> 10-12 år </div>
            <div>
                <input required type="radio" name="traningAntalAr" value="5" <?php if(isset($_POST['traningAntalAr']) && $_POST['traningAntalAr'] == "5"){print " checked=\"checked\"";} ?>/> 13 år eller mer </div>
            <br>

            Hur många gånger i veckan (i snitt) tränar du truppgymnastik?
            <div>
                <input required type="radio" name="traningTillfallenPerVecka" value="1" <?php if(isset($_POST['traningTillfallenPerVecka']) && $_POST['traningTillfallenPerVecka'] == "1"){print " checked=\"checked\"";} ?>/> 1 gång </div>
            <div>
                <input required type="radio" name="traningTillfallenPerVecka" value="2" <?php if(isset($_POST['traningTillfallenPerVecka']) && $_POST['traningTillfallenPerVecka'] == "2"){print " checked=\"checked\"";} ?>/> 2 gånger </div>
            <div>
                <input required type="radio" name="traningTillfallenPerVecka" value="3" <?php if(isset($_POST['traningTillfallenPerVecka']) && $_POST['traningTillfallenPerVecka'] == "3"){print " checked=\"checked\"";} ?>/> 3 gånger </div>
            <div>
                <input required type="radio" name="traningTillfallenPerVecka" value="4" <?php if(isset($_POST['traningTillfallenPerVecka']) && $_POST['traningTillfallenPerVecka'] == "4"){print " checked=\"checked\"";} ?>/> 4 gånger </div>
            <div>
                <input required type="radio" name="traningTillfallenPerVecka" value="5" <?php if(isset($_POST['traningTillfallenPerVecka']) && $_POST['traningTillfallenPerVecka'] == "5"){print " checked=\"checked\"";} ?>/> 5 gånger eller mer </div>
            <br>

            Hur många timmar per vecka (i snitt) tränar du truppgymnastik?
            <div>
                <input required type="radio" name="traningTimmarPerVecka" value="1" <?php if(isset($_POST['traningTimmarPerVecka']) && $_POST['traningTimmarPerVecka'] == "1"){print " checked=\"checked\"";} ?>/> 1-3 timmar </div>
            <div>
                <input required type="radio" name="traningTimmarPerVecka" value="2" <?php if(isset($_POST['traningTimmarPerVecka']) && $_POST['traningTimmarPerVecka'] == "2"){print " checked=\"checked\"";} ?>/> 4-6 timmar </div>
            <div>
                <input required type="radio" name="traningTimmarPerVecka" value="3" <?php if(isset($_POST['traningTimmarPerVecka']) && $_POST['traningTimmarPerVecka'] == "3"){print " checked=\"checked\"";} ?>/> 7-9 timmar </div>
            <div>
                <input required type="radio" name="traningTimmarPerVecka" value="4" <?php if(isset($_POST['traningTimmarPerVecka']) && $_POST['traningTimmarPerVecka'] == "4"){print " checked=\"checked\"";} ?>/> 10-12 timmar </div>
            <div>
                <input required type="radio" name="traningTimmarPerVecka" value="5" <?php if(isset($_POST['traningTimmarPerVecka']) && $_POST['traningTimmarPerVecka'] == "5"){print " checked=\"checked\"";} ?>/> 13 timmar eller mer </div>
            <br>

            Tränar du något annat än truppgymnastik?
            <div>
                <input required type="radio" name="traningAnnat"  value="1" <?php if(isset($_POST['traningAnnat']) && $_POST['traningAnnat'] == "1"){print " checked=\"checked\"";} ?>/> Ja </div>
            <div>
                <input required type="radio" name="traningAnnat"  value="0" <?php if(isset($_POST['traningAnnat']) && $_POST['traningAnnat'] == "0"){print " checked=\"checked\"";} ?>/> Nej </div>
            <br>
            Om ja:
            <div>
                <label for='traningAnnatVad'>Vilken sport: </label>
                <input type="text" name="traningAnnatVad" placeholder="" value="">
            </div>
            <div>
                <label for='traningAnnatTillfallen'>Hur många timmar/vecka: </label>
                <input type="number" name="traningAnnatTimmar" placeholder="" min="0" value="">
            </div>
            <hr>
            <b>Frågor om eventuella skador: </b>            <br>
            Har du, inom de senaste 6 månaderna, drabbats av <b>akut skada </b> (t ex stukning) i fot/fotled/underben i samband med gymnastik som gjort att du behövt träna mindre, tejpa foten, eller vila helt från gymnastiken under minst en träning? <br><br>
            <div>
                <input required type="radio" name="akutSkada6man" value="0" <?php if(isset($_POST['akutSkada6man']) && $_POST['akutSkada6man'] == "0"){print " checked=\"checked\"";} ?>/> Nej </div>
            <div>
                <input required type="radio" name="akutSkada6man" value="1" <?php if(isset($_POST['akutSkada6man']) && $_POST['akutSkada6man'] == "1"){print " checked=\"checked\"";} ?>/> Ja, en gång </div>
            <div>
                <input required type="radio" name="akutSkada6man" value="2" <?php if(isset($_POST['akutSkada6man']) && $_POST['akutSkada6man'] == "2"){print " checked=\"checked\"";} ?>/> Ja, två eller flera gånger </div>
            <br>
            Om ja, <br>
            Skedde skadan på träning eller tävling?
            <div>
                <input type="radio" name="akutSkadaTraningEllerTavling" value="1" <?php if(isset($_POST['akutSkadaTraningEllerTavling']) && $_POST['akutSkadaTraningEllerTavling'] == "1"){print " checked=\"checked\"";} ?>/> Träning </div>
            <div>
                <input type="radio" name="akutSkadaTraningEllerTavling" value="2" <?php if(isset($_POST['akutSkadaTraningEllerTavling']) && $_POST['akutSkadaTraningEllerTavling'] == "2"){print " checked=\"checked\"";} ?>/> Tävling</div>
            <div>
                <input type="radio" name="akutSkadaTraningEllerTavling" value="3" <?php if(isset($_POST['akutSkadaTraningEllerTavling']) && $_POST['akutSkadaTraningEllerTavling'] == "3"){print " checked=\"checked\"";} ?>/> Båda</div>
            <br>
            Vilken sida skedde skadan på? (Har du skadat dig på båda sidor ber vid dig markera i den sida som besvärat dig mest)
            <div>
                <input type="radio" name="akutSkadaSida" value="1" <?php if(isset($_POST['akutSkadaSida']) && $_POST['akutSkadaSida'] == "1"){print " checked=\"checked\"";} ?>/> Vänster </div>
            <div>
                <input type="radio" name="akutSkadaSida" value="2" <?php if(isset($_POST['akutSkadaSida']) && $_POST['akutSkadaSida'] == "2"){print " checked=\"checked\"";} ?>/> Höger </div>
            <br>
            Uppsökte du vård för skadan?
            <div>
                <input type="radio" name="akutSkadaVard" value="1" <?php if(isset($_POST['akutSkadaVard']) && $_POST['akutSkadaVard'] == "1"){print " checked=\"checked\"";} ?>/> Ja </div>
            <div>
                <input type="radio" name="akutSkadaVard" value="0" <?php if(isset($_POST['akutSkadaVard']) && $_POST['akutSkadaVard'] == "0"){print " checked=\"checked\"";} ?>/> Nej </div>
            <br>
            <hr>
            Har du, inom de senaste 6 månaderna, haft <b> smärta eller annat obehag </b> i fot/fotled/underben <b>som uppkommit gradvis</b> i samband med gymnastik och gjort att du behövt träna mindre, tejpa foten, eller vila helt från gymnastiken under minst en träning?    <br><br>
            <div>
                <input required type="radio" name="overbelastning6man" value="0" <?php if(isset($_POST['overbelastning6man']) && $_POST['overbelastning6man'] == "0"){print " checked=\"checked\"";} ?>/> Nej </div>
            <div>
                <input required type="radio" name="overbelastning6man" value="1" <?php if(isset($_POST['overbelastning6man']) && $_POST['overbelastning6man'] == "1"){print " checked=\"checked\"";} ?>/> Ja, en gång </div>
            <div>
                <input required type="radio" name="overbelastning6man" value="2" <?php if(isset($_POST['overbelastning6man']) && $_POST['overbelastning6man'] == "2"){print " checked=\"checked\"";} ?>/> Ja, två eller flera gånger </div>
            <br>
            Om ja, <br>
            I vilken sida har du upplevt besvären? (Har du upplevt besvären på båda sidor ber vid dig markera i den sida som besvärat dig mest)
            <div>
                <input type="radio" name="overbelastningSida" value="1" <?php if(isset($_POST['overbelastningSida']) && $_POST['overbelastningSida'] == "1"){print " checked=\"checked\"";} ?>/> Vänster </div>
            <div>
                <input type="radio" name="overbelastningSida" value="2" <?php if(isset($_POST['overbelastningSida']) && $_POST['overbelastningSida'] == "2"){print " checked=\"checked\"";} ?>/> Höger </div>
            <br>
            Uppsökte du vård för besvären?
            <div>
                <input type="radio" name="overbelastningVard" value="1" <?php if(isset($_POST['overbelastningVard']) && $_POST['overbelastningVard'] == "1"){print " checked=\"checked\"";} ?>/> Ja </div>
            <div>
                <input type="radio" name="overbelastningVard" value="0" <?php if(isset($_POST['overbelastningVard']) && $_POST['overbelastningVard'] == "0"){print " checked=\"checked\"";} ?>/> Nej </div>

            <input type="hidden" name="baselineSvarsDatum" value="<?php echo date('Y-m-d'); ?>" />

            <input style="margin-top: 20px;" class="pure-button pure-button-primary" type="submit" name='submit' value="Svara" />

        </fieldset>
    </form>
</div>
</body>

<script type="text/javascript">

</script>

</html>
