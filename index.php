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
    echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">';
    echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">';
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
    echo '  <div class="wrapper d-flex flex-column justify-content-between min-vh-100 ">' . PHP_EOL; 
    showMenu();
    echo '<div class="container d-flex flex-column flex-grow-1">'; 
        showHeader($data); 
        showContent($data); 
    echo '</div>';
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
    echo '<header class="py-3">' . PHP_EOL;
    echo '  <div class="container h1 px-5 ">';
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

function GetIconMarkup($name, $class) {
    $svgContent = file_get_contents("Images/$name.svg");
    $svgContent = str_replace('<svg', '<svg class=' . $class . '', $svgContent); // Add class="icon" to the <svg> element
    return $svgContent;
}

/** Display the menu section of the HTML document. */
//nog met mobilefriendly bezig > offcanvas navbar
function showMenu() { 
    echo '<nav class="navbar navbar-expand py-2 d-flex justify-content-between">
        <a href="#" class="navbar-brand mx-2">' . GetIconMarkup('logo', 'icontop') . '</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

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
                    <div class="nav-item dropstart">
                        <button class="nav-link pe-4" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle pl-0"></i>
                        </button>
                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                            <li>
                                <a class="dropdown-item av-link link-body-emphasis px-3 active text-black bg-white fw-bold" href="index.php?page=settings">Wachtwoord wijzigen</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item av-link link-body-emphasis px-3 active text-black bg-white fw-bold" href="index.php?page=logout">Logout: ' . getLoggedInUserName() . '</a>
                            </li>
                        </ul>
                    </div>

                    <a class="nav-link px-4" href="index.php?page=shoppingcart" role="button" id="shoppingcart">
                        <i class="bi bi-bag-check"></i>
                    </a>';
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
    echo '<div class="container px-5">' . PHP_EOL;
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
    echo'
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 mx-2 d-flex align-items-center">
                <a class="text-body-secondary" href="#" class="navbar-brand mx-2">' . GetIconMarkup('logo', 'iconbot') . '</a>
                <span class="mb-3 mb-md-0 text-body-secondary fst-italic">&copy; 2023 Jules Corbijn Bulsink</span>
            </div>
    
            <ul class="nav col-md-4 mx-2 justify-content-end list-unstyled d-flex">
                <li class="ms-3 mx-2"><a class="text-body-secondary" href="https://linkedin.com/in/jules-corbijn-bulsink"><i class="bi bi-linkedin"></i></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="https://github.com/Corby7"><i class="bi bi-github"></i></a></li>
            </ul>
        </footer>
    </div>';
}

?>  