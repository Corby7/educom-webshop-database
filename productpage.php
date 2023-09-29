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
    <div class="row">
        <div class="col-md-4">
            <img src="images/' . $filenameimage . '" class="img-fluid" alt="' . $name . '">
        </div>
        <div class="col-md-8">
            <div class="product-card product-info">
                <div class="card-body">
                    <h2 class="card-title product-name">' . $name . '</h2>
                    <p class="card-text price">€' . $price . '</p>
                    <p class="card-text description">' . $description . '</p>';
                    if(isUserLoggedIn()) {
                        echo '
                        <form method="post" action="index.php">
                            <input type="hidden" name="id" value=' . $id . '>
                            <input type="hidden" name="action" value="addtocart">
                            <button type="submit" name="page" value="shoppingcart" class="btn btn-primary">Add to cart</button>
                        </form>';
                    }
        echo '
                </div>
            </div>
        </div>
    </div>';
}

?>