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
    <div class="row mt-4 d-flex justify-content-center align-items-center">
        <div class="col-md-4">
            <img src="images/' . $filenameimage . '" class="productpage-img" alt="' . $name . '">
        </div>
        <div class="col-md-8">
            <div class="product-card product-info">
                <div class="card-body">
                    <h2 class="card-title product-name">' . $name . '</h2>
                    <p class="card-text price h5">€' . $price . '</p>
                    <p class="card-text description">' . $description . '</p>';
                    if(isUserLoggedIn()) {
                        echo '
                        <form method="post" action="index.php">
                            <input type="hidden" name="id" value=' . $id . '>
                            <input type="hidden" name="action" value="addtocart">
                            <button type="submit" name="page" value="shoppingcart" class="btn btn-primary d-flex gap-2 pxy-2" id="button-invert">
                                <i class="bi bi-bag-plus"></i>
                                <span class="btn-text">Add to cart</span>
                            </button>
                        </form>';
                    }
        echo '
                </div>
            </div>
        </div>
    </div>';
}

?>