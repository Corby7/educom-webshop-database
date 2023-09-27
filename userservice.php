<?php
require('mysqlconnect.php');

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
    try {
        $user = findUserByEmail($email);
        
        if(empty($user)) {
            return ['result' => RESULT_UNKNOWN_USER];
        }

        if ($user['pass'] !== $pass) {
            return ['result' => RESULT_WRONG_PASSWORD];
        }

        return ['result' => RESULT_OK, 'user' => $user];
    } catch (Exception $e) {
        logError("Authenticating user failed: " . $e->getMessage()); 
    }
}

/**
 * Check if an email exists in the user database.
 *
 * @param string $email The email address to check.
 * @return bool True if the email exists, false otherwise.
 */
function doesEmailExist($email) {
    try {
        $user = findUserByEmail($email);
        return !empty($user);
    } catch (Exception $e) {
        logError("Finding if user email exists failed: " . $e->getMessage()); 
    }
}

/**
 * Store a new user in the database.
 *
 * @param string $email The user's email address.
 * @param string $name The user's name.
 * @param string $pass The user's password.
 */
function storeUser($email, $name, $pass) {
    try {
        //room for future password encryption
        saveUser($email, $name, $pass);
    } catch (Exception $e) {
        logError("Saving user failed: " . $e->getMessage()); 
    }
}

function updatePasswordByEmail($email, $newpass, $data) {
    try {
        if (overwritePassword($email, $newpass)) {
            $data['passwordUpdated'] = "Wachtwoord succesvol gewijzigd.";
        }
        return $data;
    } catch (Exception $e) {
        logError("Overwriting password failed: " . $e->getMessage());
    }
}

function populateCart() {
    try {
        $productids = array_keys($_SESSION['shoppingcart']);
        return $cartProducts = getCartProducts($productids);
    } catch (Exception $e) {
        logError("Getting cart products failed: " . $e->getMessage()); 
    }
}

function makeOrder() {
    try {
        $cart = $_SESSION['shoppingcart'];
        $email = $_SESSION['useremail'];
        $orderid = createOrder($email);
        createOrderLineSQL($orderid, $cart);
        return true;
    } catch (Exception $e) {
        logError("Checkout failed: " . $e->getMessage());
        return false;
    }
}

function createOrder($email) {
    $useridArray = getUserId($email);
    $useridString = reset($useridArray); 
    $date = date('Y-m-d H:i:s');
    return createOrderSQL($useridString, $date);
}


?>