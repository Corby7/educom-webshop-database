<?php

/**
 * Log in a user by setting their username in the session.
 *
 * @param string $username The username of the user to log in.
 */
function loginUser($username) {
    $_SESSION['username'] = $username;
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

/**
 * Log out the currently logged-in user by clearing session data.
 */
function logoutUser() {
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy(); 
}

?>