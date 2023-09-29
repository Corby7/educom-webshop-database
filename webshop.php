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
            <a href="index.php?page=productpage&productid=' . $id . '" class="productlink">
                <div class="card h-100">
                <img src="images/' . $filenameimage . '" class="card-img-top" alt="' . $name . '">
                    <div class="card-body">
                        <h2 class="card-title">' . $name . '</h2>
                        <span class="card-subtitle">€' . $price . '</span>
                    </div>
                    <div class="card-footer">';
                    if (isUserLoggedIn()) {
                        echo '
                        <div>
                            <form method="post" action="index.php">
                                <input type="hidden" name="id" value=' . $id . '>
                                <input type="hidden" name="action" value="addtocart">
                                <button type="submit" name="page" value="shoppingcart" class="btn btn-primary">Add to cart</button>
                            </form>
                        </div>';
                    }
                    echo '
                    </div>
                </div>
            </a>
        </div>';
    }

    echo '</div>';
}


?>