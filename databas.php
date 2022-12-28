<?php
$GLOBALS['conn'] = new mysqli("localhost","dbuser","Pentium2!", "forskning");
if ($GLOBALS['conn']->connect_error)
    die("Connection failed: " . $GLOBALS['conn']->connect_error);

$GLOBALS['salt'] = "kh3b4sd2b36";

function create($mail, $telefonnummer) {
    $conn = $GLOBALS['conn'];
    $salt = $GLOBALS['salt'];

    $sql = "INSERT INTO projekt_fot (mail, telefonnummer) VALUES (
            AES_ENCRYPT('$mail','$salt'),
            AES_ENCRYPT('$telefonnummer','$salt')
            )";

    if ($conn->query($sql) != TRUE) {
        $error = "Error: " . $sql . "<br>" . $conn->error;
        echo "$error<br>";
        return $error;
    }

    $last_id = $conn->insert_id;
    return $last_id;
}

function update($data, $id, $uppfoljning) {
    $conn = $GLOBALS['conn'];

    $set = "";
    foreach ($data as $key => $value) {
        if (empty($set)) {
            $set = "$uppfoljning$key = '$value'";
        }
        else {
            $set .= ", $uppfoljning$key = '$value'";
        }
    }
    $salt = $GLOBALS['salt'];
    $sql = "UPDATE projekt_fot
            SET $set      
            WHERE mail = AES_ENCRYPT('$id','$salt')";      //använder mailen här -Ska vi göra så att de behöver ange mailen för att få tillgång till sidan?

    if ($conn->query($sql) != TRUE) {
        $error = "Error: " . $sql . "<br>" . $conn->error;
        return $error;
    }

    return "OK";
}

function checkMail($data) {

    $conn = $GLOBALS['conn'];
    $salt = $GLOBALS['salt'];
    //nya databasen
    $query = mysqli_query($conn, "SELECT * 
            FROM projekt_fot
            WHERE mail = AES_ENCRYPT('$data', '$salt')" );             //har testat variant med AES_DECRYPT(mail, '$salt') = '$data' men har inte gjort någon skillnad.


    if(mysqli_num_rows($query)>0){
        return "upptagen";
    } else {
        return "OK";
    }


}

function uppf($tillfalle, $id){
    $salt = $GLOBALS['salt'];
    $conn = $GLOBALS['conn'];

    $sql = "UPDATE projekt_fot  
          SET uppfoljning = '$tillfalle'
          WHERE mail =  AES_ENCRYPT('$id','$salt')";

    if ($conn->query($sql) != TRUE) {
        $error = "Error: " . $sql . "<br>" . $conn->error;
        return $error;
    }
}

function geSamtycke($svar, $id){
    $salt = $GLOBALS['salt'];
    $conn = $GLOBALS['conn'];

    $sql = "UPDATE projekt_fot
          SET samtycke = '$svar'
          WHERE id = '$id'";

    if ($conn->query($sql) != TRUE) {
        $error = "Error: " . $sql . "<br>" . $conn->error;
        return $error;
    }

}
?>
