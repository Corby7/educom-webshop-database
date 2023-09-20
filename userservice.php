<?php

/**
 * Get the appropriate salutation based on gender.
 *
 * @param string $gender The gender of the person ('male' or 'female').
 * @return string|null The salutation ('meneer' or 'mevrouw') or null if gender is not recognized.
 */
function getSalutation($gender) {
    switch ($gender) {
        case 'male':
            return 'meneer';
        case 'female':
            return 'mevrouw';
        default:
            return;
    }
}

/** Authentication result indicating success. */
define("RESULT_OK", 0);
/** Authentication result indicating an unknown user. */
define("RESULT_UNKNOWN_USER", -1);
/** Authentication result indicating a wrong password. */
define("RESULT_WRONG_PASSWORD", -2);

/**
 * Authenticate a user based on email and password.
 *
 * @param string $email The user's email address.
 * @param string $pass The user's password.
 * @return array An array containing the authentication result and user information if successful.
 */
function authenticateUser($email, $pass) {
    $user = findUserByEmail($email);
    
    if(empty($user)) {
        return ['result' => RESULT_UNKNOWN_USER];
    }

    if ($user['pass'] !== $pass) {
        return ['result' => RESULT_WRONG_PASSWORD];
    }

    return ['result' => RESULT_OK, 'user' => $user];
}

/**
 * Check if an email exists in the user database.
 *
 * @param string $email The email address to check.
 * @return bool True if the email exists, false otherwise.
 */
function doesEmailExist($email) {
    $user = findUserByEmail($email);
    return !empty($user);
}

/**
 * Store a new user in the database.
 *
 * @param string $email The user's email address.
 * @param string $name The user's name.
 * @param string $pass The user's password.
 */
function storeUser($email, $name, $pass) {
    //room for future password encryption
    saveUser($email, $name, $pass);
}
?>