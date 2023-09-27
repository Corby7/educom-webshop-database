<?php

session_start(); 

require('sessionmanager.php');
require('validations.php');
require('userservice.php');

require('home.php');
require('about.php');
require('webshop.php');
require('topfive.php');
require('productpage.php');
require('shoppingcart.php');
require('contact.php');
require('register.php');
require('login.php');
require('settings.php');
require('error.php');

function logError($message) {
    echo "LOG TO FILE: " . $message;
}

/** MAIN APP */
$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data);

/**
 * Get the requested page based on the request method.
 *
 * @param string $page The default page to return if the request method is not POST.
 * @return string The requested page.
 */
function getRequestedPage() {
    $requested_type = $_SERVER['REQUEST_METHOD'];
    if ($requested_type == 'POST') {
        $requested_page = getPostVar('page', 'home');
    } else {
        $requested_page = getUrlVar('page', 'home');
    }

    return $requested_page;
}

/**
 * Get a POST variable with optional default value.
 *
 * @param string $key The key to search for in the POST data.
 * @param string $default (optional) The default value to return if the key is not found.
 * @return string The value of the POST variable or the default if not found.
 */
function getPostVar($key, $default = '') {
    $value = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
    return isset($value) ? $value : $default;
}

/**
 * Get a URL variable with optional default value.
 *
 * @param string $key The key to search for in the URL.
 * @param string $default (optional) The default value to return if the key is not found.
 * @return string The value of the URL variable or the default if not found.
 */
function getUrlVar($key, $default = '') {
    $value = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
    return isset($value) ? $value : $default;
}


/**
 * Process the request and perform actions based on the page and request method.
 *
 * This function handles both GET and POST requests for different pages of the web application.
 * It performs the following steps:
 *
 * 1. Initialize form data for the specified page using `initializeFormData`.
 * 2. If the request method is POST:
 *    - For the "contact" page, validate the contact form data and update the page to "thanks" if the data is valid.
 *    - For the "register" page, validate the registration form data. If valid, save the user and update the page to "login."
 *    - For the "login" page, validate the login form data, authenticate the user, and set the user's session if successful.
 *      It also handles errors related to unknown users or wrong passwords.
 * 3. If the request method is GET:
 *    - For the "logout" page, log the user out and update the page to "home."
 *
 * Finally, it sets the page in the `$data` array and returns it.
 * 
 * @param string $page The current page.
 * @return array An array containing input data for the response page.
 */
function processRequest($page) {
    $data = initializeFormData($page);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        switch($page) {
            case 'contact':
                $data = validateContactForm($data);
                if($data['valid']) {
                    $page = "thanks";
                }
                break;

            case 'register':
                $data = validateRegisterForm($data);
                if ($data['valid']) {
                    extract($data);

                    storeUser($name, $email, $pass);
                    $page = "login";
                }
                break;

            case 'settings':
                $data = validateSettingsForm($data);
                if ($data['valid']) {
                    extract($data);

                    $data = updatePasswordByEmail($email, $newpass, $data);
                }
                break;

            case 'login':
                $data = validateLoginForm($data);
                if ($data['valid']) {
                    extract($data);

                    loginUser($username, $useremail);
                    $page = "home";
                }
                break;

            case 'shoppingcart':
                handleActions();
                if (empty($_SESSION['shoppingcart'])) {
                    $page = 'emptyshoppingcart';
                } else {
                    $data['products'] = populateCart();
                }
                break;
            
            case 'checkout':
                if (makeOrder()) {
                    $page = 'ordersucces';
                }
                break;
        }

        $data['page'] = $page;
        return $data;

    } else { //if GET request

        switch($page) {
            case 'logout':
                logoutUser();
                $page = "home";
                break;
                
            case 'webshop':
                $data['products'] = getAllProducts();
                break;
            
            case 'topfive':
                $data['products'] = getTopFiveProducts();
                break;

            case 'productpage':
                $productid = getUrlVar("productid");
                $data['product'] = getProduct($productid);
                $page = "productpage";
                break;

            case 'shoppingcart':
                if (empty($_SESSION['shoppingcart'])) {
                    $page = 'emptyshoppingcart';
                } else {
                    $data['products'] = populateCart();
                }
                break;
        }

        $data['page'] = $page;
        //var_dump($data);
        return $data;
    }
}

function handleActions() {
    $action = getPostVar("action");

    switch($action) {
        case "addtocart":
            $productid = getPostVar("id");
            addToCart($productid);
            break;
        case "removefromcart":
            $productid = getPostVar("id");
            removeFromCart($productid);
            break;
    }
}   

/**
 * Display the response page based on the input data.
 *
 * @param array $data An array containing input data for the response page.
 */
function showResponsePage($data) {
    beginDocument();
    showHeadSection($data);
    showBodySection($data);
    endDocument();
}

/** Begin the HTML document. */
function beginDocument() {
    echo '
    <!DOCTYPE html>
    <html>';
}

/**
 * Display the head section of the HTML document.
 *
 * @param array $data An array containing input data for the response page.
 */
function showHeadSection($data) {
    echo '    <head>' . PHP_EOL;
    echo '<link rel="stylesheet" href="CSS/style.css">';
    showTitle($data);
    echo '    </head>' . PHP_EOL;
}

/**
 * Display the title of the HTML document.
 *
 * @param array $data An array containing input data for the response page.
 */
function showTitle($data) {
    echo '<title>';
        switch ($data['page']) {
            case 'home':
                showHomeTitle();
                break;
            case 'about':
                showAboutTitle();
                break;
            case 'webshop':
                showWebshopTitle();
                break;
            case 'topfive':
                showTopFiveTitle();
                break; 
            case 'productpage':
                showProductPageTitle($data);
                break;
            case 'shoppingcart':
            case 'emptyshoppingcart':
            case 'ordersucces':
                showShoppingCartTitle();
                break;          
            case 'contact':
            case 'thanks':
                showContactTitle();
                break;
            case 'register':
                showRegisterTitle();
                break;
            case 'login':
                showLoginTitle();
                break;
            case 'settings':
                showSettingsTitle();
                break;        
            default:
                showErrorTitle();
                break;
        }
    echo '-ProtoWebsite</title>';
}

/**
 * Display the body section of the HTML document.
 *
 * @param array $data An array containing input data for the response page.
 */
function showBodySection($data) { 
    echo '<body>' . PHP_EOL;
    echo '  <div class="container">' . PHP_EOL; 
    showHeader($data); 
    showMenu(); 
    showContent($data); 
    showFooter(); 
    echo '  </div>' . PHP_EOL;         
    echo '</body>' . PHP_EOL;  
} 

/** End the HTML document. */
function endDocument() {
    echo '</html>';
}

/**
 * Display the header section of the HTML document.
 *
 * @param array $data An array containing input data for the response page.
 */
function showHeader($data) {
    echo '<header>' . PHP_EOL;
    echo '  <h1>';
    switch ($data['page']) {
        case 'home':
            showHomeHeader();
            break;
        case 'about':
            showAboutHeader();
            break;
        case 'webshop':
            showWebshopHeader();
            break; 
        case 'topfive':
            showTopFiveHeader();
            break; 
        case 'productpage':
            showProductPageHeader();
            break;       
        case 'shoppingcart':
        case 'emptyshoppingcart':
        case 'ordersucces':
            showShoppingCartHeader();
            break;  
        case 'contact':
        case 'thanks':
            showContactHeader();
            break;
        case 'register':
            showRegisterHeader();
            break;
        case 'login':
            showLoginHeader();
            break;
        case 'settings':
            showSettingsHeader();
            break;       
        default:
            showErrorHeader();
            break;
    }
    echo '  </h1>';
    echo '</header>' . PHP_EOL;
}

/** Display the menu section of the HTML document. */
function showMenu() { 
    echo '<nav>';  
    if(isUserLoggedIn()) {
        echo '<ul class="uppernav">';
        showMenuItem("settings", "Account Settings");
        showMenuItem("logout", "Logout: " . getLoggedInUserName());
        showMenuItem("shoppingcart", "Shopping Cart");
        echo '</ul>';
    }
    echo '<ul class="lowernav">';
    showMenuItem("home", "HOME"); 
    echo '|';
    showMenuItem("about", "ABOUT");
    echo '|'; 
    showMenuItem("webshop", "WEBSHOP");
    echo '|'; 
    showMenuItem("topfive", "TOP 5");
    echo '|';
    showMenuItem("contact", "CONTACT");
    if(!isUserLoggedIn()) {
        echo '|'; 
        showMenuItem("register", "REGISTER"); 
        echo '|';
        showMenuItem("login", "LOGIN");
    } 
    echo '
        </ul>  
    </nav>'; 
} 

/**
 * Display a menu item with a link and text.
 *
 * @param string $link The link to the page.
 * @param string $text The text to display for the menu item.
 */
function showMenuItem($link, $text) {
        echo '<li><a href="index.php?page=' . $link . '">' . $text . '</a></li>';
}

/**
 * Display the content section of the HTML document.
 *
 * @param array $data An array containing input data for the response page.
 */
function showContent($data) {
    echo '<div class="content">' . PHP_EOL;
    switch ($data['page']) {
        case 'home':
            showHomeContent();
            break;
        case 'about':
            showAboutContent();
            break;
        case 'webshop':
            showWebshopContent($data);
            break; 
        case 'topfive':
            showTopFiveContent($data);
            break; 
        case 'productpage':
            showProductPageContent($data);
            break; 
        case 'shoppingcart':
            showShoppingCartContent($data);
            break;
        case 'emptyshoppingcart':
            showEmptyShoppingCart();
            break;
        case 'ordersucces':
            showOrderSucces();
            break;
        case 'contact':
            showContactForm($data);
            break; 
        case 'thanks':
            showContactThanks($data);
            break;
        case 'register':
            showRegisterForm($data);
            break;
        case 'login':
            showLoginForm($data);
            break;
        case 'settings':
            showSettingsForm($data);
            break;
        default:
            showErrorContent();
            break;
    }
    echo '</div>' . PHP_EOL;
}

/** Display the footer section of the HTML document. */
function showFooter() {
    echo '
    <footer>
        <p>&copy; 2023 Jules Corbijn Bulsink</p>
    </footer>';
}

?>  