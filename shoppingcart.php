<?php

/** Display the title for the shoppingcart page. */
function showShoppingCartTitle() {
    echo 'Shopping cart';
}

/** Display the header for the shoppingcart page. */
function showShoppingCartHeader() {
    echo 'Shopping Cart';
}

/** Display the content for the shoppingcart page. */
function showShoppingCartContent($data) {
    echo '
    <div class="shoppingcart">
        <table>
            <tr>
                <th></th>
                <th>Artikel</th>
                <th>Prijs</th>
                <th>Aantal</th>
                <th>Subtotaal</th>
            </tr>';

            foreach ($data['products'] as $product) {
                extract($product);
                $quantity = $_SESSION['shoppingcart'][$id];
                
                echo '
                <tr>
                    <td><img src="images/' . $filenameimage . '"</td>
                    <td>' . $name . '</td>
                    <td>€' . $price . '</td>
                    <td>
                        <form method="post" action="index.php">
                            <input type="hidden" name="id" value=' . $id . '>
                            <input type="hidden" name="page" value="shoppingcart">
                            <button type="submit" name="action" value="removefromcart">-</button>
                            ' . $quantity . '
                            <button type="submit" name="action" value="addtocart">+</button>
                        </form>
                    </td>
                    <td>€' . $subtotal = $price * $quantity . '</td>
                </tr>';
            }
            
            echo '
            <tr>
                <th>Totaal:</th>
            </tr>
        </table>
    </div>';
}

function showEmptyShoppingCart() {
    echo 'Uw winkelmandje is leeg.';
}

?>