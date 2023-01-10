<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset ="UTF-8">
    <meta name = "viewport" content ="width = device-width, initial-scale = 1.0">
    <title>eMedication webservice</title >
    <link rel="stylesheet" href="websiteStyle.css">
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]) || !$_FILES["medikationsliste"]["error"]  == UPLOAD_ERR_OK) {
    echo "<p class='error'>No data input\u{2026}</p>";
    die("sorry\u{2026}");
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$target_dir = "upload/";
$path = $target_dir;
$tmp_name = $_FILES["medikationsliste"]["tmp_name"];
$newName = basename($_FILES["medikationsliste"]["name"]);
$path .= "$newName";
move_uploaded_file($tmp_name, $path);


$document = new DOMDocument();
$document -> load($path);

$xpath = new DOMXpath($document);
$xpath->registerNamespace("hl7","urn:hl7-org:v3");
$xpath->registerNamespace("m","urn:ihe:pharm:medication");

$patientRole = $xpath->query('//hl7:recordTarget/hl7:patientRole')->item(0);
if(!$patientRole instanceof DOMElement){
    echo "<p class='error'>No valid patient info found\u{2026}</p>";
    return;
}
// echo "<p class='success'>Patient: ". $patientRole->textContent . "</p>";

$svnr = $xpath->query('hl7:id[@root="1.2.40.0.10.1.4.3.1"'/*oid:svnr-eHealth*/.']/@extension', $patientRole)->item(0);
if($svnr instanceof DOMNode) {
    $_SESSION["svnr"] = $svnr->textContent;
    echo "<p class='success'>SVNR: ". $svnr->textContent . "</p>";
} else {
    echo "<p class='error'>No austrian social security number found\u{2026}</p>";
}

$firstname = $xpath->query('hl7:patient/hl7:name/hl7:given', $patientRole)->item(0);
if($firstname instanceof DOMNode) {
    $firstname = $firstname->textContent;
    $_SESSION["firstname"] = $firstname;
    echo "<p class='success'>First Name(s): ". $firstname . "</p>";
} else {
    echo "<p class='error'>No first name found\u{2026}</p>";
}

$lastname = $xpath->query('hl7:patient/hl7:name/hl7:family', $patientRole)->item(0);
if($lastname instanceof DOMNode) {
    $lastname = $lastname->textContent;
    $_SESSION["lastname"] = $lastname;
    echo "<p class='success'>Last Name: ". $lastname . "</p>";
} else {
    $lastname = null;
    echo "<p class='error'>No last name found\u{2026}</p>";
}

$birthdate = $xpath->query('hl7:patient/hl7:birthTime/@value', $patientRole)->item(0);
if($birthdate instanceof DOMNode) {
    $iso8601_dob = substr_replace(substr_replace($birthdate->textContent,"-",6,0),"-",4,0);
    $_SESSION["dob"] = $iso8601_dob;
    echo "<p class='success'>DOB: ". $iso8601_dob . "</p>";
} else {
    echo "<p class='error'>No birthdate found\u{2026}</p>";
}

$gender = $xpath->query('hl7:patient/hl7:administrativeGenderCode/@code', $patientRole)->item(0);
if($gender instanceof DOMNode) {
    $gender = $gender->textContent;
    $_SESSION["gender"] = $gender;
    echo "<p class='success'>HL7 administrative gender code: ". $gender . "</p>";
} else {
    echo "<p class='error'>No gender found\u{2026}</p>";
    $gender = null;
}

$marriage = $xpath->query('hl7:patient/hl7:maritalStatusCode/@code', $patientRole)->item(0);
if($marriage instanceof DOMNode) {
    $marriage = $marriage->textContent;
    $_SESSION["marriage"] = $marriage;
    echo "<p class='success'>HL7 marital status code: ". $marriage . "</p>";
} else {
    $marriage = null;
    echo "<p class='error'>No marital status found\u{2026}</p>";
}

$address = $xpath->query('hl7:addr[@use="HP"]'/*only get the first home address*/, $patientRole)->item(0);
$addrLine = $xpath->query('hl7:streetAddressLine', $address)->item(0);
if($addrLine instanceof DOMNode) {
    $addrLine = $addrLine ->textContent;
    $_SESSION["addrline"] = $addrLine;
    echo "<p class='success'>Address line: ". $addrLine . "</p>";
} else {
    $addrLine = null;
    echo "<p class='error'>No street and house number found\u{2026}</p>";
}

$city = $xpath->query('hl7:city', $address)->item(0);
if($city instanceof DOMNode) {
    $city = $city->textContent;
    $_SESSION["city"] = $city;
    echo "<p class='success'>City: ". $city . "</p>";
} else {
    $city = null;
    echo "<p class='error'>No city found\u{2026}</p>";
}

$plz = $xpath->query('hl7:postalCode', $address)->item(0);
if($plz instanceof DOMNode) {
    $plz = $plz->textContent;
    $_SESSION["plz"] = $plz;
    echo "<p class='success'>Postal code: ". $plz . "</p>";
} else {
    $plz = null;
    echo "<p class='error'>No postal code found\u{2026}</p>";
}

$country = $xpath->query('hl7:country', $address)->item(0);
if($country instanceof DOMNode) {
    $country = $country->textContent;
    $_SESSION["country"] = $country;
    echo "<p class='success'>Country: ". $country . "</p>";
} else {
    echo "<p class='error'>No country found\u{2026}</p>";
    $country = null;
}
$tel = null;
$email = null;
$telecoms = $xpath->query('//hl7:telecom/@value', $patientRole);
foreach ($telecoms as $telecom){
    $strings = explode(":", $telecom->textContent);
    if($strings[0]=="tel"){
        $tel = str_replace(".","",$strings[1]);
    }
    if($strings[0]=="mailto"){
        $email = $strings[1];
    }
}
if($tel) {
    $_SESSION["tel"] = $tel;
    echo "<p class='success'>Tel: ". $tel . "</p>";
} else {
    echo "<p class='error'>No telephone number found\u{2026}</p>";
}
if($email) {
    $_SESSION["mail"] = $email;
    echo "<p class='success'>Email: ". $email . "</p>";
} else {
    echo "<p class='error'>No email address found\u{2026}</p>";
}

// select all substanceAdministrations with entryRelationship-children (only the outer ones)
$prescriptions = $xpath->query('//hl7:substanceAdministration[parent::hl7:entry]');
$i = 1;
$dosage_total = array(0,0,0,0);
foreach ($prescriptions as $prescription){
    if($prescription instanceof DOMNode) {
        // kürzerer name: "hl7:consumable/descendant::hl7:name"
        $name = $xpath->query("hl7:consumable/descendant::hl7:translation/@displayName",$prescription)->item(0);
        if($name instanceof DOMNode){
            $name = trim(explode("-", $name->textContent)[0]);
        } else $name = "";

        // https://terminology.hl7.org/2.1.0/CodeSystem-v3-TimingEvent.html
        $dosage = array(0,0,0,0);
        $events = $xpath->query("hl7:entryRelationship/hl7:substanceAdministration/hl7:effectiveTime/hl7:event/@code",$prescription);
        foreach ($events as $event){ // for each time of day
            if($event instanceof DOMNode){
                $qtty = intval($xpath->query("ancestor::hl7:substanceAdministration/hl7:doseQuantity/@value",$event)->item(0)->textContent);
                if($qtty < 0) $qtty = 0;
                if($qtty > 9) $qtty = 9;
                $event = $event->textContent;
                switch ($event){
                    case "ACM": // vor frühstück
                    case "CM":  // während frühstück
                    case "PCM": // nach frühstück
                    case "ICM": // zwischen frühstück und mittagessen
                        $dosage[0] = $qtty;
                        $dosage_total[0] += $qtty;
                        break;
                    case "ACD": // vor mittagessen
                    case "CD":  // während mittagessen
                    case "PCD": // nach mittagessen
                        $dosage[1] = $qtty;
                        $dosage_total[1] += $qtty;
                        break;
                    case "ICD": // zwischen mittag- und abendessen
                    case "ACV": // vor abendessen
                    case "CV":  // beim abendessen
                        $dosage[2] = $qtty;
                        $dosage_total[2] += $qtty;
                        break;
                    case "PCV": // nach abendessen
                    case "ICV": // zwischen abendessen und schlafen
                    case "HS":  // vor schlafen
                        $dosage[3] = $qtty;
                        $dosage_total[3] += $qtty;
                        break;
                }
            }
        }

        $dosage_out = implode("-",$dosage);
        $filename = sprintf("./output/%s.txt", preg_replace("/\s+/", "", $name));
        echo "<p class='success'>Prescription {$i}:<br>
            {$name}, {$dosage_out}";

        $_SESSION["drug{$i}"] = $name;
        $_SESSION["dosage{$i}"] = $dosage;

        if($handle = fopen($filename,"w")){
            if(fwrite($handle, resultString($dosage)))
                echo "<br>saved file as \"{$filename}\"";
            fclose($handle);
        }
        echo "</p>";
        $i++;
    }
}

if($fh = fopen("./output/total.txt","w")){
    if(fwrite($fh, resultString($dosage_total)))
        echo '<p class="success">saved congregated file as "WIINF-backend/output/total.txt"</p>';
    fclose($fh);
}

header("Location: dataInputs.php");


/**
 * @param int[] $results array of (at least) 4 integers
 * @param bool $binary [optional]<br>specifies whether to write 0x00/0x01 (true) or 0x30/0x31 (false)
 * @return String string of length 4 to print to file for arduino. each char is either 0 or 1, representation depends on parameter $binary
 */
function resultString(array $results, bool $binary = false): String{
    if (count($results) > 4) return $binary?"\x00\x00\x00\x00":"0000";
    return sprintf($binary?"%c%c%c%c":"%1b%1b%1b%1b",
        $results[0]>0,
        $results[1]>0,
        $results[2]>0,
        $results[3]>0);
}
?>
</body>