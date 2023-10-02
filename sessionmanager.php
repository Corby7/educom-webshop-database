<?php

/**
 * Log in a user by setting their username in the session.
 *
 * @param string $username The username of the user to log in.
 */
function loginUser($username, $useremail) {
    $_SESSION['username'] = $username;
    $_SESSION['useremail'] = $useremail;
    $_SESSION['shoppingcart'] = array();
}

/**
 * Check if a user is logged in.
 *
 * @return bool True if a user is logged in, false otherwise.
 */
function isUserLoggedIn() {
    return isset($_SESSION['username']) && !empty($_SESSION['username']);
}

/**
 * Get the username of the currently logged-in user.
 *
 * @return string The username of the logged-in user, or an empty string if not logged in.
 */
function getLoggedInUserName() {
    return isset($_SESSION['username']) ? $_SESSION['username'] : '';
}

function getLoggedInUserEmail() {
    return isset($_SESSION['useremail']) ? $_SESSION['useremail'] : '';
}

/**
 * Log out the currently logged-in user by clearing session data.
 */
function logoutUser() {
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy(); 
}

function getCart() {
    if (isset($_SESSION['shoppingcart'])) {
        return $_SESSION['shoppingcart'];
    } else {
        return array();
    }
}

function addToCart($productId) {
    if (array_key_exists($productId, $_SESSION['shoppingcart'])) {
        $_SESSION['shoppingcart'][$productId] += 1;
    } else {
        $_SESSION['shoppingcart'][$productId] = 1;
    }
}

function removeFromCart($productId) {
    if (array_key_exists($productId, $_SESSION['shoppingcart'])) {
        if ($_SESSION['shoppingcart'][$productId] === 1) {
            unset($_SESSION['shoppingcart'][$productId]);
        } else {
        $_SESSION['shoppingcart'][$productId] -= 1;
        }
    }
}

?>