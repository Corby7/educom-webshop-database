<?php

/** Display the title for the register page. */
function showRegisterTitle() {
    echo 'Register';
}

/** Display the header for the register page. */
function showRegisterHeader() {
    echo 'Registreer Nu!';
}

/** Display the form for the register page. 
 *  
 * @param array $data An array containing input data for the response page.
*/
function showRegisterForm($data) {
    // Extract values from the $userdata array
    extract($data);

    echo '
    <form method="post" action="index.php">
        <div class="alert alert-danger d-inline-block text-danger py-1" role="alert">* Vereist veld</div>

        <div class="form-floating mb-3 form-outline w-50">
            <input type="text" class="form-control" placeholder="firstname" id="fname" name="fname" value="' . $fname . '">
            <label for="fname" class="form-label"><span class="text-secondary">Voornaam</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $fnameErr . '</span>
        </div>

        <div class="form-floating mb-3 form-outline w-50">
            <input type="text" class="form-control" placeholder="lastname" id="lname" name="lname" value="' .$lname . '">
            <label for="lname" class="form-label"><span class="text-secondary">Achternaam</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $lnameErr . '</span>
        </div>

        <div class="form-floating mb-3 form-outline w-50">
            <input type="email" class="form-control" placeholder="email" id="email" name="email" value="' . $email . '">
            <label for="email" class="form-label"><span class="text-secondary">E-mailadres</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $emailErr . $emailknownErr . '</span>
        </div>

        <div class="form-floating mb-3 form-outline w-50">
            <input type="password" class="form-control" placeholder="wachtwoord" id="pass" name="pass" value="' . $pass . '">
            <label for="pass" class="form-label"><span class="text-secondary">Wachtwoord</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $passErr . '</span>
        </div>

        <div class="form-floating mb-3 form-outline w-50">
            <input type="password" class="form-control" placeholder="herhaal wachtwoord" id="repeatpass" name="repeatpass" value="' . $repeatpass . '">
            <label for="repeatpass" class="form-label"><span class="text-secondary">Herhaal wachtwoord</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $repeatpassErr . $passcheckErr . '</span>
        </div>

        <button type="submit" class="btn btn-primary" id="button-invert" name="page" value="register">Registreren</button>

    </form>';
}

?>
