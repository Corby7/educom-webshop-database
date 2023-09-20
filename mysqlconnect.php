<?php

$servername = "localhost";
$username = "WebShopUser";
$password = "1234";
$dbname = "corbijns_webshop";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

// // sql to create table
// $sql = "CREATE TABLE users (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     firstname VARCHAR(30) NOT NULL,
//     lastname VARCHAR(30) NOT NULL,
//     email VARCHAR(50) NOT NULL,
//     password VARCHAR(30) NOT NULL
//     )"; 
    
//     if ($conn->query($sql) === TRUE) {
//       echo "Table users created successfully";
//     } else {
//       echo "Error creating table: " . $conn->error;
//     }
    

// $sql = "INSERT INTO users (name, email, password)
// VALUES ('Corbijn Bulsink', 'corbijn.bulsink@hotmail.com', 'abcdef')";

// if (mysqli_query($conn, $sql)) {
//     echo "New record created successfully";
//   } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//   }

// $sql = "SELECT id, name, email FROM users";
// $result = mysqli_query($conn, $sql);

// if (mysqli_num_rows($result) > 0) {
//   // output data of each row
//   while($row = mysqli_fetch_assoc($result)) {
//     echo "id: " . $row["id"]. " - Name: " . $row["name"]. "huh " . $row["email"]. "<br>";
//   }
// } else {
//   echo "0 results";
// }

function saveUser($conn, $name, $email, $pass) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $pass);

    $stmt->execute();
    echo "New record created successfully";
    $stmt->close();

    $conn->close();
}

function findUserByEmail($conn, $email) {
    // Prepare and bind
    $stmt = $conn->prepare("SELECT name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    echo "Statement executed";
    
    // Bind the result variable
    $stmt->bind_result($userName, $userEmail, $userPassword);

    // Fetch the result (if any)
    $stmt->fetch();
    echo $userName, $userEmail, $userPassword;

    // Close the statement
    $stmt->close();

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
}

//$conn->close();

?> 