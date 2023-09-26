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
        <a href="index.php?page=productpage&productid=' . $id . '" class="productlink">
            <ul class="productcard">
                <li>' . $id . '</li>
                <li><img src="images/' . $filenameimage . '"></li>
                <div class="productcardbottom">
                    <div class="productcardleft">
                        <li class="productname">' . $name . '</li>
                        <li class="price">€' . $price . '</li>
                    </div>
                    <div class="productcardright">';
                    if(isUserLoggedIn()) {
                        echo '
                        <li>
                            <form method="post" action="index.php">
                                <input type="hidden" name="id" value=' . $id . '>
                                <input type="hidden" name="action" value="addtocart">
                                <button type="submit" name="page" value="shoppingcart">Add to cart</button>
                            </form>
                        </li>';
                    }
                    echo '
                    </div>
                </div>
            </ul>
        </a>';
    }

    echo '</ul>';
}

?>