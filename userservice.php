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
    saveUser($email, $name, $pass);
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
        $cartLines = array();
        $total = 0; 

        $cart = getCart();
        if (empty($cart)) {
            return compact('cartLines', 'total');  
        }
        $productids = array_keys($cart);
        $cartProducts = getProductsByIds($productids);
        foreach($cart as $productid => $quantity) {
           $product = $cartProducts[$productid];  
           extract($product);                       
           $subtotal = $price * $quantity; 
           $total += $subtotal;
           $cartLines[] = compact('id', 'filenameimage', 'name', 'price', 'quantity', 'subtotal');
        } 
        return compact('cartLines', 'total');  
    } catch (Exception $e) {
        logError("Getting cart products failed: " . $e->getMessage()); 
        return array('genericErr' => 'door een technische storing kunnen wij uw winkelwagen niet laten zien');
    }
}

function makeOrder() {
    try {
        $cart = $_SESSION['shoppingcart'];
        $email = $_SESSION['useremail'];
        $useridArray = getUserId($email);
        $useridString = reset($useridArray);
        createOrder($useridString, $cart);
        return true;
    } catch (Exception $e) {
        logError("Checkout failed: " . $e->getMessage());
        return false;
    }
}

?>