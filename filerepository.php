<?php

define("USER_DATA_PATH", 'users/users.txt');

/**
 * Find a user by email in the user data file.
 *
 * This function searches for a user with the specified email address in the user data file.
 * If a matching user is found, it returns an associative array containing the user's email, name, and password.
 * If no matching user is found, it returns null.
 *
 * @param string $email The email address of the user to search for.
 * @return array|null An associative array containing user data if found, or null if not found.
 */
function findUserByEmail($email) {
    $usersfile = fopen(USER_DATA_PATH, 'r') or die("Unable to open file!");
    $user = null;

    while (!feof($usersfile)) {
        $line = fgets($usersfile);
        $values = explode('|', $line);

        if (count($values) === 3) {
            if ($values[0] == $email) {
                $user = array(
                'email' => trim($values[0]),
                'name' => trim($values[1]),
                'pass' => trim($values[2])
                );
                break;
            }
        }
    }

    //close the file
    fclose($usersfile);
    return $user;
}

/**
 * Save user data to the user data file.
 *
 * This function appends user data (email, name, and password) to the user data file.
 * It opens the file, appends the new data on a new line, and then closes the file.
 *
 * @param string $email The email address of the user.
 * @param string $name The name of the user.
 * @param string $pass The password of the user.
 */
function saveUser($email, $name, $pass) {
    // Specify the path to the .txt file
    $userdatafile_path = 'users/users.txt';

    //open userdata file, append new userdata in newline and close file
    $usersfile = fopen($userdatafile_path, 'a') or die("Unable to open file!");
    $newUserDatatxt = $email . '|' . $name . '|' . $pass . "\n";
    fwrite($usersfile, $newUserDatatxt);
    fclose($usersfile);
}

?>