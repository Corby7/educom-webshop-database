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
    echo '<div class="row row-cols-1 row-cols-md-3 g-3">';

    foreach ($data['products'] as $product) {
        extract($product);
        
        echo '
        <div class="col">
            <a href="index.php?page=productpage&productid=' . $id . '" class="productlink text-decoration-none">
                <div class="card h-100">
                <img src="images/' . $filenameimage . '" class="card-img-top" alt="' . $name . '">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <span class="card-title h2">' . $name . '</span>
                            <span class="card-subtitle">€' . $price . '</span>
                        </div>
                        <div>';
                        if (isUserLoggedIn()) {
                            echo '
                            <div>
                                <form method="post" action="index.php">
                                    <input type="hidden" name="id" value=' . $id . '>
                                    <input type="hidden" name="action" value="addtocart">
                                    <button type="submit" name="page" value="shoppingcart" class="btn btn-primary d-flex gap-2 pxy-2 webshop-button" id="button-invert">
                                        <i class="bi bi-bag-plus"></i>
                                        <span class="btn-text">Add to cart</span>
                                    </button>
                                </form>
                            </div>';
                        }
                        echo '</div>
                    </div>
                </div>
            </a>
        </div>';
    }

    echo '</div>';
}


?>