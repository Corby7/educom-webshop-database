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

function getUserId($email) {
    $conn = connectDatabase();

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

function getCartProducts(array $productids) {
    $conn = connectDatabase();

    try {
        $productidsString = implode(',', $productids);

        $sql = "SELECT * FROM products WHERE id IN ($productidsString)";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Get shopping cart products failed: " . mysqli_error($conn));
        }

        $cartProducts = array();

        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $cartProducts[] = $row;
            }
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

function getTopFiveProducts() {
    $conn = connectDatabase();

    try {
        $sql = "SELECT orderlines.product_id, SUM(orderlines.amount), orders.date, products.id, products.name, products.price, products.filenameimage FROM orderlines
        LEFT JOIN orders ON orderlines.order_id = orders.id LEFT JOIN products ON orderlines.product_id = products.id
        WHERE orders.date BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() GROUP BY orderlines.product_id ORDER BY SUM(orderlines.amount) DESC LIMIT 5";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Get top 5 products failed: " . mysqli_error($conn));
        }

        $topproducts = array();

        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $topproducts[] = $row;
            }
        }

        mysqli_free_result($result);

        return $topproducts;

    } finally {
    mysqli_close($conn);
    }
}

function createOrderSQL($id, $date) {
    $conn = connectDatabase();

    try {
        $sql = "INSERT INTO orders (user_id, date) VALUES ('$id', '$date')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Creating order failed" . $sql . "error: " . mysqli_error($conn));
        }

    } finally {
        return mysqli_insert_id($conn);
        //mysqli_close($conn); only close database once instead of twice?
    }
}

function createOrderLineSQL($orderid, $cart) {
    $conn = connectDatabase();

    try {
        foreach ($cart as $productid => $amount) {
            $sql = "INSERT INTO orderlines (order_id, product_id, amount) VALUES ('$orderid', '$productid', '$amount')";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                throw new Exception("Adding orderline failed" . $sql . "error: " . mysqli_error($conn));
            }
        }

    } finally {
        mysqli_close($conn);
    }
}


?> 