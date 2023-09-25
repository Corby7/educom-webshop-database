<?php

function connectDatabase() {
    $servername = "localhost";
    $username = "WebShopUser";
    $password = "1234";
    $dbname = "corbijns_webshop";

    //create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    //check connection
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
    echo "Connected successfully";
}

function overwritePassword($email, $newpass) {
    $conn = connectDatabase();

    try {
        $sql = "UPDATE users SET password = '$newpass' WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            throw new Exception("Updating password failed" . $sql . "error: " . mysqli_error($conn));
        }

        return true;
    } finally {
        mysqli_close($conn);
    }
}

function saveUser($name, $email, $pass) {
    $conn = connectDatabase();

    try {
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Saving user failed" . $sql . "error: " . mysqli_error($conn));
        }
        echo "New record created successfully";

    } finally {
        mysqli_close($conn);
    }
}

function getProduct($id) {
    $conn = connectDatabase();

    try {
        $sql = "SELECT * FROM products WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Get product failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result)) {
            $product = mysqli_fetch_assoc($result);
        }

        return $product; //return the array of product
        
    } finally {
        mysqli_close($conn);
    }
} 

function getProducts() {
    $conn = connectDatabase();

    try {
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Get products failed: " . mysqli_error($conn));
        }

        $products = array(); //create an array to store the products

        if (mysqli_num_rows($result)) {
            //fetch all rows as associative arrays and store them in the $products array
            while ($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
        }

        //free result set
        mysqli_free_result($result);

        return $products; //return the array of products
        
    } finally {
        mysqli_close($conn);
    }
}

function findUserByEmail($email) {
    $user = NULL;
    $conn = connectDatabase();

    try {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Find user failed" . $sql . "error: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result)) {
            $user = mysqli_fetch_assoc($result);
            //set password > pass
            $user['pass'] = $user['password'];
            unset($user['password']);
        }
        return $user;
        
    } finally {
        mysqli_close($conn);
    }
}

?> 