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
    $email = mysqli_real_escape_string($conn, $email);
    $newpass = mysqli_real_escape_string($conn, $newpass);

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
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $pass = mysqli_real_escape_string($conn, $pass);

    try {
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Saving user failed" . $sql . "error: " . mysqli_error($conn));
        }

    } finally {
        mysqli_close($conn);
    }
}

function findUserByEmail($email) {
    $conn = connectDatabase();
    $email = mysqli_real_escape_string($conn, $email);
    $user = NULL;

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

function getUserId($email) {
    $conn = connectDatabase();
    $email = mysqli_real_escape_string($conn, $email);

    try {
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Get userid failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result)) {
            $userid = mysqli_fetch_assoc($result);
        }

        return $userid;
        
    } finally {
        mysqli_close($conn);
    }
} 

function getProduct($id) {
    $conn = connectDatabase();
    $id = mysqli_real_escape_string($conn, $id);

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

function getProductsByIds(array $productids) {
    if (empty($productids)) {
        return array();
    }
    $conn = connectDatabase();

    try {
        $productidsString = implode(',', $productids);

        $sql = "SELECT * FROM products WHERE id IN ($productidsString)";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Get shopping cart products failed: " . mysqli_error($conn));
        }

        $cartProducts = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $cartProducts[$row['id']] = $row; 
        }

        mysqli_free_result($result);

        return $cartProducts;
        
    } finally {
        mysqli_close($conn);
    }
}

function getAllProducts() {
    $conn = connectDatabase();

    try {
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Get products failed: " . mysqli_error($conn));
        }

        $products = array(); //create an array to store the products

        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        //free result set
        mysqli_free_result($result);

        return $products; //return the array of products
        
    } finally {
        mysqli_close($conn);
    }
}

function getTopFiveProducts() {
    $conn = connectDatabase();

    try {
        $sql = "SELECT orderlines.product_id, SUM(orderlines.amount), orders.date, products.id, products.name, products.price, products.filenameimage 
        FROM orderlines
        LEFT JOIN orders ON orderlines.order_id = orders.id 
        LEFT JOIN products ON orderlines.product_id = products.id
        WHERE orders.date > DATE_SUB(NOW(), INTERVAL 1 WEEK)
        GROUP BY orderlines.product_id 
        ORDER BY SUM(orderlines.amount) 
        DESC LIMIT 5";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Get top 5 products failed: " . mysqli_error($conn));
        }

        $topproducts = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $topproducts[] = $row;
        }

        mysqli_free_result($result);

        return $topproducts;

    } finally {
    mysqli_close($conn);
    }
}

function createOrder($id, $cart) {
    $conn = connectDatabase();
    $id = mysqli_real_escape_string($conn, $id);

    try {
        mysqli_begin_transaction($conn);// <-- Alle SQL verandering hierna zijn nog niet doorgevoerd op de database die andere mensen kunnen zien, ze zijn alleen voor jou zichtbaar
        $sql = "INSERT INTO orders (user_id, `date`) VALUES ('$id', CURRENT_TIMESTAMP())";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Creating order failed: " . mysqli_error($conn));
        }

        $orderid = mysqli_insert_id($conn);

        foreach ($cart as $productid => $amount) {
            $sql = "INSERT INTO orderlines (order_id, product_id, amount) VALUES ('$orderid', '$productid', '$amount')";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                throw new Exception("Adding orderline failed: " . mysqli_error($conn));
            }
        }

        if (!mysqli_commit($conn)) {// <-- Commit alle veranderingen sinds 'begin_transaction'
            throw new Exception("Committing transaction failed");
        }

    } catch (Exception $e) {
        mysqli_rollback($conn);// <-- draai alle veranderingen sinds 'begin_transaction' terug
        throw $e;// <-- rethrow the exception
    } finally {
        mysqli_close($conn);
    }
}

?> 