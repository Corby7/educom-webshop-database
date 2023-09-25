<?php

/** Display the title for the webshop page. */
function showWebshopTitle() {
    echo 'Webshop';
}

/** Display the header for the webshop page. */
function showWebshopHeader() {
    echo 'Webshop';
}

/** Display the content for the webshop page. */
function showWebshopContent($data) {
    echo '<ul class="products">';

    foreach ($data['products'] as $product) {
        extract($product);
        
        echo '
        <a href="index.php?page=productpage' . $id . '" class="productlink">
            <ul class="productcard">
                <li>' . $id . '</li>
                <li><img src="images/' . $filenameimage . '"</li>
                <li class="productname">' . $name . '</li>
                <li class="price">€' . $price . '</li>
            </ul>
        </a>';
    }

    echo '</ul>';
}

?>