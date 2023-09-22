<?php

/** Display the title for the about page. */
function showWebshopTitle() {
    echo 'Webshop';
}

/** Display the header for the about page. */
function showWebshopHeader() {
    echo 'Webshop';
}

/** Display the content for the about page. */
function showWebshopContent() {
    $products = getProducts();
    
    echo '<ul class="products">';

    foreach ($products as $product) {
        extract($product);

        echo '
        <ul class="productcard">
            <li>' . $id . '</li>
            <li><img src="images/' . $filenameimage . '"</li>
            <li class="productname">' . $name . '</li>
            <li class="description">' . $description . '</li>
            <li class="price">€' . $price . '</li>
        </ul>';
    }

    echo '</ul>';
}

?>