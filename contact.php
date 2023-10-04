<?php

/** Display the title for the contact page. */
function showContactTitle() {
    echo 'ProtoWebsite';
}

/** Display the header for the contact page. */
function showContactHeader() {
    echo 'Contacteer Mij';
}

/** Display the thankyou for filling in the contact form. 
 *  
 * @param array $data An array containing input data for the response page.
*/
function showContactThanks($data) {
    // Extract values from the $data array
    extract($data);

    echo '
    <h2>Beste ' . getSalutation($gender) . ' ' . $fname . ' ' . $lname . ', bedankt voor het invullen van uw gegevens!</h2>
    <h3>Ik zal zo snel mogelijk contact met u opnemen. Ter bevestiging uw informatie:</h3>
    <ul class="submitted_userdata">
        <li><strong>E-mailadres: </strong>' . $email . '</li>
        <li><strong>Telefoonnummer: </strong>' . $phone . '</li>
        <li><strong>Communicatievoorkeur: </strong>' . $preference . '</li>
        <li><strong>Bericht: </strong>' . $message . '</li>
    </ul>';
}

/** Display the form for the contact page. 
 *  
 * @param array $data An array containing input data for the response page.
*/
function showContactForm($data) {
    // Extract values from the $data array
    extract($data);

    echo '
    <form method="post" action="index.php">
        <div class="alert alert-danger d-inline-block text-danger py-1" role="alert">* Vereist veld</div>
        <div class="mb-3 form-outline w-50">
            <label for="gender" class="form-label fs-5">Aanhef<span class="text-danger d-inline-block">*</span></label>
            <select class="form-select" name="gender" id="gender">
                <option disabled selected value> -- maak een keuze -- </option>
                <option value="male" ' . ($gender == "male" ? "selected" : "") . '>Dhr.</option>
                <option value="female" ' . ($gender == "female" ? "selected" : "") . '>Mvr.</option>
                <option value="unspecified" ' . ($gender == "unspecified" ? "selected" : "") . '>Anders</option>
            </select>
            <div class="text-danger">' . $genderErr . '</div>
        </div>

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
            <span class="text-danger">' . $emailErr . '</span>
        </div>
        
        <div class="form-floating mb-3 form-outline w-50">
            <input type="tel" class="form-control" placeholder="phone" id="phone" name="phone" value="' . $phone . '">
            <label for="phone" class="form-label"><span class="text-secondary">Telefoonnummer</span><span class="text-danger d-inline-block">*</span></label>
            <span class="text-danger">' . $phoneErr . '</span>
        </div>
        
        <fieldset class="mb-3 form-outline w-50">
            <legend class="form-label fs-5">Communicatievoorkeur<span class="text-danger d-inline-block">*</span></legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="emailradio" name="preference" value="email" ' . ($preference == "email" ? "checked" : "") . '>
                <label class="form-check-label" for="emailradio">Email</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="phonePreference" name="preference" value="phone" ' . ($preference == "phone" ? "checked" : "") . '>
                <label class="form-check-label" for="phonePreference">Telefoon</label>
            </div>
            <span class="text-danger">' . $preferenceErr . '</span>
        </fieldset>
        
        <div class="mb-3 form-outline w-50">
            <label for="bericht" class="form-label fs-5">Bericht<span class="text-danger d-inline-block">*</span></label>
            <textarea class="form-control" id="message" name="message" rows="5">' . $message . '</textarea>
            <span class="text-danger">' . $messageErr . '</span>
        </div>
        
        <button type="submit" class="btn btn-primary" id="button-invert" name="page" value="contact">Verstuur</button>
        
        </div>
    </form>';
}

?>