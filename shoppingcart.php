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
    if (empty($_SESSION['shoppingcart'])) {
        echo '<h1>Uw winkelmandje is leeg.</h1>';
        return;
    }

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

            foreach ($data['products']['cartLines'] as $cartline) {
                extract($cartline);
                
                echo '
                <tr>
                        <td><a href="index.php?page=productpage&productid=' . $id . '" class="productlink"><img src="images/' . $filenameimage . '"</a></td>
                        <td><a href="index.php?page=productpage&productid=' . $id . '" class="productlink">' . $name . '</a></td>
                    </a>
                    <td>€' . number_format($price,2) . '</td>
                    <td>
                        <form method="post" action="index.php">
                            <input type="hidden" name="id" value=' . $id . '>
                            <input type="hidden" name="page" value="shoppingcart">
                            <button type="submit" name="action" value="removefromcart">-</button>
                            ' . $quantity . '
                            <button type="submit" name="action" value="addtocart">+</button>
                        </form>
                    </td>
                    <td>€' . number_format($subtotal, 2) . '</td>
                </tr>';
            }
            
            echo '
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Totaalprijs: €' . number_format(($data['products']['total']), 2) . '</th>
            </tr>
        </table>
        <form method="post" action="index.php">
            <input type="hidden" name="id" value=' . $id . '>
            <button type="submit" name="page" value="checkout">Afrekenen</button>
        </form>
    </div>';
}

function showOrderSucces() {
    echo '<h1>Bedankt voor uw bestelling! Check uw mail voor de orderinfo.</h1>';
}

?>