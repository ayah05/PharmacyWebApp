<?php include ("validation.php")?>
<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset ="UTF -8">
    <meta name =" viewport " content =" width = device-width , initial - scale =1.0 ">
    <title> My PHP Web Application </title >
    <link rel="stylesheet" href="websiteStyle.css">
</head>
<body>
<style>
    .required:before{
        content:"*";
        color:red;
    }
</style>
<h1 align="center"> Patient Administration </h1>
<form method="POST" action="">
    <label for="patientID" class="required">Patient ID (SV_NR): </label>
    <input type="number" name="patientID" id="patientID">
    <span class="errorMsg"> <?php if (isset($patientID_ERROR)) {echo $patientID_ERROR;}?></span>
    <span class="successMsg"> <?php if (isset($patientID_SUCCESS)) {echo $patientID_SUCCESS;}?></span><br><br>

    <label for="firstname" class="required">Firstname: </label>
    <input type="text" name="firstname" id="firstname">
    <span class="errorMsg"> <?php if (isset($firstname_ERROR)) {echo $firstname_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($firstname_SUCCESS)) {echo $firstname_SUCCESS;}?></span><br><br>

    Second Name: <input type="text" name="secondName">
    <span class="successMsg"> <?php if (isset($secondName_SUCCESS)) {echo $secondName_SUCCESS;}?></span><br><br>
    <label for="familyName" class="required">Family Name: </label>
    <input type="text" name="familyName" id="familyName">
    <span class="errorMsg"> <?php if (isset($familyName_ERROR)) {echo $familyName_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($familyName_SUCCESS)) {echo $familyName_SUCCESS;}?></span><br><br>

    <label for="birthdate" class="required">Birthday:  </label>
    <input type="date" name="birthdate" id="birthdate">
    <span class="errorMsg"> <?php if (isset($birthdate_ERROR)) {echo $birthdate_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($birthdate_SUCCESS)) {echo $birthdate_SUCCESS;}?></span><br><br>

    <label for="gender" class="required">Gender: </label>
    <input type="radio" name="gender" value="female" id="gender">Female <input type="radio" name="gender" value="male">Male <input type="radio" name="gender" value="other">Other<br><br>
    <span class="errorMsg"> <?php if (isset($gender_ERROR)) {echo $gender_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($gender_SUCCESS)) {echo $gender_SUCCESS;}?></span><br><br>

    <label for="maritalStatus" class="required">Marital Status:  </label>
    <input type="radio" name="maritalStatus" value="single" id="maritalStatus">Single <input type="radio" name="maritalStatus" value="married">Married <input type="radio" name="maritalStatus" value="divorced">Divorced  <input type="radio" name="maritalStatus" value="domesticPartner">Domestic Partner<br><br>
    <span class="errorMsg"> <?php if (isset($maritalStatus_ERROR)) {echo $maritalStatus_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($maritalStatus_SUCCESS)) {echo $maritalStatus_SUCCESS;}?></span><br><br>

    <label for="address" class="required">Address:  </label>
    <input type="text" name="address" id="address">
    <span class="errorMsg"> <?php if (isset($address_ERROR)) {echo $address_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($address_SUCCESS)) {echo $address_SUCCESS;}?></span><br><br>

    <label for="postalCode" class="required">Postal Code: </label>
    <input type="number" name="postalCode" id="postalCode">
    <span class="errorMsg"> <?php if (isset($postalCode_ERROR)) {echo $postalCode_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($postalCode_SUCCESS)) {echo $postalCode_SUCCESS;}?></span><br><br>

    <label for="city" class="required">City: </label>
    <input type="text" name="city" id="city">
    <span class="errorMsg"> <?php if (isset($city_ERROR)) {echo $city_ERROR; }?></span>
    <span class="successMsg"> <?php if (isset($city_SUCCESS)) {echo $city_SUCCESS;}?></span><br><br>

    <label for="phoneNumber" class="required">Phone Number: + </label>
    <input type="number" name="phoneNumber" id="phoneNumber">
    <span class="errorMsg"> <?php if (isset($phoneNumber_ERROR)) {echo $phoneNumber_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($phoneNumber_SUCCESS)) {echo $phoneNumber_SUCCESS;}?></span><br><br>

    <label for="email" class="required">E-Mail: </label>
    <input type="email" name="email" id="email">
    <span class="errorMsg"> <?php if (isset($email_ERROR)) {echo $email_ERROR; }?></span>
    <span class="successMsg"> <?php if (isset($email_SUCCESS)) {echo $email_SUCCESS;}?></span><br><br>

    <label for="weekDays" class="required"> Week Days: </label> <br>
    <input type="checkbox" name="weekDays[]" value="Monday" id="weekDays"> Monday  <input type="number" min="1" max="1" name="morning_mo" value="morning"> - <input type="number" name="noon_mo" value="noon" min="1" max="1"  id="dose"> - <input type="number" min="1" max="1" name="evening_mo" value="evening"> - <input type="number" min="1" max="1" name="night_mo" value="night"> <br> <!--you need to change all inputs to numbers and change field size + disable them until box checked-->
    <input type="checkbox" name="weekDays[]" value="Tuesday" id="weekDays"> Tuesday  <input type="number" min="1" max="1" name="morning_tue" value="morning" > - <input type="number" name="noon_tue" value="noon" min="1" max="1"  id="dose"> - <input type="number" min="1" max="1" name="evening_tue" value="evening"> - <input type="number" min="1" max="1" name="night_tue" value="night"> <br>
    <input type="checkbox" name="weekDays[]" value="Wednesday" id="weekDays"> Wednesday   <input type="number" min="1" max="1" name="morning_tue" value="morning" > - <input type="number" name="noon_tue" value="noon" min="1" max="1"  id="dose"> - <input type="number" min="1" max="1" name="evening_tue" value="evening"> - <input type="number" min="1" max="1" name="night_tue" value="night"> <br>
    <input type="checkbox" name="weekDays[]" value="Thursday" id="weekDays"> Thursday  <input type="number" min="1" max="1" name="morning_tue" value="morning" > - <input type="number" name="noon_tue" value="noon" min="1" max="1"  id="dose"> - <input type="number" min="1" max="1" name="evening_tue" value="evening"> - <input type="number" min="1" max="1" name="night_tue" value="night"> <br>
    <input type="checkbox" name="weekDays[]" value="Friday" id="weekDays"> Friday   <input type="number" min="1" max="1" name="morning_tue" value="morning" > - <input type="number" name="noon_tue" value="noon" min="1" max="1"  id="dose"> - <input type="number" min="1" max="1" name="evening_tue" value="evening"> - <input type="number" min="1" max="1" name="night_tue" value="night"> <br>
    <input type="checkbox" name="weekDays[]" value="Saturday" id="weekDays"> Saturday  <input type="number" min="1" max="1" name="morning_tue" value="morning" > - <input type="number" name="noon_tue" value="noon" min="1" max="1"  id="dose"> - <input type="number" min="1" max="1" name="evening_tue" value="evening"> - <input type="number" min="1" max="1" name="night_tue" value="night"> <br>
    <input type="checkbox" name="weekDays[]" value="Sunday" id="weekDays"> Sunday   <input type="number" min="1" max="1" name="morning_tue" value="morning" > - <input type="number" name="noon_tue" value="noon" min="1" max="1"  id="dose"> - <input type="number" min="1" max="1" name="evening_tue" value="evening"> - <input type="number" min="1" max="1" name="night_tue" value="night"> <br>
    <span class="successMsg"> <?php if (isset($weekdays_SUCCESS)) {echo $weekdays_SUCCESS;}?></span>
    <span class="errorMsg"> <?php if (isset($weekdays_ERROR)) {echo $weekdays_ERROR; }?></span><br><br>


    <p></p>


    <button type="submit" class="submit" name="sendDataButton" align="center"> Send Data</button><br>
    <p></p>

    <span style="font-size:25px;color:darkgreen"> <?php if (isset($impt)) {echo "The generated patient's ID in the FHIR resource is: ";echo $impt;}?></span>

</form>
</body>
</html>
