<?php

/** Display the title for the product page. */
function showProductPageTitle($data) {
    extract($data['product']);

    echo $name;
}

/** Display the header for the product page. */
function showProductPageHeader() {
    echo 'Productpagina';
}

/** Display the content for the product page. */
function showProductPageContent($data) {
    extract($data['product']);

    echo '
    <ul class="product">
        <div class="productimage">
            <li><img src="images/' . $filenameimage . '"</li>
        </div>
        <div class="productinfo">
            <li class="productname">' . $name . '</li>
            <li class="price">€' . $price . '</li>
            <li class="description">' . $description . '</li>
        </div>
    </ul>';
}

?>