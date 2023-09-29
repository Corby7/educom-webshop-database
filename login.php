<?php

/** Display the title for the login page. */
function showLoginTitle() {
    echo 'Login';
}

/** Display the header for the login page. */
function showLoginHeader() {
    echo 'Login';
}

/** Display the form for the login page. 
 *  
 * @param array $data An array containing input data for the response page.
*/
function showLoginForm($data) {
    extract($data);

    echo '
    <form method="post" action="index.php">
        <div class="alert alert-danger d-inline-block text-danger py-1" role="alert">* Vereist veld</div>

        <div class="form-floating mb-3 form-outline w-50">
            <input type="email" class="form-control" placeholder="email" id="email" name="email" value="' . $email . '">
            <label for="email" class="form-label"><span class="text-secondary">E-mailadres</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $emailErr . $emailunknownErr . '</span>
        </div>

        <div class="form-floating mb-3 form-outline w-50">
            <input type="password" class="form-control" placeholder="wachtwoord" id="pass" name="pass" value="' . $pass . '">
            <label for="pass"class="form-label"><span class="text-secondary">Wachtwoord</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $passErr . $wrongpassErr . '</span>
        </div>

        <button type="submit" class="btn btn-primary" name="page" value="login">Inloggen</button>



    </form>';
}

?>