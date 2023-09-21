<?php

/** Display the title for the settings page. */
function showSettingsTitle() {
    echo 'settings';
}

/** Display the header for the settings page. */
function showSettingsHeader() {
    echo 'Wachtwoord wijzigen';
}

/** Display the form for the settings page. 
 *  
 * @param array $data An array containing input data for the response page.
*/
function showSettingsForm($data) {
    extract($data);

    echo '
    <form method="post" action="index.php">
        <p><span class="error"><strong>* Vereist veld</strong></span></p>
        <ul class="flex-outer">

            <li>
                <label for="pass">Oud wachtwoord:</label>
                <input type="password" id="pass" name="pass" value="' . $pass . '">
                <span class="error">* ' . $passErr . $wrongpassErr . '</span>
            </li>

            <li>
                <label for="pass">Nieuw wachtwoord:</label>
                <input type="password" id="newpass" name="newpass" value="' . $newpass . '">
                <span class="error">* ' . $newpassErr . $oldvsnewpassErr . '</span>
            </li>

            <li>
                <label for="repeatpass">Herhaal nieuw wachtwoord:</label>
                <input type="password" id="repeatpass" name="repeatpass" value="' . $repeatpass . '">
                <span class="error">* ' . $repeatpassErr . $passcheckErr . '</span>
            </li>

            <li>
                <span class="success">' . $passwordUpdated . '</span>
            </li>

            <li>
                <button type="submit" name="page" value="settings">Verstuur</button>
            </li>

        </ul>
    </form>';
}

?>
