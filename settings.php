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
        <div class="alert alert-danger d-inline-block text-danger py-1" role="alert">* Vereist veld</div>

        <div class="form-floating mb-3 form-outline w-50">
            <input type="password" class="form-control" placeholder="oud wachtwoord" id="pass" name="pass" value="' . $pass . '">
            <label for="pass" class="form-label"><span class="text-secondary">Oud wachtwoord</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $passErr . $wrongpassErr . '</span>
        </div>

        <div class="form-floating mb-3 form-outline w-50">
            <input type="password" class="form-control" placeholder="nieuw wachtwoord" id="newpass" name="newpass" value="' . $newpass . '">
            <label for="pass" class="form-label"><span class="text-secondary">Nieuw wachtwoord</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $newpassErr . $oldvsnewpassErr . '</span>
        </div>

        <div class="form-floating mb-3 form-outline w-50">
            <input type="password" class="form-control" placeholder="herhaal nieuw wachtwoord" id="repeatpass" name="repeatpass" value="' . $repeatpass . '">
            <label for="repeatpass" class="form-label"><span class="text-secondary">Herhaal nieuw wachtwoord</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $repeatpassErr . $passcheckErr . '</span>
        </div>

        <button type="submit" class="btn btn-primary" id="button-invert" name="page" value="settings">Wijzigen</button>

        <span class="text-success mx-2">' . $passwordUpdated . '</span>
    </form>';
}

?>
