<?php

/**
 * Initialize form data based on the specified form type.
 *
 * @param string $formType The type of the form ('contact', 'register', or 'login').
 * @return array An array containing initialized form data.
 */
function initializeFormData($formType) {
    $data = array();

    switch ($formType) {
        case 'contact':
            $data = array(
                'gender' => '',
                'fname' => '',
                'lname' => '',
                'email' => '',
                'phone' => '',
                'preference' => '',
                'message' => '',
                'genderErr' => '',
                'fnameErr' => '',
                'lnameErr' => '',
                'emailErr' => '',
                'phoneErr' => '',
                'preferenceErr' => '',
                'messageErr' => '',
                'valid' => ''
            );
            break;
        
        case 'register':
            $data = array(
                'name' => '',
                'fname' => '',
                'lname' => '',
                'email' => '',
                'pass' => '',
                'repeatpass' => '',
                'fnameErr' => '',
                'lnameErr' => '',
                'emailErr' => '',
                'passErr' => '',
                'repeatpassErr' => '',
                'passcheckErr' => '',
                'emailknownErr' => '',
                'valid' => ''
            );
            break;
        
        case 'login':
            $data = array(
                'email' => '',
                'emailErr' => '',
                'emailunknownErr' => '',
                'pass' => '',
                'passErr' => '',
                'wrongpassErr' => '',
                'valid' => ''
            );
            break;
        
        default:
            // Handle unknown form types or set default values
            break;
    }

    return $data;
}

/**
 * Validate the contact form data and return validation results.
 *
 *  * This function is responsible for validating form data based on the specified form type,
 * which can be 'contact', 'register', or 'login'. It performs data validation and sanitization,
 * checks for errors, and returns an array containing the validated form data and any error messages.
 *
 * @param array $data An array containing form input data.
 * @return array An array containing validated form data and error messages.
 */
function validateContactForm($data) {
    extract($data);

    //retrieve and sanitize the fields from $_POST
    $gender = testInput(getPostVar("gender"));
    if (empty($gender)) {
        $genderErr = "Aanhef is vereist";
    }
    
    $fname = testInput(getPostVar("fname"));
    if (empty($fname)) {
        $fnameErr = "Voornaam is vereist";
    }
    
    $lname = testInput(getPostVar("lname"));
    if (empty($lname)) {
        $lnameErr = "Achternaam is vereist";
    }
    
    $email = testInput(getPostVar("email"));
    if (empty($email)) {
        $emailErr = "Email is vereist";
    }
    
    $phone = testInput(getPostVar("phone"));
    if (empty($phone)) {
        $phoneErr = "Telefoonnummer is vereist";
    }
    
    $preference = testInput(getPostVar("preference"));
    if (empty($preference)) {
        $preferenceErr = "Voorkeur is vereist";
    }
    
    $message = testInput(getPostVar("message"));
    if (empty($message)) {
        $messageErr = "Bericht is vereist";
    }
    

    //check if there are any errors and set $valid accordingly
    $valid = empty($genderErr) && empty($fnameErr) && empty($lnameErr) && empty($emailErr) && empty($phoneErr) && empty($preferenceErr) && empty($messageErr);

    return compact('gender', 'fname', 'lname', 'email', 'phone', 'preference', 'message', 'genderErr', 'fnameErr', 'lnameErr', 'emailErr', 'phoneErr', 'preferenceErr', 'messageErr', 'valid');
}

/**
 * Validate the registration form data and return validation results.
 *
 * @param array $data An array containing form input data.
 * @return array An array containing validated form data and error messages.
 */
function validateRegisterForm($data) {
    extract($data);

    //retrieve and sanitize the fields from $_POST
    $fname = testInput(getPostVar("fname"));
    if (empty($fname)) {
        $fnameErr = "Voornaam is vereist";
    }

    $lname = testInput(getPostVar("lname"));
    if (empty($lname)) {
        $lnameErr = "Achternaam is vereist";
    }

    $email = testInput(getPostVar("email"));
    if (empty($email)) {
        $emailErr = "Email is vereist";
    }

    if (!empty($email) && doesEmailExist($email)) {
        $emailknownErr = "E-mailadres is reeds bekend";
    }

    $pass = testInput(getPostVar("pass"));
    if (empty($pass)) {
        $passErr = "Wachtwoord is vereist";
    }

    $repeatpass = testInput(getPostVar("repeatpass"));
    if (empty($repeatpass)) {
        $repeatpassErr = "Wachtwoord herhalen is vereist";
    }

    if (empty($passErr) && empty($repeatpassErr)) {
        $passcheckErr = validatePassword($pass, $repeatpass);
    }

    //if no errors found, set username and set valid to true
    $valid = (empty($fnameErr) && empty($lnameErr) && empty($emailErr) && empty($passErr) && empty($repeatpassErr) && empty($passcheckErr) && empty($emailknownErr));
    
    if ($valid) {
        $name = $fname . ' ' . $lname;
    }

    return compact ('name', 'fname', 'lname', 'email', 'pass', 'repeatpass', 'fnameErr', 'lnameErr', 'emailErr', 'passErr', 'repeatpassErr', 'passcheckErr', 'emailknownErr', 'valid');
}

/**
 * Validate the login form data and return validation results.
 *
 * @param array $data An array containing form input data.
 * @return array An array containing validated form data and error messages.
 */
function validateLoginForm($data) {
    extract($data);

    //retrieve and sanitize the fields from $_POST
    $email = testInput(getPostVar("email"));
    if (empty($email)) {
        $emailErr = "Email is vereist";
    }

    $pass = testInput(getPostVar("pass"));
    if (empty($pass)) {
        $passErr = "Wachtwoord is vereist";
    }

    $valid = empty($emailErr) && empty($passErr);

    return compact ('email', 'pass', 'emailErr', 'passErr', 'emailunknownErr', 'wrongpassErr', 'valid');
}

/**
 * Sanitize and prepare input data.
 *
 * @param string $data The input data to sanitize.
 * @return string The sanitized input data.
 */
function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validate if two passwords match.
 *
 * @param string $pass The first password.
 * @param string $repeatpass The repeated password to compare.
 * @return string An error message if the passwords don't match; otherwise, an empty string.
 */
function validatePassword($pass, $repeatpass) {
    if ($pass !== $repeatpass) {
        return "Wachtwoorden komen niet overeen";
    }
    return '';
}

?>