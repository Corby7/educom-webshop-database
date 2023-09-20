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
        <p><span class="error"><strong>* Vereist veld</strong></span></p>
        <ul class="flex-outer">

            <li>
                <label for="email">E-mailadres:</label>
                <input type="email" id="email" name="email" value="' . $email . '">
                <span class="error">* ' . $emailErr . $emailunknownErr . '</span>
            </li>

            <li>
                <label for="pass">Wachtwoord:</label>
                <input type="password" id="pass" name="pass" value="' . $pass . '">
                <span class="error">* ' . $passErr . $wrongpassErr . '</span>
            </li>

            <li>
            <button type="submit" name="page" value="login">Verstuur</button>
            </li>

        </ul>
    </form>';
}

?>