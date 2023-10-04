<?php

/** Display the title for the top five products page. */
function showTopFiveTitle() {
    echo 'Top 5';
}

/** Display the header for the top five products page. */
function showTopFiveHeader() {
    echo 'Top 5 Producten';
}

/** Display the content for the top five products page. */
function showTopFiveContent($data) {
    $ranking = 0;
    echo '<div class="row">';

    foreach ($data['products'] as $product) {
        $ranking += 1;
        extract($product);
        
        echo '
        <div class="col-12 mb-4">
            <a href="index.php?page=productpage&productid=' . $id . '" class="productlink text-decoration-none">
                <div class="card flex-md-row h-60">
                    <img src="images/' . $filenameimage . '" class="top5product-img" alt="' . $name . '">
                    <div class="card-body col-md-6 d-flex gap-5">
                        <span class="card-title h2">' . $ranking . '.</span>
                        <div class="d-flex flex-column justify-content-evenly">
                            <span class="card-title h2">' . $name . '</span>
                            <p class="card-text h4">€' . $price . '</p>';
                            if (isUserLoggedIn()) {
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
            echo '      </div>
        
                    </div>
                </div>
            </a>
        </div>';
    }

    echo '</div>';
}

?>