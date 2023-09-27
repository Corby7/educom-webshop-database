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
    echo '<ul class="topfiveproducts">';

    foreach ($data['products'] as $product) {
        $ranking += 1;
        extract($product);
        
        echo '
        <li class="topfiveproductcard">
            <a href="index.php?page=productpage&productid=' . $id . '" class="productlink">
                <ul>
                    <li><img src="images/' . $filenameimage . '"></li>
                    <div class="productcardbottom">
                        <div class="productcardleft">
                            <li class="ranking">' . $ranking . '.</li>
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
            </a>
        </li>';
    }

    echo '</ul>';
}

?>