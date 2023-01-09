<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dateNow = date("Y-m-d");
    $dontproceed=0;
    if (empty($_POST["patientID"])) {
        $patientID_ERROR = 'Please enter the Patient-ID!';
    }else {
        if (checkSV($_POST["patientID"]) == 10) {
            //echo "Patient ID:",$_POST["patientID"];echo "<br>";
            $patientID_SUCCESS = "PatientID set successfully";
        }else{
            $patientID_ERROR = 'Invalid Patient-ID!';
        }
    }

    if (empty($_POST["firstname"])) {
        $firstname_ERROR = 'Please enter your Firstname!';
    }else {
        //echo "Firstname: ",$_POST["firstname"];echo "<br>";
        $firstname_SUCCESS = "First Name set successfully";
    }

    if (!(empty($_POST["secondName"]))){
        //echo "Second Name: ",$_POST["secondName"];echo "<br>";
        $secondName_SUCCESS = "Second Name set successfully";
    }

    if (empty($_POST["familyName"])) {
        $familyName_ERROR = 'Please enter your Family Name!';
    }else {
        //echo "Family Name: ",$_POST["familyName"];echo "<br>";
        $familyName_SUCCESS = "Family Name set successfully";
    }

    if (empty($_POST["birthdate"])){
        $birthdate_ERROR = "Please enter your Birthdate!";
    }else {
        if ($_POST["birthdate"] < $dateNow){
            //echo "Birthdate: ",$_POST["birthdate"];echo "<br>";
            $birthdate_SUCCESS = "Birthdate set successfully.";
        }else if($_POST["birthdate"] > $dateNow){
            $birthdate_ERROR = "Invalid Birthdate. Date exceeds today's Date.";
        }
    }

    if(empty($_POST["gender"])){
        $gender_ERROR = "Please select a Gender!";
    }else {
        //echo "Gender: ";
        if($_POST["gender"] == "female"){
            // echo "Female";echo "<br>";
            $gender_SUCCESS = "Gender set successfully.";
        } if($_POST["gender"] == "male"){
            // echo "Male";echo "<br>";
            $gender_SUCCESS="Gender set successfully.";
        }if ($_POST["gender"] == "other") {
            // echo "Other";echo "<br>";
            $gender_SUCCESS="Gender set successfully.";
        }}


    if(empty($_POST["maritalStatus"])){
        $maritalStatus_ERROR = "Please select a Marital Status!";
    }else {
        // echo "Marital Status: ";
        if($_POST["maritalStatus"] == "single"){
            // echo "Single";echo "<br>";
            $maritalStatus_SUCCESS = "Marital Status set successfully.";
        }if($_POST["maritalStatus"] == "married"){
            // echo "Married";echo "<br>";
            $maritalStatus_SUCCESS = "Marital Status set successfully.";
        }if($_POST["maritalStatus"] == "divorced"){
            // echo "Divorced";echo "<br>";
            $maritalStatus_SUCCESS = "Marital Status set successfully.";
        }if($_POST["maritalStatus"] == "domesticPartner"){
            // echo "Domestic Partner";echo "<br>";
            $maritalStatus_SUCCESS = "Marital Status set successfully.";
        }
    }

    if (empty($_POST["address"])) {
        $address_ERROR = 'Please enter your Address!';
    }else {
        // echo "Address: ",$_POST["address"];echo "<br>";
        $address_SUCCESS = "Address set successfully.";
    }

    if (empty($_POST["email"])) {
        $email_ERROR = 'Please enter your E-Mail address!';
    }else {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            // echo "E-Mail: ",$_POST["email"]; echo "<br>";
            $email_SUCCESS = "E-Mail set successfully.";
        }else{
            $email_ERROR = "Invalid E-Mail!";
        }
    }

    if (empty($_POST["postalCode"])) {
        $postalCode_ERROR = 'Please enter your Postal Code!';
    }else {
        if (strlen($_POST["postalCode"]) == 4) {
            //echo "Postal Code: ",$_POST["postalCode"];echo "<br>";
            $postalCode_SUCCESS = "Postal Code set successfully.";
        } else{
            $postalCode_ERROR = "Invalid Postal Code!";
        }
    }

    if (empty($_POST["city"])) {
        $city_ERROR = 'Please enter your City!';
    }else {
        //echo "City: ",$_POST["city"];echo "<br>";
        $city_SUCCESS = "City set successfully.";
    }

    if (empty($_POST["phoneNumber"])) {
        $phoneNumber_ERROR = 'Please enter your Phone Number!';
    }else {
        if (strlen($_POST["phoneNumber"])==11||strlen($_POST["phoneNumber"])==13){
            //echo "Phone Number: ", $_POST["phoneNumber"];echo "<br>";
            $phoneNumber_SUCCESS = "Phone Number set successfully.";
        }else{
            $phoneNumber_ERROR = "Invalid Phone Number!";
        }
    }
    if (empty($_POST["weekDays"])){
        $weekdays_ERROR = "Please select the days on which the patient should take the medication";
    }else{
        foreach ($_POST["weekDays"] as $value){
           // echo $value.'<br/>';
            $weekdays_SUCCESS = "The correct weekdays were set successfully";
        }
    }
}

function checkSV($svnr) {
    if(strlen($svnr) != 10 || $svnr[0] == "0"){
        return false;
    }
    $sv_weights = [3, 7, 9, 0, 5, 8, 4, 2, 1, 6];
    $weighted_sum = 0;
    $ctr = 0;
    foreach (str_split($svnr) as $digit) {
        if(!is_numeric($digit)){
            return false;
        }
        $weighted_sum += $digit * $sv_weights[$ctr];
        $ctr++;
    }
    $param = $weighted_sum % 11;
    return ($param !== 0) && (strval($param) == $svnr[3]);
}
?>
