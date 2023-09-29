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
    echo '<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">';
    showTitle($data);
    echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    ';
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
    echo '  <div>' . PHP_EOL; 
    showMenu(); 
    showHeader($data); 
    showContent($data); 
    showFooter(); 
    echo '  </div>' . PHP_EOL;
    echo '  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>' . PHP_EOL;         
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
    echo '<header class="py-3 ">' . PHP_EOL;
    echo '  <div class="container display-6">';
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
    echo '<nav class="navbar navbar-expand bg-primary py-2 d-flex justify-content-between">
        <div class"nav-left">  
            <a href="#" class="navbar-brand mx-2">Brand</a>
        </div>
        <div class"nav-center">
            <ul class="navbar-nav h6">';
                showMenuItem("home", "Home"); 
                showMenuItem("about", "About");
                showMenuItem("webshop", "Webshop");
                showMenuItem("topfive", "Top 5");
                showMenuItem("contact", "Contact");
            echo '</ul>';
        echo '</div>
        <div class="nav-right">
            <ul class="navbar-nav h7">';
                if(isUserLoggedIn()) {
                    echo '
                    <div class="dropdown">
                        <a class="nav-link px-4" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="Images/account.svg" alt="Account" width="40" height="35" class="white-svg">
                        </a>
                        <ul class="dropdown-menu bg-dark" aria-labelledby="dropdownMenuLink">
                            <li>
                                <a class="dropdown-item av-link link-body-emphasis px-3 active text-white bg-dark" href="index.php?page=settings">Change Password</a>
                            </li>
                            <li>
                                <a class="dropdown-item av-link link-body-emphasis px-3 active text-white bg-dark" href="index.php?page=logout">Logout: ' . getLoggedInUserName() . '</a>
                            </li>
                        </ul>
                    </div>

                    <a class="nav-link px-4" href="index.php?page=shoppingcart" role="button" id="shoppingcart">
                        <img src="Images/cart.svg" alt="Shopping Cart" width="40" height="35" class="white-svg">
                    </a>';
                    //showMenuItem("shoppingcart", "Shopping Cart");
                }
                if(!isUserLoggedIn()) {
                    showMenuItem("register", "Register"); 
                    showMenuItem("login", "Login");
                }
            echo '</ul>
        </div>
    </nav>'; 
} 

/**
 * Display a menu item with a link and text.
 *
 * @param string $link The link to the page.
 * @param string $text The text to display for the menu item.
 */
function showMenuItem($link, $text) {
        echo '<li class="nav-item"><a class="nav-link link-body-emphasis px-4 active text-white" href="index.php?page=' . $link . '">' . $text . '</a></li>';
}

/**
 * Display the content section of the HTML document.
 *
 * @param array $data An array containing input data for the response page.
 */
function showContent($data) {
    echo '<div class="container">' . PHP_EOL;
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

    //twitter, instagram verplaatsen met linkedin, github
    echo'
    <div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
      <div class="col-md-4 d-flex align-items-center">
        <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
          <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
        </a>
        <span class="mb-3 mb-md-0 text-body-secondary">&copy; 2023 Jules Corbijn Bulsink</span>
      </div>
  
        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" href="https://linkedin.com/in/jules-corbijn-bulsink"><svg class="bi" width="24" height="24"><use xlink:href="#linkedin"></use></svg></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="https://github.com/Corby7"><svg class="bi" width="24" height="24"><use xlink:href="#github"></use></svg></a></li>
      
        <svg class="bi d-none">
            <symbol id="github" viewBox="0 0 16 16">
                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.20-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.20-.36-1.02.08-2.12 0 0 .67-.21 2.20.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.20-.82 2.20-.82.44 1.10.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.20 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
            </symbol>
        </svg>

        <svg class="bi d-none">
            <symbol id="linkedin" viewBox="0 0 16 16">
                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
            </symbol>
        </svg>
        </ul>
    </footer>
  </div>';
}

?>  