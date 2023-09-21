<?php

function connectDatabase() {
$servername = "localhost";
$username = "WebShopUser";
$password = "1234";
$dbname = "corbijns_webshop";

    try {
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            throw new Exception("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
        echo "Connected successfully";
    } catch (Exception $e) {
        //handle the exception
        echo "Connection failed: " . $e->getmessage();
    }
    
}

function overwritePassword($email, $newpass) {
    $conn = connectDatabase();

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $newpass, $email);

    // Execute the statement
    if ($stmt->execute()) {
        // Password updated successfully
        return true;
    } else {
        // Error occurred while updating the password
        echo "error";
        return false;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}

function saveUser($name, $email, $pass) {
    $conn = connectDatabase();

    try {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $pass);

        if (!$stmt->execute()) {
            throw new Exception("Error executing statement: " . $stmt->error);
        }
        echo "New record created successfully";

        $stmt->close();

    } catch (Exception $e) {
        //handle the exception
        echo "An error occurred: " . $e->getmessage();
    }

        $conn->close();
}

function findUserByEmail($email) {
    $conn = connectDatabase();

    try {
        // Prepare and bind
        $stmt = $conn->prepare("SELECT name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);

        // Execute the query
        if (!$stmt->execute()) {
            throw new Exception("Error executing statement: " . $stmt->error);
        }
        
        // Bind the result variable
        $stmt->bind_result($userName, $userEmail, $userPassword);

        // Fetch the result (if any)
        $stmt->fetch();
        //echo $userName, $userEmail, $userPassword;

        // Close the statement
        $stmt->close();

        $conn->close();

        // Return an associative array with user data or false if not found
        if ($userEmail !== null) {
            return [
                'name' => $userName,
                'email' => $userEmail,
                'pass' => $userPassword,
            ];
        } else {
            return false;
        }
    } catch (Exception $e) {
        // Handle the exception, e.g., log the error or display an error message
        echo "An error occurred: " . $e->getMessage();
    }
}

?> 