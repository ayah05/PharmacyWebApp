<?php include ("validation.php"); if (session_status() === PHP_SESSION_NONE) session_start();?>
<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset ="UTF -8">
    <meta name =" viewport " content =" width = device-width , initial - scale =1.0 ">
    <title> My PHP Web Application </title >
    <link rel="stylesheet" href="websiteStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        function checkSVNR(input){
            const weights = [3, 7, 9, 0, 5, 8, 4, 2, 1, 6];
            const str = input.value.toString();
            if(10 !== str.length || str[0] === "0"){
                input.setCustomValidity("Has to be exactly 10 digits long!");
                return;
            }
            const digits = str.split("").map(Number);
            const param = digits.map((a, i) => a * weights[i])/* weighted digits */
                .reduce((a, b) => a + b) /* sum */ % 11;
            if (0 === param || param !== digits[3]) {
                input.setCustomValidity("Please check checksum-digit!");
                return;
            }
            input.setCustomValidity(""); // valid!
        }
        function yay() {
            alert('Success! File can be found under\n"./output/total.txt"');
            window.location.replace("index.php");
        }
    </script>
</head>
<body>
<h1> Patient Administration </h1>


<!-- UPLOAD -->
<form method="post"  action="cda-parser.php" enctype="multipart/form-data">
    <label class="form-label" for ="medikationsliste">You can upload an ELGA-eMedication summary in CDA-format:<br>
        <input type="file" id="medikationsliste" name="medikationsliste" accept="application/xml, text/xml" required>
        <button type="submit" id="submit" name="submit">Upload</button>
    </label>
</form> <br>
<p>Or, you can fill in the information manually:</p>
<form method="POST" action="">
    <!-- SVNR -->
    <label for="patientID" class="required">Patient ID (SV_NR): </label>
    <input type="number" name="patientID" id="patientID" required oninput="checkSVNR(this)" <?php if (isset($_SESSION["svnr"])) {echo "value='{$_SESSION["svnr"]}'"; unset($_SESSION["svnr"]);}?>>
    <span class="errorMsg"> <?php if (isset($patientID_ERROR)) {echo $patientID_ERROR;}?></span>
    <span class="successMsg"> <?php if (isset($patientID_SUCCESS)) {echo $patientID_SUCCESS;}?></span><br><br>

    <!-- FIRST NAME -->
    <label for="firstname" class="required">First Name: </label>
    <input type="text" name="firstname" id="firstname" required <?php if (isset($_SESSION["firstname"])) {echo "value='{$_SESSION["firstname"]}'"; unset($_SESSION["firstname"]);}?>>
    <span class="errorMsg"> <?php if (isset($firstname_ERROR)) {echo $firstname_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($firstname_SUCCESS)) {echo $firstname_SUCCESS;}?></span><br><br>

    <label for="second"> Second Name: </label>
    <input type="text" name="secondName" id="second">
    <span class="successMsg"> <?php if (isset($secondName_SUCCESS)) {echo $secondName_SUCCESS;}?></span><br><br>

    <!-- LAST NAME -->
    <label for="familyName" class="required">Family Name: </label>
    <input type="text" name="familyName" id="familyName" <?php if (isset($_SESSION["lastname"])) {echo "value='{$_SESSION["lastname"]}'"; unset($_SESSION["lastname"]);}?>>
    <span class="errorMsg"> <?php if (isset($familyName_ERROR)) {echo $familyName_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($familyName_SUCCESS)) {echo $familyName_SUCCESS;}?></span><br><br>

    <!-- DOB -->
    <label for="birthdate" class="required">Birthday:  </label>
    <input type="date" name="birthdate" id="birthdate" required max=<?php echo '"'.(new DateTime("now")) -> format('Y-m-d').'" '?> <?php if (isset($_SESSION["dob"])) {echo "value='{$_SESSION["dob"]}'"; unset($_SESSION["dob"]);}?>>
    <span class="errorMsg"> <?php if (isset($birthdate_ERROR)) {echo $birthdate_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($birthdate_SUCCESS)) {echo $birthdate_SUCCESS;}?></span><br><br>

    <!-- GENDER -->
    <label class="required">Gender:
        <input type="radio" name="gender" value="female"  <?php if (isset($_SESSION["gender"]) && $_SESSION["gender"]==="F") {echo "checked"; unset($_SESSION["gender"]);}?>>Female
        <input type="radio" name="gender" value="male"  <?php if (isset($_SESSION["gender"]) && $_SESSION["gender"]==="M") {echo "checked"; unset($_SESSION["gender"]);}?>>Male
        <input type="radio" name="gender" value="other"  <?php if (isset($_SESSION["gender"]) && $_SESSION["gender"]==="UN") {echo "checked"; unset($_SESSION["gender"]);}?>>Other<br><br>
    </label>
    <span class="errorMsg"> <?php if (isset($gender_ERROR)) {echo $gender_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($gender_SUCCESS)) {echo $gender_SUCCESS;}?></span>

    <!-- FAMILIENSTAND -->
    <label class="required">Marital Status:
        <input type="radio" name="maritalStatus" value="single" id="maritalStatus" <?php if (isset($_SESSION["marriage"]) && $_SESSION["marriage"]==="S") {echo "checked"; unset($_SESSION["marriage"]);}?>>Single
        <input type="radio" name="maritalStatus" value="married" <?php if (isset($_SESSION["marriage"]) && $_SESSION["marriage"]==="M") {echo "checked"; unset($_SESSION["marriage"]);}?>>Married
        <input type="radio" name="maritalStatus" value="divorced" <?php if (isset($_SESSION["marriage"]) && $_SESSION["marriage"]==="D") {echo "checked"; unset($_SESSION["marriage"]);}?>>Divorced
        <input type="radio" name="maritalStatus" value="domesticPartner" <?php if (isset($_SESSION["marriage"]) && $_SESSION["marriage"]==="T") {echo "checked"; unset($_SESSION["marriage"]);}?>>Domestic Partner
        <input type="radio" name="maritalStatus" value="widowed" <?php if (isset($_SESSION["marriage"]) && $_SESSION["marriage"]==="W") {echo "checked"; unset($_SESSION["marriage"]);}?>>Widowed<br><br>
    </label>
    <span class="errorMsg"> <?php if (isset($maritalStatus_ERROR)) {echo $maritalStatus_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($maritalStatus_SUCCESS)) {echo $maritalStatus_SUCCESS;}?></span>

    <!-- STREET ADDRESS -->
    <label for="address" class="required">Address:  </label>
    <input type="text" required name="address" id="address" <?php if (isset($_SESSION["addrline"])) {echo "value='{$_SESSION["addrline"]}'"; unset($_SESSION["addrline"]);}?>>
    <span class="errorMsg"> <?php if (isset($address_ERROR)) {echo $address_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($address_SUCCESS)) {echo $address_SUCCESS;}?></span><br><br>

    <!-- ZIP-CODE -->
    <label for="postalCode" class="required">Postal Code: </label>
    <input type="number" required name="postalCode" id="postalCode" max="9999" min="1000" <?php if (isset($_SESSION["plz"])) {echo "value='{$_SESSION["plz"]}'"; unset($_SESSION["plz"]);}?>>
    <span class="errorMsg"> <?php if (isset($postalCode_ERROR)) {echo $postalCode_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($postalCode_SUCCESS)) {echo $postalCode_SUCCESS;}?></span><br><br>

    <!-- CITY -->
    <label for="city" class="required">City: </label>
    <input type="text" name="city" id="city" required <?php if (isset($_SESSION["city"])) {echo "value='{$_SESSION["city"]}'"; unset($_SESSION["city"]);}?>>
    <span class="errorMsg"> <?php if (isset($city_ERROR)) {echo $city_ERROR; }?></span>
    <span class="successMsg"> <?php if (isset($city_SUCCESS)) {echo $city_SUCCESS;}?></span><br><br>

    <!-- PHONE -->
    <label for="phoneNumber" class="required">Phone: + </label>
    <input type="number" name="phoneNumber" id="phoneNumber" min="100" max="99999999999999999999" required <?php if (isset($_SESSION["tel"])) {$t = preg_replace("/[-+.\\s]+/","", $_SESSION["tel"]);echo "value='{$t}'"; unset($_SESSION["tel"]);}?>>
    <span class="errorMsg"> <?php if (isset($phoneNumber_ERROR)) {echo $phoneNumber_ERROR;} ?></span>
    <span class="successMsg"> <?php if (isset($phoneNumber_SUCCESS)) {echo $phoneNumber_SUCCESS;}?></span><br><br>

    <!-- EMAIL -->
    <label for="email" class="required">E-Mail: </label>
    <input type="email" name="email" id="email" required <?php if (isset($_SESSION["mail"])) {echo "value='{$_SESSION["mail"]}'"; unset($_SESSION["mail"]);}?>>
    <span class="errorMsg"> <?php if (isset($email_ERROR)) {echo $email_ERROR; }?></span>
    <span class="successMsg"> <?php if (isset($email_SUCCESS)) {echo $email_SUCCESS;}?></span><br><br>

    <!-- DRUGS -->
    <label>Drug 1:
        <input type="text" placeholder="name" <?php if (isset($_SESSION["drug1"])) {echo "value='{$_SESSION["drug1"]}'"; unset($_SESSION["drug1"]);}?>><br>
        <label> Dosage:
            <input type="number" min="0" max="9" name="morning_1" value="<?php if (isset($_SESSION["dosage1"])) {echo $_SESSION["dosage1"][0];} else {echo "0";}?>">
            -<input type="number" name="noon_1" min="0" max="9" value="<?php if (isset($_SESSION["dosage1"])) {echo $_SESSION["dosage1"][1];} else {echo "0";}?>">
            -<input type="number" min="0" max="9" name="evening_1" value="<?php if (isset($_SESSION["dosage1"])) {echo $_SESSION["dosage1"][2];} else {echo "0";}?>">
            -<input type="number" min="0" max="9" name="night_1" value="<?php if (isset($_SESSION["dosage1"])) {echo $_SESSION["dosage1"][3];} else {echo "0";}?>"> <br>
            <?php if (isset($_SESSION["dosage1"])) unset($_SESSION["dosage1"]);?>
        </label>
    </label><br>
    <label> Drug 2:
        <input type="text" placeholder="name" <?php if (isset($_SESSION["drug2"])) {echo "value='{$_SESSION["drug2"]}'"; unset($_SESSION["drug2"]);}?>><br>
        <label> Dosage:
            <input type="number" min="0" max="9"  name="morning_2" value="<?php if (isset($_SESSION["dosage2"])) {echo $_SESSION["dosage2"][0];} else {echo "0";}?>">
            -<input type="number" name="noon_2" min="0" max="9" value="<?php if (isset($_SESSION["dosage2"])) {echo $_SESSION["dosage2"][1];} else {echo "0";}?>">
            -<input type="number" min="0" max="9" name="evening_2" value="<?php if (isset($_SESSION["dosage2"])) {echo $_SESSION["dosage2"][2];} else {echo "0";}?>">
            -<input type="number" min="0" max="9" name="night_2" value="<?php if (isset($_SESSION["dosage2"])) {echo $_SESSION["dosage2"][3];} else {echo "0";}?>"> <br>
            <?php if (isset($_SESSION["dosage2"])) unset($_SESSION["dosage2"]);?>
        </label>
    </label> <br>
    <label> Drug 3:
        <input type="text" placeholder="name" <?php if (isset($_SESSION["drug3"])) {echo "value='{$_SESSION["drug3"]}'"; unset($_SESSION["drug3"]);}?>><br>
        <label> Dosage:
            <input type="number" min="0" max="9" name="morning_3" value="<?php if (isset($_SESSION["dosage3"])) {echo $_SESSION["dosage3"][0];} else {echo "0";}?>">
            -<input type="number" name="noon_3" min="0" max="9" value="<?php if (isset($_SESSION["dosage3"])) {echo $_SESSION["dosage3"][1];} else {echo "0";}?>">
            -<input type="number" min="0" max="9" name="evening_3" value="<?php if (isset($_SESSION["dosage3"])) {echo $_SESSION["dosage3"][2];} else {echo "0";}?>">
            -<input type="number" min="0" max="9" name="night_3" value="<?php if (isset($_SESSION["dosage3"])) {echo $_SESSION["dosage3"][3];} else {echo "0";}?>"> <br>
            <?php if (isset($_SESSION["dosage3"])) unset($_SESSION["dosage3"]);?>
        </label>
    </label> <br>

    <button type="submit" class="submit" name="sendDataButton"> Send Data</button><br>
    <div id="info" hidden>
        <?php if(isset($patientID_SUCCESS) && isset($firstname_SUCCESS) && isset($familyName_SUCCESS) && isset($birthdate_SUCCESS) && isset($maritalStatus_SUCCESS) && isset($address_SUCCESS) && isset($postalCode_SUCCESS) && isset($city_SUCCESS) && isset($phoneNumber_SUCCESS) && isset($email_SUCCESS))
            echo "<script>yay()</script>";
        ?>
    </div>

</form>
</body>
</html>
