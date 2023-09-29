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
            <a href="index.php?page=productpage&productid=' . $id . '" class="productlink">
                <div class="card flex-md-row h-60">
                    <img src="images/' . $filenameimage . '" class="image-fluid col-md-6" alt="' . $name . '">
                    <div class="card-body col-md-6">
                        <h5 class="card-title">' . $name . '</h5>
                        <p class="card-text">€' . $price . '</p>';
                        if (isUserLoggedIn()) {
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
            </a>
        </div>';
    }

    echo '</div>';
}

?>