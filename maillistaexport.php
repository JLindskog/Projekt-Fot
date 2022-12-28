<?php
session_start("projekt_fot");

$uppfoljning = $_SESSION['uppfoljning'];
if (!isset($_SESSION['pin'])){
    header("location:maillistaid.php");
}

$con = mysql_connect("localhost","dbuser","Pentium2!");
if (!$con){die('Could not connect: ' . mysql_error());}
mysql_select_db("forskning", $con);
$salt="kh3b4sd2b36";


$result = mysql_query("Select 
	 id,
   aes_decrypt(mail, '".$salt."') AS mail,
   testdatum,
   aes_decrypt(telefonnummer, '".$salt."') AS telefonnummer
  
   
	 FROM projekt_fot
   WHERE ".$uppfoljning."svarsDatum = ''
   ");


$title = "$uppfoljning Saknar svar - Projekt Fot".date("Y-m-d");


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");

$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
for ($i = 0; $i < mysql_num_fields($result); $i++)
{
    echo mysql_field_name($result,$i) . "\t";
}


print("\n");
//end of printing column names
//start while loop to get data
while($row = mysql_fetch_array($result))
{
    //set_time_limit(60); // HaRa
    $schema_insert = "";
    for($j=0; $j<mysql_num_fields($result);$j++)
    {
        if(!isset($row[$j]))
            $schema_insert .= "".$sep;
        elseif ($row[$j] != "")
            $schema_insert .= "$row[$j]".$sep;
        else
            $schema_insert .= "".$sep;
    }
    //------------------------------------------------------------------------------------------
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    //following fix suggested by Josue (thanks, Josue!)
    //this corrects output in excel when table fields contain n or r
    //these two characters are now replaced with a space
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}
?>